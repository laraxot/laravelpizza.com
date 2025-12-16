<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as MimeEmail;
use Webmozart\Assert\Assert;

class EmailData extends Data
{
    public string $to;

    public null|string $from = null;

    public null|string $from_email = null;

    public string $subject;

    public string $body_html;

    public string $body = '';

    public array $attachments = [];

    public function __construct(
        string $to,
        string $subject,
        string $body_html,
        array $attachments = [],
        null|string $from = null,
        null|string $from_email = null,
        null|string $body = null,
    ) {
        Assert::email($to, 'Invalid "to" email format');
        $this->to = $to;
        if (!is_string($from)) {
            Assert::string($from = config('mail.from.name', 'Default Sender'));
        }
        $this->from = $from;
        if (!is_string($from_email)) {
            Assert::string($from_email = config('mail.from.address', 'default@example.com'));
        }
        $this->from_email = $from_email;

        Assert::email($this->from_email, 'Invalid "from" email format');

        $this->subject = strip_tags($subject); // Sanitize the subject
        $this->body_html = $body_html;
        $this->body = $body ?? strip_tags($body_html); // Default to plain-text version of HTML body
        $this->attachments = $attachments;
    }

    public function getFrom(): Address
    {
        if (!isset($this->from)) {
            Assert::string($from = config('mail.from.name', 'Default Sender'));
            $this->from = $from;
        }
        if (!isset($this->from_email)) {
            Assert::string($from_email = config('mail.from.address', 'default@example.com'));
            $this->from_email = $from_email;
        }

        return new Address($this->from_email, $this->from);
    }

    public function getMimeEmail(): MimeEmail
    {
        if ($this->body === '') {
            $this->body = strip_tags($this->body_html);
        }

        $email = new MimeEmail()
            ->from($this->getFrom())
            ->to($this->to)
            ->subject(strip_tags($this->subject))
            ->html($this->body_html)
            ->text($this->body);

        foreach ($this->attachments as $attachment) {
            Assert::string($attachment, __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
            $email->attachFromPath($attachment); // string $path, ?string $name = null, ?string $contentType = null
        }

        return $email;
    }
}
