<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Invia una mail di prova attraverso un mailer preciso (default: Postfix locale via sendmail).
 *
 * "Accettata" significa solo che il mailer l'ha presa in carico: con Postfix il rifiuto del
 * destinatario arriva dopo, come bounce. Per la consegna vera: bashscripts/docs/mail/mail-server.md.
 */
class TestSendmail extends Command
{
    /** @var string */
    protected $signature = 'notify:test-sendmail
        {to : Indirizzo destinatario}
        {--mailer=sendmail : Mailer di config/mail.php da usare}';

    /** @var string */
    protected $description = 'Send a test email through a specific mailer (default: local Postfix via sendmail)';

    public function handle(): int
    {
        $to = (string) $this->argument('to');
        $mailer = (string) $this->option('mailer');

        if (filter_var($to, FILTER_VALIDATE_EMAIL) === false) {
            $this->error("Indirizzo non valido: {$to}");

            return self::INVALID;
        }

        if (! is_array(config("mail.mailers.{$mailer}"))) {
            $this->error("Mailer non configurato in config/mail.php: {$mailer}");

            return self::INVALID;
        }

        $body = "Mail di prova inviata dal server tramite il mailer '{$mailer}' il ".now()->toDateTimeString().'.';

        try {
            Mail::mailer($mailer)->raw($body, static function (Message $message) use ($to): void {
                $message->to($to)->subject('Test email from FixCity server');
            });
        } catch (Throwable $e) {
            $this->error("Invio fallito con '{$mailer}': {$e->getMessage()}");

            return self::FAILURE;
        }

        $this->info("Accettata dal mailer '{$mailer}' per {$to}. Verificare la consegna (mailq, bounce, casella).");

        return self::SUCCESS;
    }
}
