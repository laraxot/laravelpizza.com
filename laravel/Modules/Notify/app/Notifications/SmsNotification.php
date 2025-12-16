<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\SmsData;

/**
 * Class SmsNotification
 *
 * Notification class for sending SMS messages through various providers.
 *
 * @package Modules\Notify\Notifications
 */
class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The SMS data.
     *
     * @var SmsData
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
     * @param string|SmsData $content The content of the SMS or SmsData object
     * @param array<string, mixed> $config Configuration options including provider
     */
    public function __construct(string|SmsData $content, array $config = [])
    {
        if ($content instanceof SmsData) {
            $this->smsData = $content;
        } else {
            $to = $config['to'] ?? '';
            $from = $config['from'] ?? '';

            $this->smsData = new SmsData();
            $this->smsData->body = $content;
            /** @phpstan-ignore-next-line */
            $this->smsData->to = (string) $to;
            /** @phpstan-ignore-next-line */
            $this->smsData->from = (string) $from;
        }

        $this->config = $config;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $_notifiable The entity to be notified (l'entità da notificare)
     * @return array<int, string>
     */
    public function via(mixed $_notifiable): array
    {
        // TODO: Implementare SmsChannel quando disponibile
        return ['sms'];
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return SmsData
     */
    public function toSms(mixed $notifiable): SmsData
    {
        // If the notifiable entity has a routeNotificationForSms method,
        // we'll use that to get the destination phone number
        if (is_object($notifiable) && method_exists($notifiable, 'routeNotificationForSms')) {
            $routeResult = $notifiable->routeNotificationForSms($this);
            $this->smsData->to = (string) ($routeResult ?? '');
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
     *
     * @return string|null
     */
    public function getProvider(): null|string
    {
        $provider = $this->config['provider'] ?? null;
        return is_string($provider) ? $provider : null;
    }
}
