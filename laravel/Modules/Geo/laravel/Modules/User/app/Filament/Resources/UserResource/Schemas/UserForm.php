<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Schemas;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Modules\User\Filament\Forms\Components\UserSection;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
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
    public static function getFormSchema(): array
    {
        return [
            'worker' => UserSection::make('worker'),
            'section01' => Section::make()
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(function ($state): ?string {
                            if (! is_string($state) || empty($state)) {
                                return null;
                            }

                            return Hash::make($state);
                        })
                        ->required(fn ($livewire) => $livewire instanceof CreateUser),
                ])
                ->columnSpan(8),
            'section02' => Section::make()
                ->schema([
                    Placeholder::make('created_at')->content(static function ($record) {
                        if (! $record instanceof Model) {
                            return new HtmlString('&mdash;');
                        }

                        if (! $record->hasAttribute('created_at')) {
                            return new HtmlString('&mdash;');
                        }

                        /** @var Carbon|null $createdAt */
                        $createdAt = $record->getAttribute('created_at');

                        if (null === $createdAt) {
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
                ->autofocus(),
            'password' => TextInput::make('password')
                ->password()
                ->revealable()
                ->required(),
            'remember' => Checkbox::make('remember'),
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
                ->autocomplete('given-name'),
            'last_name' => TextInput::make('last_name')
                ->required()
                ->string()
                ->minLength(2)
                ->maxLength(255)
                ->autocomplete('family-name'),
            'email' => TextInput::make('email')
                ->required()
                ->email()
                ->maxLength(255)
                ->unique('users', 'email')
                ->autocomplete('email'),
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
                ->dehydrateStateUsing(static fn (string $state): string => Hash::make($state))
                ->autocomplete('new-password')
                ->confirmed(),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->revealable()
                ->required()
                ->string()
                ->minLength(12)
                ->maxLength(255)
                ->autocomplete('new-password')
                ->dehydrated(false)
                ->same('password'),
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
                ->maxLength(255),
        ];
    }

    /**
     * FO auth reset-password (token) — SSoT campi (ResetPasswordWidget delega qui).
     *
     * @return array<string, SchemaComponent>
     */
    public static function getResetPasswordFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('email'),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->minLength(8)
                ->same('password_confirmation')
                ->autocomplete('new-password'),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->autocomplete('new-password'),
        ];
    }
}
