<?php

declare(strict_types=1);

namespace Modules\Meetup\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Actions\Event\JoinEventAction;
use Modules\Meetup\Actions\Event\SignUpAndJoinEventAction;
use Modules\Meetup\Actions\Event\UnregisterAttendeeFromEventAction;
use Modules\Meetup\Models\Event;
use Modules\User\Actions\Auth\ResendEmailVerificationAction;
use Modules\User\Datas\PasswordData;
use Modules\User\Models\User;

/**
 * CTA di iscrizione nella pagina di dettaglio evento (PRD FR-9, FR-10, FR-11).
 *
 * L'utente collegato si iscrive con un clic. Il visitatore si iscrive con email e password nello stesso riquadro
 * (SignUpAndJoinEventAction): se l'email è nuova crea l'account, se esiste ed è sua lo usa.
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

    public string $email = '';

    public string $password = '';

    public bool $consentsAccepted = false;

    private const string SESSION_FLASH = 'meetup.event_registration.flash';

    private const int MAX_ATTEMPTS = 5;

    public function mount(Event $event): void
    {
        $this->eventId = $event->id;

        // Messaggio lasciato da signUp() prima di ricaricare la pagina (serve a mostrare la testata da utente collegato).
        $flash = session()->pull(self::SESSION_FLASH);
        if (is_string($flash)) {
            $this->flash('success', $flash);
        }
    }

    /**
     * Visitatore: email + password (+ consenso, solo per un account nuovo) e iscrizione in un passo.
     */
    public function signUp(SignUpAndJoinEventAction $signUpAndJoin): void
    {
        if ($this->currentUser() instanceof User) {
            return;
        }

        // Gli errori del tentativo precedente non devono coprire quelli di questo (Livewire li conserva tra le richieste).
        $this->resetErrorBag();

        // Ogni tentativo conta: frena chi prova password o crea account in serie.
        $throttleKey = 'event-signup|'.request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $this->addError('email', (string) __('meetup::event_registration.signup.throttle', ['seconds' => RateLimiter::availableIn($throttleKey)]));

            return;
        }
        RateLimiter::hit($throttleKey, 60);

        $isNewAccount = ! User::query()->where('email', mb_strtolower(trim($this->email)))->exists();
        $this->validate(
            [
                'email' => ['required', 'email', 'max:255'],
                // Le regole della password valgono per un account nuovo; per uno esistente decide Hash::check.
                'password' => $isNewAccount ? ['required', 'string', Password::defaults()] : ['required', 'string'],
                'consentsAccepted' => $isNewAccount ? ['accepted'] : [],
            ],
            ['consentsAccepted.accepted' => (string) __('meetup::event_registration.signup.consents_required')],
            [
                'email' => (string) __('meetup::event_registration.signup.email'),
                'password' => (string) __('meetup::event_registration.signup.password'),
            ],
        );

        $event = $this->event();
        $locale = LaravelLocalization::getCurrentLocale();

        try {
            $result = $signUpAndJoin->execute(
                $event,
                $this->email,
                $this->password,
                $this->consentsAccepted,
                is_string($locale) ? $locale : app()->getLocale(),
                request()->ip(),
                request()->userAgent(),
            );
        } catch (\DomainException $exception) {
            match ($exception->getMessage()) {
                'email_taken' => $this->addError('email', (string) __('meetup::event_registration.signup.email_taken')),
                'consents_required' => $this->addError('consentsAccepted', (string) __('meetup::event_registration.signup.consents_required')),
                default => $this->flash('error', $this->messageKeyFor($exception)),
            };
            $this->password = '';

            return;
        }

        RateLimiter::clear($throttleKey);
        Auth::login($result['user']);
        session()->regenerate();

        if ($result['created']) {
            // Una mail che non parte non deve annullare un'iscrizione già salvata: il link si richiede di nuovo dal profilo.
            try {
                app(ResendEmailVerificationAction::class)->execute($result['user']);
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        session()->put(self::SESSION_FLASH, $result['created'] ? 'registered_new_account' : 'registered');
        $this->redirect(LaravelLocalization::localizeUrl('/events/'.$event->slug));
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
            $unregister->execute($this->event(), $user->id);
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
            'loginUrl' => LaravelLocalization::localizeUrl('/auth/login'),
            'privacyUrl' => LaravelLocalization::localizeUrl('/privacy'),
            'termsUrl' => LaravelLocalization::localizeUrl('/terms'),
            // Stessa lunghezza minima di Password::defaults() (config password.min del tenant).
            'passwordMin' => PasswordData::make()->min,
            'isRegistered' => $user !== null && $event->isUserRegistered($user->id),
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
