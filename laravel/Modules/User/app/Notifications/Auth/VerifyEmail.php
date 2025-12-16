<?php

declare(strict_types=1);

namespace Modules\User\Notifications\Auth;

use Illuminate\Auth\Notifications\VerifyEmail as BaseNotification;

class VerifyEmail extends BaseNotification
{
    public string $url;

    protected function verificationUrl($notifiable): string
    {
        return $this->url;
    }
}
