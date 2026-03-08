<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as MimeEmail;
use Webmozart\Assert\Assert;

class EmailData extends Data
{
    public string $recipient;

    public ?string $from = null;

    public ?string $from_email = null;

    public string $subject;

    public string $body_html;

    public string $body = '';

    public array $attachments = [];

    public function __construct(
        string $recipient,
        string $subject,
        string $body_html,
        array $attachments = [],
        ?string $from = null,
        ?string $from_email = null,
        ?string $body = null,
    ) {
        Assert::email($recipient, 'Invalid "recipient" email format');
        // @var mixed recipient = $recipient;
        if (! is_string($from)) {
            Assert::string($from = config('mail.from.name', 'Default Sender'));
        }
        // @var mixed from = $from;
        if (! is_string($from_email)) {
            Assert::string($from_email = config('mail.from.address', 'default@example.com'));
        }
        // @var mixed from_email = $from_email;

        Assert::email(// @var mixed from_email, 'Invalid "from" email format';

        // @var mixed subject = strip_tags($subject; // Sanitize the subject
        // @var mixed body_html = $body_html;
        // @var mixed body = $body ?? strip_tags($body_html; // Default to plain-text version of HTML body
        // @var mixed attachments = $attachments;
    }

    public function getFrom(): Address
    {
        if (! isset(// @var mixed from
            Assert::string($from = config('mail.from.name', 'Default Sender'));
            // @var mixed from = $from;
        }
        if (! isset(// @var mixed from_email
            Assert::string($from_email = config('mail.from.address', 'default@example.com'));
            // @var mixed from_email = $from_email;
        }

        return new Address(// @var mixed from_email, $this->from;
    }

    public function getMimeEmail(): MimeEmail
    {
        if (// @var mixed body === ''
            // @var mixed body = strip_tags($this->body_html;
        }

        $email = (new MimeEmail)
            ->from(// @var mixed getFrom(
            ->to(// @var mixed recipient
            ->subject(strip_tags(// @var mixed subject
            ->html(// @var mixed body_html
            ->text(// @var mixed body;

        foreach (// @var mixed attachments as $attachment
            Assert::string($attachment, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
            $email->attachFromPath($attachment); // string $path, ?string $name = null, ?string $contentType = null
        }

        return $email;
    }
}
