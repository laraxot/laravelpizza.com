<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Widget-level Form class per i widget di autenticazione (FO).
 *
 * Religione R1 (form-fields-self-validate): TUTTA la validazione + trasformazione
 *  (Hash, cast, trim, slugify) vive QUI, non nel widget. Il widget è il direttore
 *  d'orchestra sottile: `$this->form->getState()` ritorna dati già validati
 *  e già deidratati. MAI `validateForm()`, MAI `Hash::make`, MAI `SafeStringCast`
 *  nel widget.
 *
 * Religione R2 (UX): password + password_confirmation **stack verticali** (no
 *  Grid(2) side-by-side). WCAG 2.1 AA: touch target 44px, label-input, aria-invalid,
 *  aria-describedby, focus-visible, error contrast.
 *
 * MAI importare da `Resources/UserResource/Schemas/UserForm` (backoffice): quello
 *  è per `UserResource` (CRUD Filament BO), questo è per widget auth FO.
 */
class UserForm extends XotBaseResourceForm
{
    /**
     * FO auth login — SSoT campi per `LoginWidget`.
     *
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('username')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'password' => TextInput::make('password')
                ->password()
                ->revealable()
                ->required()
                ->autocomplete('current-password')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'remember' => Checkbox::make('remember')
                ->extraInputAttributes(['class' => 'fo-auth-checkbox']),
        ];
    }

    /**
     * FO auth login — SSoT campi per `LoginWidget`.
     *
     * @return array<string, Component>
     */
    public static function getLoginFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('username')
                ->helperText(null)
                ->placeholder(null)
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'password' => TextInput::make('password')
                ->password()
                ->revealable()
                ->required()
                ->helperText(null) // user_form e' condiviso col register: regola "min 12 caratteri" e placeholder "password sicura" non vanno al login
                ->placeholder(null)
                ->autocomplete('current-password')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'remember' => Checkbox::make('remember')
                ->helperText(null)
                ->extraInputAttributes(['class' => 'fo-auth-checkbox']),
        ];
    }

    /**
     * FO auth register — SSoT campi per `RegisterWidget`.
     *
     * R1: `password` usa `dehydrateStateUsing(Hash::make)` → il widget riceve
     *  l'hash pronto, non ri-applica Hash::make. R2: password + confirm stacked
     *  verticali (no Grid(2)).
     *
     * @return array<string, Component>
     */
    public static function getRegisterFormSchema(): array
    {
        return [
            'first_name' => TextInput::make('first_name')
                ->required()
                ->string()
                ->minLength(2)
                ->maxLength(255)
                ->autocomplete('given-name')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'last_name' => TextInput::make('last_name')
                ->required()
                ->string()
                ->minLength(2)
                ->maxLength(255)
                ->autocomplete('family-name')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'email' => TextInput::make('email')
                ->required()
                ->email()
                ->maxLength(255)
                ->unique(User::class, 'email')
                ->autocomplete('email')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'password' => TextInput::make('password')
                ->password()
                ->revealable()
                ->required()
                ->string()
                ->minLength(12)
                ->maxLength(255)
                ->rules([
                    'required',
                    'string',
                    'min:12',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[^A-Za-z0-9]/',
                ])
                ->validationMessages([
                    'password.regex' => __('user::auth.register.sidebar.help_password.text'),
                ])
                ->autocomplete('new-password')
                ->confirmed()
                ->dehydrateStateUsing(static function (?string $state): ?string {
                    if ($state === null || $state === '') {
                        return null;
                    }

                    return Hash::make($state);
                })
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->revealable()
                ->required()
                ->string()
                ->minLength(12)
                ->maxLength(255)
                ->autocomplete('new-password')
                ->dehydrated(false)
                ->same('password')
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
        ];
    }

    /**
     * FO auth forgot-password — SSoT campi per `ForgotPasswordWidget`.
     *
     * @return array<string, Component>
     */
    public static function getForgotPasswordFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->autocomplete('email')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
        ];
    }

    /**
     * FO auth password-reset (send link) — SSoT campi per `PasswordResetWidget`.
     *
     * @return array<string, Component>
     */
    public static function getPasswordResetFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('email')
                ->maxLength(255)
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--centered']),
        ];
    }

    /**
     * FO auth reset-password (token) — SSoT campi per `ResetPasswordWidget`.
     *
     * `password` resta in chiaro: il callback di `Password::reset()` la hasha una volta.
     * Con `dehydrateStateUsing(Hash::make)` qui si salvava l'hash di un hash (login impossibile).
     *
     * @return array<string, Component>
     */
    public static function getResetPasswordFormSchema(): array
    {
        return [
            'token' => Hidden::make('token'),
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('email')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            // Password in chiaro nello stato: la cifra una volta sola `ResetPasswordWidget::resetPassword()` (DCP-290).
            // Un secondo hash qui salvava l'hash dell'hash e il login con la nuova password falliva.
            'password' => TextInput::make('password')
                ->password()
                ->revealable()
                ->required()
                ->minLength(8)
                ->same('password_confirmation')
                ->autocomplete('new-password')
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->revealable()
                ->required()
                ->autocomplete('new-password')
                ->dehydrated(false)
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
        ];
    }

    /**
     * FO auth password-reset-confirm — SSoT campi per `PasswordResetConfirmWidget`.
     *
     * Come il reset: `password` in chiaro, il callback di `Password::broker()->reset()` la hasha una volta.
     *
     * @return array<string, Component>
     */
    public static function getPasswordResetConfirmFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('email')
                ->maxLength(255)
                ->suffixIcon('heroicon-o-envelope')
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--centered']),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->revealable()
                ->minLength(8)
                ->suffixIcon('heroicon-o-key')
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->same('password')
                ->suffixIcon('heroicon-o-key')
                ->dehydrated(false)
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
        ];
    }
}
