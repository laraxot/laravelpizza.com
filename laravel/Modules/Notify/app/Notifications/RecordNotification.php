<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Emails\SpatieEmail;

class RecordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var array<string, mixed> */
    public array $data = [];

    /** @var array<int, array<string, string>> */
    public array $attachments = [];

    protected Model $record;

    protected string $slug;

    public function __construct(Model $record, string $slug)
    {
        $this->record = $record;
        $this->slug = Str::slug($slug);
    }

    /**
     * Get the notification's delivery channels.
     *
     * Determines channels based on the notifiable's routing capabilities.
     * Uses `routeNotificationFor()` method to check if the notifiable supports each channel.
     *
     * @param  object  $notifiable  The entity to be notified
     * @return array<string|class-string>
     */
    public function via(object $notifiable): array
    {
        $channels = [];
        if (! method_exists($notifiable, 'routeNotificationFor')) {
            return $channels;
        }
        if ($notifiable->routeNotificationFor('mail')) {
            $channels[] = 'mail';
        }
        if ($notifiable->routeNotificationFor('sms')) {
            $channels[] = SmsChannel::class;
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * Delegates completely to SpatieEmail for content generation.
     * This follows the Zen Delegation pattern: RecordNotification is a bridge,
     * SpatieEmail handles all template resolution, placeholder replacement, and layout logic.
     *
     * @param  object  $notifiable  The entity to be notified
     * @return SpatieEmail Configured SpatieEmail instance ready to send
     */
    public function toMail(object $notifiable): SpatieEmail
    {
        $email = new SpatieEmail($this->record, $this->slug);
        $email = $email->mergeData($this->data);

        $email = $email->addAttachments($this->attachments);

        // Set recipient for envelope() method in SpatieEmail
        // Note: Laravel's Notification system handles recipient routing via Notification::route(),
        // but we set it here for SpatieEmail's envelope() method which uses $this->recipient
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('mail');
            if (is_string($to) && $to !== '') {
                $email->setRecipient($to);
            }
        }

        return $email;
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): ?SmsData
    {
        $email = new SpatieEmail($this->record, $this->slug);

        $email = $email->mergeData($this->data);

        // If the notifiable entity has a routeNotificationForSms method,
        // we'll use that to get the destination phone number
        // dddx($notifiable);//Illuminate\Notifications\AnonymousNotifiable
        $to = null;
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('sms');
        }
        $fallback_to = config('sms.fallback_to');
        if (is_string($fallback_to)) {
            $to = $fallback_to;
        }
        if ($to === null) {
            return null;
        }

        // Build SMS content using SpatieEmail (which handles template resolution and placeholder replacement)
        $smsBody = $email->buildSms();

        // Wrap in SmsData for the SmsChannel (ensure all values are strings for type safety)
        /** @var array<string, string> $smsDataArray */
        $smsDataArray = [
            'from' => 'Xot',
            'recipient' => $to,
            'body' => $smsBody,
        ];

        return SmsData::from($smsDataArray);
    }

    /**
     * Merge additional data with record attributes for placeholder replacement.
     *
     * @param  array<string, mixed>  $data  Additional data to merge
     * @return $this
     */
    public function mergeData(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Add attachments to the notification.
     *
     * @param  array<int, array<string, string>>  $attachments  Array of attachment data
     * @return $this
     */
    public function addAttachments(array $attachments): self
    {
        $this->attachments = array_merge($this->attachments, $attachments);

        return $this;
    }
}
