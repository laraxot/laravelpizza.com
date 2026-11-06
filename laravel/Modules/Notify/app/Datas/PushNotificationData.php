<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

/**
 * Notification payload condiviso dai canali push legacy (FCM HTTP legacy API, APNS
 * simulato, Web Push) gestiti da `Modules\Notify\Actions\Push\*`.
 *
 * Le chiavi rispecchiano lo shape del campo "notification" nei payload FCM / Web Push:
 *
 * @see https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support
 * @see https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification
 */
final class PushNotificationData extends Data
{
    /**
     * @param  list<array<string, mixed>>|null  $actions  Solo Web Push: pulsanti azione.
     */
    public function __construct(
        public string $title,
        public string $body,
        public ?string $icon = null,
        /** Solo FCM: nome del suono (es. "default"). */
        public ?string $sound = null,
        /** FCM: contatore badge (int). Web Push: URL icona badge (string). */
        public int|string|null $badge = null,
        /** Solo FCM: "high"|"normal". */
        public ?string $priority = null,
        /** Solo FCM: time-to-live in secondi. */
        public ?int $ttl = null,
        public ?array $actions = null,
        /** Solo Web Push. */
        public ?bool $requireInteraction = null,
        /** Solo Web Push. */
        public ?bool $silent = null,
    ) {}
}
