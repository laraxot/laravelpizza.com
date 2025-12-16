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
    /**
     * @return array<int, string>
     */
    public function via(Task $notifiable): array
    {
        $result = [];
        
        $emailAddress = $notifiable->attributes['notification_email_address'] ?? null;
        if ($emailAddress) {
            $result[] = 'mail';
        }

        $phoneNumber = $notifiable->attributes['notification_phone_number'] ?? null;
        if ($phoneNumber) {
            $result[] = 'nexmo';
        }

        $slackWebhook = $notifiable->attributes['notification_slack_webhook'] ?? null;
        if ($slackWebhook !== null && $slackWebhook !== '' && $slackWebhook !== '0') {
            $result[] = 'slack';
        }

        return $result;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(Task $task): MailMessage
    {
        $descriptionValue = $task->attributes['description'] ?? 'Task';
        $description = is_string($descriptionValue) ? $descriptionValue : 'Task';
        
        $message = new MailMessage();
        $message->subject($description);
        $message->greeting('Hi,');
        $message->line(sprintf('%s just finished running.', $description));
        $message->line($this->output);
        
        return $message;
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
