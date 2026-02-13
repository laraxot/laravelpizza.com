<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\Registration\HandleRegistrationErrorAction;
use Modules\Gdpr\Actions\Registration\HandleSuccessfulRegistrationAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Actions\Validation\ValidateGdprConsentAction;
use Modules\Gdpr\Actions\Validation\ValidateUserDataAction;
use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Datas\PasswordData;
use Modules\User\Models\User;
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
    #[Validate('accepted', message: '')]
    public bool $privacy_accepted = false;

    #[Validate('accepted', message: '')]
    public bool $terms_accepted = false;

    public bool $marketing_consent = false;

    public static function canView(): bool
    {
        return ! Auth::check();
    }

    public function mount(): void
    {
        $this->form->fill([]);
    }

    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'name_grid' => Grid::make(2)->schema([
                'first_name' => TextInput::make('first_name')
                    ->required()
                    ->string()
                    ->minLength(2)
                    ->maxLength(255)
                    ->autocomplete('given-name')
                    ->placeholder(__('gdpr::register.fields.first_name.placeholder'))
                    ->helperText(__('gdpr::register.fields.first_name.helper_text')),
                'last_name' => TextInput::make('last_name')
                    ->required()
                    ->string()
                    ->minLength(2)
                    ->maxLength(255)
                    ->autocomplete('family-name')
                    ->placeholder(__('gdpr::register.fields.last_name.placeholder'))
                    ->helperText(__('gdpr::register.fields.last_name.helper_text')),
            ]),
            'email' => TextInput::make('email')
                ->required()
                ->email()
                ->maxLength(255)
                // ->unique(User::class, 'email')
                ->autocomplete('email')
                ->placeholder(__('gdpr::register.fields.email.placeholder'))
                ->helperText(__('gdpr::register.fields.email.helper_text')),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->rule(PasswordData::make()->getPasswordRule())
                ->autocomplete('new-password')
                ->revealable()
                ->confirmed()
                ->placeholder(__('gdpr::register.fields.password.placeholder'))
                ->helperText(__('gdpr::register.fields.password.helper_text')),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->string()
                ->autocomplete('new-password')
                ->revealable()
                ->dehydrated(false)
                ->same('password')
                ->placeholder(__('gdpr::register.fields.password_confirmation.placeholder'))
                ->helperText(__('gdpr::register.fields.password_confirmation.helper_text')),
        ];
    }

    public function submit(): void
    {
        try {
            $formData = $this->form->getState();
            app(ValidateGdprConsentAction::class)->execute(
                $this->privacy_accepted,
                $this->terms_accepted
            );

            $validatedData = app(ValidateUserDataAction::class)->execute($formData);
            $this->logRegistrationAttempt($formData);

            $user = DB::transaction(function () use ($validatedData) {
                $user = app(CreateUserAction::class)->execute($validatedData);
                app(SaveGdprConsentsAction::class)->execute($user, app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent));
                app(LogRegistrationAction::class)->execute($user, [
                    'gdpr_consents' => app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent),
                ]);

                return $user;
            });

            app(HandleSuccessfulRegistrationAction::class)->execute($user, $this);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            app(HandleRegistrationErrorAction::class)->execute($e, $this);
        }
    }

    protected function logRegistrationAttempt(array $formData): void
    {
        $email = app(SafeStringCastAction::class)->execute($formData['email']);

        Log::info('Registration attempt', [
            'email_hash' => hash('sha256', $email),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'gdpr_consents' => app(CollectGdprConsentsAction::class)->execute($this->privacy_accepted, $this->terms_accepted, $this->marketing_consent),
        ]);
    }
}
