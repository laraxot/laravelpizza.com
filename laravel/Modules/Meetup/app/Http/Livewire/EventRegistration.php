<?php

declare(strict_types=1);

namespace Modules\Meetup\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Actions\Event\JoinEventAction;
use Modules\Meetup\Actions\Event\UnregisterAttendeeFromEventAction;
use Modules\Meetup\Models\Event;
use Modules\User\Models\User;

/**
 * CTA di iscrizione nella pagina di dettaglio evento (PRD FR-9, FR-10, FR-11).
 *
 * Il componente non contiene regole di dominio: delega alle Action e traduce
 * le DomainException in messaggi per l'utente.
 */
class EventRegistration extends Component
{
    #[Locked]
    public int $eventId;

    public ?string $message = null;

    public string $messageType = 'success';

    public function mount(Event $event): void
    {
        $this->eventId = (int) $event->getKey();
    }

    public function register(JoinEventAction $joinEvent): void
    {
        $user = $this->currentUser();
        if ($user === null) {
            $this->redirectToLogin();

            return;
        }

        try {
            $joinEvent->execute($this->event(), $user, LaravelLocalization::getCurrentLocale());
            $this->flash('success', 'registered');
        } catch (\DomainException $exception) {
            $this->flash('error', $this->messageKeyFor($exception));
        }
    }

    public function unregister(UnregisterAttendeeFromEventAction $unregister): void
    {
        $user = $this->currentUser();
        if ($user === null) {
            $this->redirectToLogin();

            return;
        }

        try {
            $unregister->execute($this->event(), (string) $user->getKey());
            $this->flash('success', 'unregistered');
        } catch (\DomainException $exception) {
            $this->flash('error', $this->messageKeyFor($exception));
        }
    }

    public function render(): View
    {
        $event = $this->event();
        $user = $this->currentUser();

        return view('meetup::livewire.event-registration', [
            'isGuest' => $user === null,
            'isRegistered' => $user !== null && $event->isUserRegistered((string) $user->getKey()),
            'isFull' => $event->isFull(),
            'availableSpots' => max(0, (int) $event->max_attendees - (int) $event->attendees_count),
        ]);
    }

    private function event(): Event
    {
        return Event::query()->published()->findOrFail($this->eventId);
    }

    private function currentUser(): ?User
    {
        $user = auth()->user();

        return $user instanceof User ? $user : null;
    }

    private function redirectToLogin(): void
    {
        session()->put('url.intended', LaravelLocalization::localizeUrl('/events/'.$this->event()->slug));
        $this->redirect(LaravelLocalization::localizeUrl('/auth/login'));
    }

    private function flash(string $type, string $key): void
    {
        $this->messageType = $type;
        $this->message = (string) __('meetup::event_registration.messages.'.$key);
    }

    private function messageKeyFor(\DomainException $exception): string
    {
        return match ($exception->getMessage()) {
            'Event is full' => 'full',
            'User already registered for this event' => 'already_registered',
            'User is not registered for this event' => 'not_registered',
            'Event has already started' => 'started',
            default => 'closed',
        };
    }
}
