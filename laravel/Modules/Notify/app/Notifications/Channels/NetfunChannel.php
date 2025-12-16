<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications\Channels;

use Modules\Notify\Actions\NetfunSendAction;
use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Notifications\ThemeNotification;
use Webmozart\Assert\Assert;

// use Modules\Xot\Contracts\ModelContactContract;

class NetfunChannel
{
    /**
     * Send the given notification.
     */
    public function send(CanThemeNotificationContract $notifiable, ThemeNotification $themeNotification): void
    {
        $smsData = $themeNotification->toSms($notifiable);

        // Otteniamo l'istanza dell'action e verifichiamo che sia del tipo corretto
        $netfunSendAction = app(NetfunSendAction::class);
        Assert::isInstanceOf($netfunSendAction, NetfunSendAction::class);

        // Eseguiamo l'action - restituisce sempre un array
        /** @var array<string, mixed> $data */
        $data = $netfunSendAction->execute($smsData);

        // Incrementiamo il contatore SMS
        $notifiable->increase('sms', $data);

        /*
         * $data['sms_sent_at'] = now();
         * $data['sms_count'] = (int) $notifiable->sms_count + 1;
         * $notifiable->update($data);
         */
    }
}
