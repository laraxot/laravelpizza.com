<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
use Throwable;

use function Safe\json_encode;

/**
 * Sends one test email through the Mailtrap API.
 *
 * Lives in Notify because mail delivery belongs to this module; it is auto-registered by
 * XotBaseServiceProvider::registerCommands(). Never put it under `laravel/app/Console`.
 * Useful after a DNS change (SPF/DKIM CNAMEs) to prove the sending domain delivers.
 *
 * @see Modules/Notify/docs/command-ownership.md
 */
final class SendTestMail extends Command
{
    protected $signature = 'notify:test-mail
                            {recipient? : Recipient address (default: services.mailtrap.test_recipient)}
                            {--subject= : Subject of the test email}';

    protected $description = 'Send a test email using the Mailtrap API';

    public function handle(): int
    {
        $apiKey = $this->configString('services.mailtrap.api_key');

        if ($apiKey === '') {
            $this->error('MAILTRAP_API_KEY is not configured (services.mailtrap.api_key).');

            return self::FAILURE;
        }

        $recipient = $this->textInput($this->argument('recipient'))
            ?: $this->configString('services.mailtrap.test_recipient');

        if ($recipient === '') {
            $this->error('No recipient: pass the argument or set MAILTRAP_TEST_RECIPIENT.');

            return self::FAILURE;
        }

        $email = (new MailtrapEmail)
            ->from(new Address(
                $this->configString('mail.from.address', 'noreply@fixcity.eu'),
                $this->configString('mail.from.name', 'FixCity'),
            ))
            ->to(new Address($recipient))
            ->subject($this->textInput($this->option('subject')) ?: 'FixCity test email')
            ->category('Integration Test')
            ->text('Test email sent by FixCity (notify:test-mail).');

        try {
            $response = MailtrapClient::initSendingEmails(
                apiKey: $apiKey,
                isBulk: false,
            )->send($email);

            $this->info('Email sent successfully to '.$recipient.'.');
            $this->line(json_encode(ResponseHelper::toArray($response)));

            return self::SUCCESS;
        } catch (Throwable $exception) {
            report($exception);
            $this->error('Error sending test email. Check the application log for details.');

            return self::FAILURE;
        }
    }

    /** A config value as string; anything else (unset env, array) counts as the default. */
    private function configString(string $key, string $default = ''): string
    {
        $value = config($key);

        return is_string($value) ? $value : $default;
    }

    /** Artisan arguments/options are mixed; only a real string is usable. */
    private function textInput(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }
}
