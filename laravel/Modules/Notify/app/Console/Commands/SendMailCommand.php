<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Datas\SmtpData;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Notify\Notifications\EmailDataNotification;
use Webmozart\Assert\Assert;

class SendMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:send-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email using user-provided details';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Assert::string($from = config('mail.from.name', 'Default Sender'));
        Assert::string($from_email = config('mail.from.address', 'default@example.com'));
        $data = [];
        $data['to'] = $this->ask('Enter the recipient\'s email address');
        $data['subject'] = $this->ask('Enter the subject of the email');
        $data['from'] = $this->ask('Enter the sender\'s name', $from);
        $data['from_email'] = $this->ask('Enter the sender\'s email address', $from_email);
        $data['body_html'] = $this->ask('Enter the HTML body of the email', '<p>This is a default HTML body</p>');
        // $data['body'] = $this->ask('Enter the plain text body of the email (leave blank to use stripped HTML body)') ?? strip_tags( $data['body_html']);

        $emailData = EmailData::from($data);

        SmtpData::make()->send($emailData);

        /*
         * Notification::route('mail', $emailData->to)
         * ->notify(new EmailDataNotification($emailData));
         */
        // Mail::to($emailData->to)->send(new EmailDataEmail($emailData));

        $this->info('Email sent successfully to ' . $emailData->to);

        return Command::SUCCESS;
    }
}
