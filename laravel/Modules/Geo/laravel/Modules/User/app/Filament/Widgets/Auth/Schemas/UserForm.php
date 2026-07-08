<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
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
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    public static function getLoginFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autofocus()
                ->autocomplete('username')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'password' => TextInput::make('password')
                ->password()
                ->revealable()
                ->required()
                ->autocomplete('current-password')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'remember' => Checkbox::make('remember')
                ->label(__('user::login.fields.remember.label'))
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
     * @return array<string, \Filament\Schemas\Components\Component>
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
                ->autofocus()
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
                    if (null === $state || '' === $state) {
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
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    public static function getForgotPasswordFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->autocomplete('email')
                ->autofocus()
                ->extraInputAttributes(['class' => 'fo-auth-input']),
        ];
    }

    /**
     * FO auth password-reset (send link) — SSoT campi per `PasswordResetWidget`.
     *
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    public static function getPasswordResetFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('email')
                ->maxLength(255)
                ->autofocus()
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--centered']),
        ];
    }

    /**
     * FO auth reset-password (token) — SSoT campi per `ResetPasswordWidget`.
     *
     * R1: `password` usa `dehydrateStateUsing(Hash::make)`. R2: password +
     *  confirm stacked.
     *
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    public static function getResetPasswordFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('email')
                ->extraInputAttributes(['class' => 'fo-auth-input']),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->minLength(8)
                ->same('password_confirmation')
                ->autocomplete('new-password')
                ->dehydrateStateUsing(static function (?string $state): ?string {
                    if (null === $state || '' === $state) {
                        return null;
                    }

                    return Hash::make($state);
                })
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->autocomplete('new-password')
                ->dehydrated(false)
                ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
        ];
    }

    /**
     * FO auth password-reset-confirm — SSoT campi per `PasswordResetConfirmWidget`.
     *
     * R1 + R2.
     *
     * @return array<string, \Filament\Schemas\Components\Component>
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
                ->dehydrateStateUsing(static function (?string $state): ?string {
                    if (null === $state || '' === $state) {
                        return null;
                    }

                    return Hash::make($state);
                })
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
