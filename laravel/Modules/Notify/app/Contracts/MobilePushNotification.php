<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

/**
 * Contract for mobile push notifications (Firebase FCM, etc.).
 * Implementations may use Kreait Firebase or other providers.
 */
interface MobilePushNotification
{
    /**
     * Get the array representation of the notification.
     *
     * @param  object|null  $notifiable  The entity to be notified
     * @return array<string, mixed>
     */
    public function toArray(?object $notifiable): array;

    /**
     * Convert to a cloud message (Firebase CloudMessage or compatible).
     *
     * @return object Cloud message instance (Kreait\Firebase\Messaging\Message when Kreait is available)
     */
    public function toCloudMessage(): object;
}
