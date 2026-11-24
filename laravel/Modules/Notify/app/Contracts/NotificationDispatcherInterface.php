<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

use Illuminate\Notifications\Notification;

/**
 * Event-based notification dispatcher.
 * Replaces direct service calls with event dispatch pattern.
 */
interface NotificationDispatcherInterface
{
    /**
     * Dispatch notification to channel.
     *
     * @param  Notification|class-string  $notification
     * @param  string  $channel  email|sms|push
     */
    public function dispatch(string|Notification $notification, int|string $recipient, string $channel = 'email'): void;

    /**
     * Broadcast notification to multiple recipients.
     *
     * @param  Notification|class-string  $notification
     * @param  array<int|string>  $recipients
     */
    public function broadcast(string|Notification $notification, array $recipients): void;
}
