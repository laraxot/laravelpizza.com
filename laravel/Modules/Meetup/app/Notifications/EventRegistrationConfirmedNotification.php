<?php

declare(strict_types=1);

namespace Modules\Meetup\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Venue;

/**
 * Email di conferma iscrizione (PRD FR-10): nome evento, data e sede.
 * Accodata (ShouldQueue) e inviata solo dopo il commit della transazione d'iscrizione.
 */
class EventRegistrationConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Event $event,
        string $locale,
    ) {
        // $this->locale è la proprietà nativa di Notification: Laravel invia la mail in quella lingua.
        $this->locale = $locale;
        $this->afterCommit();
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
        $startDate = $this->event->start_date;
        $date = '-';
        if ($startDate instanceof Carbon) {
            $localized = $startDate->copy()->locale($locale);
            $date = $localized instanceof Carbon
                ? $localized->translatedFormat('l j F Y, H:i')
                : $startDate->format('Y-m-d H:i');
        }
        // find() restituisce null se la sede è stata eliminata: la mail ricade sul testo libero "location".
        $venueModel = Venue::query()->whereKey($this->event->location_id)->first();
        $venue = $venueModel instanceof Venue && is_string($venueModel->name)
            ? $venueModel->name
            : ($this->event->location ?? '-');
        $url = LaravelLocalization::getLocalizedURL(
            $locale,
            '/events/'.$this->event->slug,
            [],
            true,
        );

        $replace = ['title' => (string) $this->event->title];

        return (new MailMessage)
            ->subject((string) __('meetup::event_registration.mail.subject', $replace, $locale))
            ->greeting((string) __('meetup::event_registration.mail.greeting', [], $locale))
            ->line((string) __('meetup::event_registration.mail.intro', $replace, $locale))
            ->line((string) __('meetup::event_registration.mail.date', ['date' => $date], $locale))
            ->line((string) __('meetup::event_registration.mail.venue', ['venue' => (string) $venue], $locale))
            ->action((string) __('meetup::event_registration.mail.action', [], $locale), is_string($url) ? $url : url('/'));
    }
}
