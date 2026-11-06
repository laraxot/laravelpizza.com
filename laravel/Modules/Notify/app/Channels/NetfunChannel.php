<?php

declare(strict_types=1);

namespace Modules\Notify\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;
use Modules\Notify\Datas\SmsData;

class NetfunChannel
{
    public function __construct(
        private readonly SendSmsFactorSMSAction $action,
    ) {}

    /**
     * Il ritorno è quello di SendSmsFactorSMSAction::execute(), già tipizzato alla fonte.
     *
     * @return array{status_code: int, status_txt: string}|null
     */
    public function send(object $notifiable, Notification $notification): ?array
    {
        if (! method_exists($notifiable, 'routeNotificationForNetfun')) {
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
            'from' => '']);

        return $this->action->execute($smsData);
    }
}
