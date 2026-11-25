<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Mail\Mailjet;

use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mailer\Bridge\Mailjet\Transport\MailjetTransportFactory;
use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Trasporto Mailjet (Send API v3.1) per il mailer Laravel `mailjet`.
 *
 * Usa il bridge ufficiale `symfony/mailjet-mailer`: Laravel non ha un driver Mailjet, ma accetta
 * qualunque trasporto Symfony con `Mail::extend()` (registrato in NotifyServiceProvider).
 *
 * - `api` (default): HTTPS su api.mailjet.com, piu' veloce dell'SMTP e con CustomID / EventPayload
 *   che tornano nei webhook (header `X-MJ-CustomID`, `X-MJ-EventPayload`).
 * - `smtp`: in-v3.mailjet.com:587, per hosting che bloccano le chiamate HTTP in uscita.
 * - `sandbox`: Mailjet valida il messaggio e risponde come per un invio, ma non consegna nulla.
 *
 * @see Modules/Notify/docs/email/mailjet.md
 * @see docs/contracts/create-mailjet-transport-action.md
 *
 * @contract docs/contracts/create-mailjet-transport-action.md
 */
final class CreateMailjetTransportAction
{
    use QueueableAction;

    public function execute(
        string $key,
        string $secret,
        bool $sandbox = false,
        string $scheme = 'api',
        ?HttpClientInterface $client = null,
    ): TransportInterface {
        if (\trim($key) === '' || \trim($secret) === '') {
            throw new InvalidArgumentException('Mailjet: mancano MAILJET_APIKEY_PUBLIC e MAILJET_APIKEY_PRIVATE (services.mailjet.key / secret).');
        }

        if (! \in_array($scheme, ['api', 'smtp'], true)) {
            throw new InvalidArgumentException(\sprintf('Mailjet: schema "%s" non valido, usare "api" o "smtp".', $scheme));
        }

        $options = $scheme === 'api' ? [
            'sandbox' => $sandbox ? 'true' : 'false',
        ] : [];

        $factory = new MailjetTransportFactory(null, $client ?? HttpClient::create());

        return $factory->create(new Dsn(
            'mailjet+'.$scheme,
            'default',
            $key,
            $secret,
            null,
            $options,
        ));
    }
}
