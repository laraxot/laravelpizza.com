<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Modules\User\Actions\Auth\GetPostLoginUrlAction;
use Modules\User\Actions\Auth\RememberLoginReturnUrlAction;
use Modules\User\Filament\Resources\UserResource\Schemas\UserForm;

/**
 * LoginWidget: widget login con form Filament e "vestito" demandato al template tema.
 *
 * Religione Schema!=Widget: schema da `UserForm::getLoginFormSchema()` (SSoT).
 * Submit: `$this->form->getState()` — no `validateForm()`.
 * il widget resta "thin": solo orchestrazione submit + Auth::attempt.
 *
 * MAI: ->label(), ->placeholder(), ->helperText() — traduzioni automatiche
 * da LangServiceProvider tramite `user::login_widget` (lang/it/login_widget.php).
 *
 * @property Schema $form
 */
class LoginWidget extends BaseAuthWidget
{
    /** Tentativi errati consentiti per email e IP prima del blocco (G-07, DCP-54). */
    private const int MAX_ATTEMPTS = 5;

    /** Tentativi errati consentiti per solo IP nella stessa finestra: alto abbastanza per un IP condiviso, basso per uno spray di password. */
    private const int MAX_ATTEMPTS_PER_IP = 20;

    /** Durata del blocco e della finestra di conteggio, in secondi. */
    private const int DECAY_SECONDS = 60;

    /**
     * @return class-string<UserForm>
     */
    protected static function formClass(): string
    {
        return UserForm::class;
    }

    protected static function schemaMethod(): string
    {
        return 'getLoginFormSchema';
    }

    /**
     * Ricorda la pagina da cui arriva l'utente (`?redirect=` o Referer dello stesso host) per riportarlo li' dopo il login.
     */
    public function mount(): void
    {
        parent::mount();
        app(RememberLoginReturnUrlAction::class)->execute(request());
    }

    public function login(): void
    {
        /** @var array<string, mixed> $data */
        $data = $this->form->getState();

        $credentials = [
            'email' => is_string($data['email'] ?? null) ? $data['email'] : '',
            'password' => is_string($data['password'] ?? null) ? $data['password'] : '',
        ];

        $remember = isset($data['remember']) && $data['remember'] === true;

        // Limite ai tentativi per email e IP: senza, una password si puo' provare all'infinito. Il controllo viene PRIMA di `Auth::attempt`,
        // cosi' anche la password giusta e' rifiutata durante il blocco, e il messaggio dice quanto aspettare.
        $throttleKey = Str::transliterate(Str::lower($credentials['email']).'|'.request()->ip());
        // Seconda chiave per solo IP (SEC-012): la prima ripartisce per email, quindi chi prova una password su molte email dallo stesso IP
        // non la raggiunge mai. Il successo azzera solo la chiave `email|ip`: la finestra per IP scade da sola.
        $ipThrottleKey = self::ipThrottleKey(request()->ip());
        foreach ([$throttleKey => self::MAX_ATTEMPTS, $ipThrottleKey => self::MAX_ATTEMPTS_PER_IP] as $key => $maxAttempts) {
            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                $this->addError('data.email', __('user::login.actions.login.throttle', ['seconds' => RateLimiter::availableIn($key)]));

                return;
            }
        }

        // An account its owner deleted (Gdpr DeleteAccountAction sets `deleted_at`) stays closed: the privacy notice says it is deactivated at once.
        if (Auth::attemptWhen($credentials, static fn (Authenticatable $user): bool => ! $user instanceof Model || $user->getAttribute('deleted_at') === null, $remember)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();

            Notification::make()
                ->title(__('user::login.actions.login.success'))
                ->success()
                ->send();

            // Chi e' stato mandato al login da una pagina protetta (es. "Segnala disservizio") o da un link "Accedi" torna a quella
            // pagina: `url.intended` lo salva il middleware `auth` o `mount()`. Senza, si va all'area personale nella lingua corrente.
            $this->redirectIntended(app(GetPostLoginUrlAction::class)->execute());

            return;
        }

        RateLimiter::hit($throttleKey, self::DECAY_SECONDS);
        RateLimiter::hit($ipThrottleKey, self::DECAY_SECONDS);
        $this->addError('data.email', __('user::login.actions.login.error'));
    }

    /**
     * Chiave del freno per solo IP (hash: nella cache non resta l'indirizzo).
     */
    public static function ipThrottleKey(?string $ip): string
    {
        return 'auth-login-ip:'.hash('sha256', $ip ?? 'unknown');
    }

    /**
     * Compat: il template tema usa `wire:submit.prevent="save"`.
     */
    public function save(): void
    {
        $this->login();
    }
}
