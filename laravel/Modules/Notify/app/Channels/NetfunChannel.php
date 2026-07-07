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
<<<<<<< HEAD
     * Invia la notifica tramite Netfun SMS
=======
     * @return array<string, mixed>|null
>>>>>>> 40b96bcd6 (.)
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

<<<<<<< HEAD
        // Esegui l'invio tramite la Queueable Action
        // L'esecuzione avverrà in modo asincrono (in background)
        $result = $this->sendSMSAction->onQueue('sms')->execute($smsData);

        return is_array($result) ? $result : null;
=======
        $action = $this->factory->create();

        return $action->execute($smsData);
>>>>>>> 40b96bcd6 (.)
    }
}
