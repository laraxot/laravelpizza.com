<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusChangedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public mixed $ticket, // Using mixed type since Ticket model doesn't exist
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function via(mixed $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ticket Status Changed')
            ->line("Ticket status has changed from {$this->oldStatus} to {$this->newStatus}")
            ->action('View Ticket', url('/'));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
        ];
    }
}
