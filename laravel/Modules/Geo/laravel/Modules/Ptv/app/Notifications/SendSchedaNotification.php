<?php

declare(strict_types=1);

namespace Modules\Ptv\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendSchedaNotification extends Notification
{
    use Queueable;

    public string $subject;

    public string $body;

    public string $pdfContent;

    public string $filename;

    public function __construct(string $subject, string $body, string $pdfContent, string $filename)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->pdfContent = $pdfContent;
        $this->filename = $filename;
    }

    /**
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line($this->body)
            ->attachData($this->pdfContent, $this->filename, [
                'mime' => 'application/pdf',
            ]);
    }
}
