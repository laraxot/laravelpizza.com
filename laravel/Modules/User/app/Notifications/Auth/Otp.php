<?php

declare(strict_types=1);

namespace Modules\User\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\User\Datas\PasswordData;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Contracts\UserContract;

class Otp extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public UserContract $user,
        public string $code,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $_notifiable  L'entità da notificare
     * @return array<int, string>
     */
    public function via(mixed $_notifiable): array
    {
        return ['mail']; // Puoi aggiungere anche 'database', 'slack', ecc. se vuoi supportare altri canali.
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(AnonymousNotifiable $notifiable): MailMessage
    {
        $pwd = PasswordData::make();
        $app_name = SafeStringCastAction::cast(config('app.name'));

        $mailMessage = new MailMessage;
        $mailMessage = $mailMessage->template('user::notifications.email');
        $mailMessage = $mailMessage->subject(SafeStringCastAction::cast(__('user::otp.mail.subject')));
        $mailMessage = $mailMessage->greeting(SafeStringCastAction::cast(__('user::otp.mail.greeting')));
        $mailMessage = $mailMessage->line(SafeStringCastAction::cast(__('user::otp.mail.line1', ['code' => $this->code])));
        $mailMessage = $mailMessage->line(SafeStringCastAction::cast(__('user::otp.mail.line2', ['minutes' => $pwd->otp_expiration_minutes])));
        $mailMessage = $mailMessage->line(SafeStringCastAction::cast(__('user::otp.mail.line3')));
        $mailMessage = $mailMessage->action('vai', url('/'));

        return $mailMessage
            ->salutation(SafeStringCastAction::cast(__('user::otp.mail.salutation', ['app_name' => $app_name])));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(UserContract $notifiable): array
    {
        return [];
    }
}
