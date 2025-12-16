<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Notify\Actions\BuildMailMessageAction;
use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Datas\SmsData;

class ThemeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public array $attachments;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public array $view_params,
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(CanThemeNotificationContract $notifiable): array
    {
        return $notifiable->getNotificationData($this->name, $this->view_params)->channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(CanThemeNotificationContract $notifiable): MailMessage
    {
        $attachments = $notifiable->getNotificationData($this->name, $this->view_params)->attachments;

        $mail_message = app(BuildMailMessageAction::class)
            ->execute($this->name, $notifiable->getModel(), $this->view_params, $attachments);

        $notifiable->sendEmailCallback();

        return $mail_message;
    }

    // public function toEssendex($notifiable)
    // {
    //    dddx($notifiable);
    // }
    /**
     * Undocumented function.
     */
    public function toSms(CanThemeNotificationContract $notifiable): SmsData
    {
        return $notifiable->getNotificationData($this->name, $this->view_params)->getSmsData();

        /*
         * return SmsData::from([
         * 'from' => $this->from,
         * 'to' => $notifiable->routeNotificationFor('mobile'),
         * 'body' => $this->html,
         * ]);
         */
        // $notifiable->sendSmsCallback()
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(CanThemeNotificationContract $notifiable): array
    {
        $res = $this->view_params;
        $res['_name'] = $this->name;

        return $res;
    }
}
