<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Emails;

use Illuminate\Mail\Mailables\Address;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

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

    Assert::assertInstanceOf(Address::class, $envelope->from);
    Assert::assertSame('sender@example.test', $envelope->from->address);
    Assert::assertSame('Notify Sender', $envelope->from->name);
    Assert::assertSame('Subject Line', $envelope->subject);
});

test('email data email content uses notify views and exposes email data', function (): void {
    $emailData = new EmailData(
        recipient: 'recipient@example.test',
        subject: 'Subject Line',
        body_html: '<p>Hello</p>',
    );

    $mailable = new EmailDataEmail($emailData);
    $content = $mailable->content();

    Assert::assertSame('notify::emails.html', $content->html);
    Assert::assertSame('notify::emails.text', $content->text);
    Assert::assertSame($emailData, $content->with['email_data']);
});

test('email data email has no attachments by default', function (): void {
    $emailData = new EmailData(
        recipient: 'recipient@example.test',
        subject: 'Subject Line',
        body_html: '<p>Hello</p>',
    );

    $mailable = new EmailDataEmail($emailData);
    $attachments = $mailable->attachments();
    Assert::assertCount(0, $attachments);
});
