<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications\Channels;

use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Factories\SmsActionFactory;
use Modules\Notify\Notifications\ThemeNotification;
use Webmozart\Assert\Assert;

class NetfunChannel
{
    /**
     * Send the given notification.
     */
    public function send(CanThemeNotificationContract $notifiable, ThemeNotification $themeNotification): void
    {
        $smsData = $themeNotification->toSms($notifiable);

        $action = app(SmsActionFactory::class)->create();
        Assert::isInstanceOf($action, SmsActionContract::class);

        /** @var array<string, mixed> $data */
        $data = $action->execute($smsData);

        $notifiable->increase('sms', $data);
    }
}
