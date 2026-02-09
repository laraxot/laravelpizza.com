<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\UserRegistered;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

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
                    ->autocomplete('given-name'),
                'last_name' => TextInput::make('last_name')
                    ->required()
                    ->string()
                    ->minLength(2)
                    ->maxLength(255)
                    ->autocomplete('family-name'),
            ]),
            'email' => TextInput::make('email')
                ->required()
                ->email()
                ->maxLength(255)
                ->unique(User::class, 'email')
                ->autocomplete('email'),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                ->rule(PasswordData::make()->getPasswordRule())
                ->autocomplete('new-password')
                ->confirmed(),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->string()
                ->autocomplete('new-password')
                ->dehydrated(false)
                ->same('password'),
        ];
    }

    public function submit(): void
    {
        try {
            $formData = $this->form->getState();
            $this->validateGDPRConsent();

            $validatedData = $this->validateForm($formData);
            $this->logRegistrationAttempt($formData);

            $user = DB::transaction(function () use ($validatedData) {
                $user = $this->createUser($validatedData);
                $this->afterUserCreated($user);

                UserRegistered::dispatch(
                    user: $user,
                    formData: $this->collectGdprConsents(),
                    ipAddress: request()->ip(),
                    userAgent: request()->userAgent(),
                );

                return $user;
            });

            $this->handleSuccessfulRegistration($user);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->handleRegistrationError($e);
        }
    }

    /**
     * @throws ValidationException
     */
    protected function validateGDPRConsent(): void
    {
        $validator = validator(
            [
                'privacy_accepted' => $this->privacy_accepted,
                'terms_accepted' => $this->terms_accepted,
            ],
            [
                'privacy_accepted' => 'accepted',
                'terms_accepted' => 'accepted',
            ],
            [
                'privacy_accepted.accepted' => __('user::auth.gdpr.privacy_policy_required'),
                'terms_accepted.accepted' => __('user::auth.gdpr.terms_required'),
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @param array<string, mixed> $formData
     * @return array<string, mixed>
     */
    protected function validateForm(array $formData): array
    {
        return [
            'first_name' => app(SafeStringCastAction::class)->execute($formData['first_name']),
            'last_name' => app(SafeStringCastAction::class)->execute($formData['last_name']),
            'email' => app(SafeStringCastAction::class)->execute($formData['email']),
            'password' => Hash::make(
                app(SafeStringCastAction::class)->execute($formData['password']),
            ),
            'type' => 'standard',
            'state' => 'pending',
            'email_verified_at' => null,
        ];
    }

    /**
     * @return array<string, bool>
     */
    protected function collectGdprConsents(): array
    {
        return [
            'privacy_accepted' => $this->privacy_accepted,
            'terms_accepted' => $this->terms_accepted,
            'marketing_consent' => $this->marketing_consent,
        ];
    }

    /**
     * @param array<string, mixed> $formData
     */
    protected function logRegistrationAttempt(array $formData): void
    {
        $email = app(SafeStringCastAction::class)->execute($formData['email']);
        Log::info('Registration attempt', [
            'email_hash' => hash('sha256', $email),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'gdpr_consents' => $this->collectGdprConsents(),
        ]);
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function createUser(array $data): User
    {
        return User::create($data);
    }

    protected function afterUserCreated(User $user): void
    {
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'type' => $user->type,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'gdpr_consents' => $this->collectGdprConsents(),
            ])
            ->log('User registered via RegisterWidget with GDPR consents');
    }

    protected function handleSuccessfulRegistration(User $user): void
    {
        if (config('auth.must_verify_email')) {
            $user->sendEmailVerificationNotification();
        }

        Auth::login($user);

        Notification::make()
            ->title(__('user::auth.register.success'))
            ->success()
            ->send();

        $this->redirect(route('dashboard'));
    }

    protected function handleRegistrationError(\Exception $e): void
    {
        Log::error('Registration failed: '.$e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        throw new \RuntimeException(__('user::auth.register.error_occurred'));
    }
}
