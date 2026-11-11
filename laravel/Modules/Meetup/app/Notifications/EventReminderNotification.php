<?php

declare(strict_types=1);

namespace Modules\Meetup\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Actions\Event\BuildEventIcsAction;
use Modules\Meetup\Models\Event;

/**
 * Promemoria il giorno prima (I-03), inviato da `meetup:send-reminders`. Contiene data, luogo, link e il file .ics.
 */
class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Event $event,
        string $locale,
    ) {
        $this->locale = $locale;
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $locale = $this->locale ?? app()->getLocale();
        $start = $this->event->start_date;
        $date = '-';
        if ($start instanceof Carbon) {
            $localized = $start->copy()->locale($locale);
            $date = $localized instanceof Carbon ? $localized->translatedFormat('l j F Y, H:i') : $start->format('Y-m-d H:i');
        }
        $venueName = $this->event->venue?->name;
        $venue = is_string($venueName) && $venueName !== '' ? $venueName : $this->event->location;
        $url = LaravelLocalization::getLocalizedURL($locale, '/events/'.$this->event->slug, [], true);
        $replace = ['title' => (string) $this->event->title];
        $ics = app(BuildEventIcsAction::class);

        return (new MailMessage)
            ->subject((string) __('meetup::event_registration.reminder.subject', $replace, $locale))
            ->greeting((string) __('meetup::event_registration.mail.greeting', [], $locale))
            ->line((string) __('meetup::event_registration.reminder.intro', $replace, $locale))
            ->line((string) __('meetup::event_registration.mail.date', ['date' => $date], $locale))
            ->line((string) __('meetup::event_registration.mail.venue', ['venue' => $venue], $locale))
            ->action((string) __('meetup::event_registration.mail.action', [], $locale), is_string($url) ? $url : url('/'))
            ->line((string) __('meetup::event_registration.reminder.cant_come', [], $locale))
            ->attachData($ics->execute($this->event), $ics->filename($this->event), ['mime' => 'text/calendar; charset=UTF-8']);
    }
}
