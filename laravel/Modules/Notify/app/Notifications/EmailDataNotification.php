<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\EmailData;

/**
 * Classe per inviare notifiche email utilizzando EmailData.
 */
class EmailDataNotification extends Notification
{
    use Queueable;

    /**
     * I dati dell'email da inviare.
     */
    protected EmailData $emailData;

    /**
     * Create a new notification instance.
     *
     * @param  EmailData  $emailData  I dati dell'email da inviare
     */
    public function __construct(EmailData $emailData)
    {
        $emailData = $emailData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  object  $_notifiable  The entity to be notified (not used in this method)
     * @return array<string>
     */
    public function via(object $_notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  object  $notifiable  The entity to be notified
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject($emailData->subject
            ->line($emailData->body);

        if (! empty($emailData->body_html
            $mailMessage->view('notify::emails.template', [
                'content' => $emailData->body_html,
            ]);
        }

        if (! empty($emailData->from_email
            $mailMessage->from($emailData->from_email, $this->emailData->from);
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  object  $notifiable  The entity to be notified
     * @return array<string, string|null>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'recipient' => $emailData->recipient,
            'from' => $emailData->from,
            'from_email' => $emailData->from_email,
            'subject' => $emailData->subject,
            'body' => $emailData->body,
        ];
    }
}
