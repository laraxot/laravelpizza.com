<?php

declare(strict_types=1);

namespace Modules\Notify\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Factories\SmsActionFactory;

class NetfunChannel
{
    public function __construct(
        private readonly SmsActionFactory $factory,
    ) {}

    /**
     * @return array<string, mixed>|null
     */
    public function send(mixed $notifiable, Notification $notification): ?array
    {
        if (! is_object($notifiable) || ! method_exists($notifiable, 'routeNotificationForNetfun')) {
            return null;
        }

        $recipient = $notifiable->routeNotificationForNetfun($notification);
        if (! $recipient) {
            return null;
        }

        if (! method_exists($notification, 'toNetfun')) {
            throw new Exception('Il metodo toNetfun() non è implementato nella notifica');
        }

        $message = $notification->toNetfun($notifiable);

        $smsData = SmsData::from([
            'recipient' => $recipient,
            'body' => is_string($message)
                ? $message
                : (is_object($message) && method_exists($message, 'getContent') ? $message->getContent() : ''),
            'from' => '',
        ]);

        $action = $this->factory->create();

        return $action->execute($smsData);
    }
}
