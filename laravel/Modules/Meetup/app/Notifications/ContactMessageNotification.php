<?php

declare(strict_types=1);

namespace Modules\Meetup\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $senderName,
        public readonly string $senderEmail,
        public readonly string $body,
        string $locale,
    ) {
        $this->locale = $locale;
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject((string) __('meetup::contact_form.mail.subject', ['name' => $this->senderName], 'it'))
            ->replyTo($this->senderEmail, $this->senderName)
            ->line((string) __('meetup::contact_form.mail.from', ['name' => $this->senderName, 'email' => $this->senderEmail], 'it'))
            ->line((string) __('meetup::contact_form.mail.language', ['locale' => (string) $this->locale], 'it'))
            // MailMessage::line() fa l'escape del testo: niente HTML dal visitatore nella mail.
            ->line($this->body);
    }
}
