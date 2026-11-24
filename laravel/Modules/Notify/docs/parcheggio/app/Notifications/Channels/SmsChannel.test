<?php

declare(strict_types=1);
/**
 * @see https://github.com/laravel/vonage-notification-channel/blob/3.x/src/Channels/VonageSmsChannel.php
 */

namespace Modules\Notify\Notifications\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel {
    /**
     * The Vonage client instance.
     *
     * @var \Vonage\Client
     */
    protected $client;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     *
     * @return void
     */
    public function send($notifiable, Notification $notification) {
        // if (! $to = $notifiable->routeNotificationFor('sms', $notification)) {
        if (! $to = $notifiable->routeNotificationFor('sms')) {
            dddx($to);

            return;
        }

        $message = $notification->toSms($notifiable);

        // Send notification to the $notifiable instance...
    }
}
