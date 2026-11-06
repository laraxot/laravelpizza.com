<?php

declare(strict_types=1);

namespace Modules\User\Notifications\Auth;

use Illuminate\Auth\Notifications\ResetPassword as BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Webmozart\Assert\Assert;

class ResetPassword extends BaseNotification
{
    public string $url;

    protected function resetUrl($notifiable): string
    {
        return $this->url;
    }

    /**
     * Get the reset password notification mail message for the given URL.
     */
    protected function buildMailMessage($url): MailMessage
    {
        Assert::string($url, 'URL must be a string');
        Assert::string($subject = Lang::get('user::email.password_reset_subject'));
        Assert::string($action = Lang::get('user::email.reset_password'));

        $mailMessage = new MailMessage;
        $mailMessage = $mailMessage->subject($subject);
        $mailMessage = $mailMessage->line(Lang::get('user::email.password_cause_of_email'));
        $mailMessage = $mailMessage->action($action, $url);

        // $mailMessage = $mailMessage->line(Lang::get('user::email.password_reset_expiration', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]));
        return $mailMessage->line(Lang::get('user::email.password_if_not_requested'));
    }
}
