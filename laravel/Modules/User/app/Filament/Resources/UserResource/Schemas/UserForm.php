<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Schemas;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;
use Livewire\Component as LivewireComponent;
use Modules\User\Filament\Forms\Components\UserSection;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class UserForm extends XotBaseResourceForm
{
    /**
     * Backoffice UserResource — schema SSoT per CRUD `UserResource` (BO).
     *
     * Religione R1 (form-fields-self-validate): `password` ha
     *  `->dehydrateStateUsing(Hash::make)` → la Resource riceve l'hash pronto.
     *
     * @return array<int|string, SchemaComponent>
     */
    public function getFormSchema(): array
    {
        return [
            'worker' => UserSection::make('worker'),
            'section01' => Section::make()
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(function (?string $state): ?string {
                            if (! is_string($state) || empty($state)) {
                                return null;
                            }

                            return Hash::make($state);
                        })
                        ->required(fn (LivewireComponent $livewire) => $livewire instanceof CreateUser),
                ])
                ->columnSpan(8),
            'section02' => Section::make()
                ->schema([
                    TextEntry::make('created_at')->state(static function (?Model $record) {
                        if (! $record instanceof Model) {
                            return new HtmlString('&mdash;');
                        }

                        if (! $record->hasAttribute('created_at')) {
                            return new HtmlString('&mdash;');
                        }

                        /** @var Carbon|null $createdAt */
                        $createdAt = $record->getAttribute('created_at');

                        if ($createdAt === null) {
                            return new HtmlString('&mdash;');
                        }
                        if ($createdAt instanceof CarbonInterface) {
                            return $createdAt->diffForHumans();
                        }
                        if ($createdAt instanceof \DateTimeInterface) {
                            return $createdAt->format('Y-m-d H:i:s');
                        }

                        return new HtmlString('&mdash;');
                    }),
                ])
                ->columnSpan(4),
        ];
    }

    /**
     * FO auth login — SSoT campi (LoginWidget delega qui).
     *
     * @return array<string, SchemaComponent>
     */
    public static function getLoginFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                // Niente autofocus (DCP-290, WCAG 3.2.1/2.4.3): spostare il focus al caricamento disorienta chi usa un
                // lettore di schermo; il focus va al primo campo con errore dopo un invio fallito (script del tema).
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
     * FO auth register — SSoT campi (RegisterWidget delega qui).
     *
     * @return array<int|string, SchemaComponent>
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
     * FO auth forgot-password — SSoT campi (ForgotPasswordWidget delega qui).
     *
     * @return array<string, SchemaComponent>
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
     * FO auth password-reset (send link) — SSoT campi (PasswordResetWidget delega qui).
     *
     * @return array<string, SchemaComponent>
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
     * FO auth reset-password (token) — SSoT campi (ResetPasswordWidget delega qui).
     *
     * `password` resta in chiaro: il callback di `Password::reset()` la hasha una volta.
     * Con `dehydrateStateUsing(Hash::make)` qui si salvava l'hash di un hash (login impossibile).
     *
     * @return array<string, SchemaComponent>
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
                // Stessa policy della registrazione (`Password::defaults()` = `PasswordData`): con il solo minLength(8) `12345678` passava.
                ->rule(Password::default())
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
     * FO auth password-reset-confirm — SSoT campi (PasswordResetConfirmWidget delega qui).
     *
     * Come il reset: `password` in chiaro, il callback di `Password::broker()->reset()` la hasha una volta.
     *
     * @return array<string, SchemaComponent>
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
                ->rule(Password::default())
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
