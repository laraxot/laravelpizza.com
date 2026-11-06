<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Datas\SmsData;

/**
 * Class SmsNotification
 *
 * Notification class for sending SMS messages through various providers.
 */
class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The SMS data.
     */
    protected SmsData $smsData;

    /**
     * Additional configuration options.
     *
     * @var array<string, mixed>
     */
    protected array $config;

    /**
     * Create a new notification instance.
     *
     * @param  string|SmsData  $content  The content of the SMS or SmsData object
     * @param  array<string, mixed>  $config  Configuration options including provider
     */
    public function __construct(string|SmsData $content, array $config = [])
    {
        if ($content instanceof SmsData) {
            $this->smsData = $content;
        } else {
            $recipient = $config['recipient'] ?? ($config['to'] ?? '');
            $from = $config['from'] ?? '';

            $this->smsData = SmsData::from([
                'body' => $content,
                'recipient' => is_scalar($recipient) ? (string) $recipient : '',
                'from' => is_scalar($from) ? (string) $from : '']);
        }

        $this->config = $config;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  object  $notifiable  The entity to be notified (l'entità da notificare)
     * @return array<int, class-string>
     */
    public function via(object $notifiable): array
    {
        return [SmsChannel::class];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): SmsData
    {
        // If the notifiable entity has a routeNotificationForSms method,
        // we'll use that to get the destination phone number
        if (method_exists($notifiable, 'routeNotificationForSms')) {
            $routeResult = $notifiable->routeNotificationForSms($this);
            $this->smsData->recipient = is_scalar($routeResult) ? (string) $routeResult : '';
        }

        return $this->smsData;
    }

    /**
     * Get the provider configuration for this notification.
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get the provider to use for sending the SMS.
     */
    public function getProvider(): ?string
    {
        $provider = $this->config['provider'] ?? null;

        return is_string($provider) ? $provider : null;
    }
}
