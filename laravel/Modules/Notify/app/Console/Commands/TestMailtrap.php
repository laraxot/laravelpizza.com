<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

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
            return Command::FAILURE;
        }

        if (! is_string($recipient) || $recipient === '') {
            $this->error('MAILTRAP_TEST_RECIPIENT is not configured');
            return Command::FAILURE;
        }

        // Create the email using the Mailtrap SDK
        $email = (new MailtrapEmail())
            ->from(new Address(
                (string) config('mail.from.address', 'noreply@fixcity.eu'),
                (string) config('mail.from.name', 'FixCity'),
            ))
            ->to(new Address($recipient))
            ->subject('You are awesome!')
            ->category('Integration Test')
            ->text('Congrats for sending test email with Mailtrap!')
        ;

        try {
            // Send the email via Mailtrap
            $response = MailtrapClient::initSendingEmails(
                apiKey: $apiKey,
                isBulk: false
            )->send($email);

            $this->info('Test email sent successfully!');
            $this->info('Response: ' . print_r(ResponseHelper::toArray($response), true));
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error sending test email: ' . $e->getMessage());
            $this->error('Trace: ' . $e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
