<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Widgets\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Actions\User\CreateUserAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * GDPR-Compliant Registration Widget.
 *
 * Flat form design following modern signup UX best practices.
 * GDPR consents are Livewire public properties so the Blade view
 * can render custom HTML with clickable links to privacy/terms pages.
 */
class RegisterWidget extends XotBaseWidget
{
    /** Tentativi per indirizzo IP in `DECAY_SECONDS`: il login ha 5 in 60 s per email+IP (G-07); qui il modulo e' lungo e un IP condiviso (un ufficio) non deve restare bloccato. */
    private const int MAX_ATTEMPTS = 10;

    private const int DECAY_SECONDS = 600;

    public bool $privacy_accepted = false;

    public bool $terms_accepted = false;

    public bool $marketing_consent = false;

    // Form fields for custom Blade view
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $show_password = false;

    /**
     * Regole in un solo punto. La password segue `Password::defaults()` (lunghezza, maiuscole, numeri, simboli: `PasswordData`);
     * le due caselle obbligatorie hanno il messaggio tradotto, non quello generico con il nome del campo.
     *
     * @return array<string, array<int, mixed>|string>
     */
    protected function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255|unique:user.users,email',
            'password' => ['required', 'string', Password::defaults()],
            'password_confirmation' => 'required|string|same:password',
            'privacy_accepted' => 'accepted',
            'terms_accepted' => 'accepted',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'privacy_accepted.accepted' => __('gdpr::register.consents.privacy_policy_required'),
            'terms_accepted.accepted' => __('gdpr::register.consents.terms_required'),
        ];
    }

    /**
     * Nome del campo nei messaggi di errore: la stessa etichetta che si vede sopra il campo, nella lingua della pagina
     * ("Il campo Nome e' obbligatorio"), non l'attributo tecnico ("first name"), DCP-290 (FO-5-11).
     *
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        $attributes = [];
        foreach (['first_name', 'last_name', 'email', 'password', 'password_confirmation'] as $field) {
            $attributes[$field] = __('gdpr::register.fields.'.$field.'.label');
        }

        return $attributes;
    }

    public static function canView(): bool
    {
        return ! Auth::check();
    }

    protected function getView(): string
    {
        return 'filament.widgets.auth.register';
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        // Not used - custom Blade view handles form rendering
        return [];
    }

    public function submit(): void
    {
        // Ogni invio conta, valido o no: serve a frenare chi riempie il modulo in serie
        $throttleKey = 'register|'.request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $this->addError('email', __('gdpr::register.throttle', ['seconds' => RateLimiter::availableIn($throttleKey)]));

            return;
        }
        RateLimiter::hit($throttleKey, self::DECAY_SECONDS);

        // Validate form data using Livewire attributes
        $this->validate();

        // Validate GDPR consents
        app(ValidateGdprConsentAction::class)->execute(
            $this->privacy_accepted,
            $this->terms_accepted
        );

        // Prepare form data
        $formData = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];

        $validatedData = app(ValidateUserDataAction::class)->execute($formData);
        $this->logRegistrationAttempt($formData);

        $user = DB::connection('user')->transaction(function () use ($validatedData) {
            $user = app(CreateUserAction::class)->execute($validatedData);
            app(SaveGdprConsentsAction::class)->execute($user, app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent));
            app(LogRegistrationAction::class)->execute($user, [
                'gdpr_consents' => app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent),
            ]);

            return $user;
        });

        app(HandleSuccessfulRegistrationAction::class)->execute($user, $this);
    }

    /**
     * @param  array<string, mixed>  $formData
     */
    protected function logRegistrationAttempt(array $formData): void
    {
        $email = app(SafeStringCastAction::class)->execute($formData['email']);

        Log::debug('Registration attempt', [
            'email_hash' => hash('sha256', $email),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'gdpr_consents' => app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent),
        ]);
    }
}
