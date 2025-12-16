<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

/**
 * Class WhatsAppNotification
 *
 * Notification class for sending WhatsApp messages through various providers.
 *
 * @package Modules\Notify\Notifications
 */
class WhatsAppNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The WhatsApp data.
     *
     * @var WhatsAppData
     */
    protected WhatsAppData $whatsappData;

    /**
     * Additional configuration options.
     *
     * @var array<string, mixed>
     */
    protected array $config;

    /**
     * Create a new notification instance.
     *
     * @param string|WhatsAppData $content The content of the WhatsApp message or WhatsAppData object
     * @param array<string, mixed> $config Configuration options including provider
     */
    public function __construct(string|WhatsAppData $content, array $config = [])
    {
        if ($content instanceof WhatsAppData) {
            $this->whatsappData = $content;
        } else {
            $to = $config['to'] ?? '';
            $from = $config['from'] ?? null;

            /** @phpstan-ignore-next-line */
            $this->whatsappData = new WhatsAppData(
                to: SafeStringCastAction::cast($to),
                body: $content,
                from: $from !== null ? SafeStringCastAction::cast($from) : null,
            );
        }

        $this->config = $config;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $_notifiable L'entità da notificare
     * @return array<int, string>
     */
    public function via(mixed $_notifiable): array
    {
        // TODO: Implementare WhatsAppChannel quando disponibile
        return ['whatsapp'];
    }

    /**
     * Get the WhatsApp representation of the notification.
     *
     * @param mixed $notifiable
     * @return WhatsAppData
     */
    public function toWhatsApp(mixed $notifiable): WhatsAppData
    {
        // If the notifiable entity has a routeNotificationForWhatsApp method,
        // we'll use that to get the destination phone number
        if (is_object($notifiable) && method_exists($notifiable, 'routeNotificationForWhatsApp')) {
            $routeResult = $notifiable->routeNotificationForWhatsApp($this);
            $this->whatsappData->to = app(SafeStringCastAction::class)->execute($routeResult);
        }

        return $this->whatsappData;
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
     * Get the provider to use for sending the WhatsApp message.
     *
     * @return string|null
     */
    public function getProvider(): null|string
    {
        $provider = $this->config['provider'] ?? null;
        return is_string($provider) ? $provider : null;
    }
}
