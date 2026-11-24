<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
use Throwable;
use Webmozart\Assert\Assert;

class TestMailtrap extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'notify:test-mailtrap';

    /**
     * The console command description.
     */
    protected $description = 'Send a test email using Mailtrap';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $apiKey = config('services.mailtrap.api_key');
        $recipient = config('services.mailtrap.test_recipient');

        if (! is_string($apiKey) || $apiKey === '') {
            $this->error('MAILTRAP_API_KEY is not configured');

            return self::FAILURE;
        }

        if (! is_string($recipient) || $recipient === '') {
            $this->error('MAILTRAP_TEST_RECIPIENT is not configured');

            return self::FAILURE;
        }

        $fromAddress = config('mail.from.address', 'noreply@fixcity.eu');
        $fromName = config('mail.from.name', 'FixCity');
        Assert::string($fromAddress);
        Assert::string($fromName);

<<<<<<< HEAD
        $email = (new MailtrapEmail)
            ->from(new Address($fromAddress, $fromName))
            ->to(new Address($recipient))
            ->subject('You are awesome!')
            ->category('Integration Test')
            ->text('Congrats for sending test email with Mailtrap!');

        try {
            $response = MailtrapClient::initSendingEmails(
                apiKey: $apiKey,
                isBulk: false,
            )->send($email);
=======
        $email = new MailtrapEmail;
        $email->from(new Address($fromAddress, $fromName));
        $email->to(new Address($recipient));
        $email->subject('You are awesome!');
        $email->category('Integration Test');
        $email->text('Congrats for sending test email with Mailtrap!');

        try {
            $client = MailtrapClient::initSendingEmails(
                apiKey: $apiKey,
                isBulk: false,
            );
            $response = $client->send($email);
>>>>>>> laraxot/dev

            $this->info('Test email sent successfully!');
            $this->line(print_r(ResponseHelper::toArray($response), true));

            return self::SUCCESS;
        } catch (Throwable $e) {
            report($e);
            $this->error('Error sending test email. Check the application log for details.');

            return self::FAILURE;
        }
    }
}
