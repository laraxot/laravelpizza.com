<?php

declare(strict_types=1);

namespace Modules\Job\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Job\Models\Task;

class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The task output.
     */
    private readonly string $output;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $output)
    {
        $this->output = $output;
    }

    /**
     * Get the notification's delivery channels.
     */
    // public function via(mixed $notifiable): array {
    public function via(Task $notifiable): array
    {
        $channels = [];
        if ($notifiable->notification_email_address) {
            $channels[] = 'mail';
        }

        if ($notifiable->notification_phone_number) {
            $channels[] = 'nexmo';
        }

        if ($notifiable->notification_slack_webhook !== '' && $notifiable->notification_slack_webhook !== '0') {
            $channels[] = 'slack';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(Task $task): MailMessage
    {
        return (new MailMessage)
            ->subject($task->description)
            ->greeting('Hi,')
            ->line(sprintf('%s just finished running.', $task->description))
            ->line($this->output);
    }

    /*
     * Get the Nexmo / SMS representation of the notification.
     *
     * public function toNexmo(mixed $notifiable): NexmoMessage
     * {
     * return (new NexmoMessage())
     * ->content($notifiable->description.' just finished running.');
     * }
     */
    /*
     * Get the Slack representation of the notification.
     *
     * public function toSlack(mixed $notifiable): SlackMessage
     * {
     * return (new SlackMessage())
     * ->content(config('app.name'))
     * ->attachment(function (SlackAttachment $attachment) use ($notifiable) {
     * $attachment
     * ->title('Totem Task')
     * ->content($notifiable->description.' just finished running.');
     * });
     * }
     */
}
