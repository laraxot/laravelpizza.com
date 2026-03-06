<?php

declare(strict_types=1);

use Illuminate\Mail\Mailables\Address;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

test('email data email envelope uses explicit sender and subject', function (): void {
    $emailData = new EmailData(
        recipient: 'recipient@example.test',
        subject: 'Subject Line',
        body_html: '<p>Hello</p>',
        from: 'Notify Sender',
        from_email: 'sender@example.test',
    );

    $mailable = new EmailDataEmail($emailData);
    $envelope = $mailable->envelope();

    expect($envelope->subject)->toBe('Subject Line')
        ->and($envelope->from)->toBeInstanceOf(Address::class)
        ->and($envelope->from->address)->toBe('sender@example.test')
        ->and($envelope->from->name)->toBe('Notify Sender');
});

test('email data email content uses notify views and exposes email data', function (): void {
    $emailData = new EmailData(
        recipient: 'recipient@example.test',
        subject: 'Subject Line',
        body_html: '<p>Hello</p>',
    );

    $mailable = new EmailDataEmail($emailData);
    $content = $mailable->content();

    expect($content->html)->toBe('notify::emails.html')
        ->and($content->text)->toBe('notify::emails.text')
        ->and($content->with['email_data'])->toBe($emailData);
});

test('email data email has no attachments by default', function (): void {
    $emailData = new EmailData(
        recipient: 'recipient@example.test',
        subject: 'Subject Line',
        body_html: '<p>Hello</p>',
    );

    $mailable = new EmailDataEmail($emailData);

    expect($mailable->attachments())->toBeArray()
        ->and($mailable->attachments())->toHaveCount(0);
});
