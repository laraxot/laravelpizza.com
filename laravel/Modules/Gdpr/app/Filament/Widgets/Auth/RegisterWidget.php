<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
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
 *
 * @package Modules\Gdpr\Filament\Widgets\Auth
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
                //->unique(User::class, 'email')
                ->autocomplete('email'),
            'password' => TextInput::make('password')
                ->password()
                ->required()
                //->rule(PasswordData::make()->getPasswordRule())
                ->autocomplete('new-password')
                ->revealable()
                ->confirmed(),
            'password_confirmation' => TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->string()
                ->autocomplete('new-password')
                ->revealable()
                ->dehydrated(false)
                ->same('password'),
        ];
    }

    public function submit(): void
    {
        //try {
            $formData = $this->form->getState();
            $this->validateGDPRConsent();

            $validatedData = $this->validateUserData($formData);
            $this->logRegistrationAttempt($formData);

            $user = DB::transaction(function () use ($validatedData) {
                $user = $this->createUser($validatedData);
                $this->saveAllGDPRConsents($user);
                $this->afterUserCreated($user);

                return $user;
            });

            $this->handleSuccessfulRegistration($user);
            /*
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->handleRegistrationError($e);
        }*/
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
                'privacy_accepted.accepted' => __('gdpr::register.consents.privacy_policy_required'),
                'terms_accepted.accepted' => __('gdpr::register.consents.terms_required'),
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
    protected function validateUserData(array $formData): array
    {
        return [
            'first_name' => app(SafeStringCastAction::class)->execute($formData['first_name']),
            'last_name' => app(SafeStringCastAction::class)->execute($formData['last_name']),
            'email' => app(SafeStringCastAction::class)->execute($formData['email']),
            'password' => Hash::make(
                app(SafeStringCastAction::class)->execute($formData['password']),
            ),
            'type' => 'customer_user',
            'state' => 'active',
            'email_verified_at' => now(),
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
     * @param array<string, mixed> $data
     */
    protected function createUser(array $data): User
    {
        return User::create($data);
    }

    protected function saveAllGDPRConsents(User $user): void
    {
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        $consents = $this->collectGdprConsents();

        $treatments = Treatment::whereIn('name', [
            'privacy_policy',
            'terms_conditions',
            'marketing_consent',
        ])->get()->keyBy('name');

        $consentMapping = [
            'privacy_accepted' => 'privacy_policy',
            'terms_accepted' => 'terms_conditions',
            'marketing_consent' => 'marketing_consent',
        ];

        foreach ($consentMapping as $property => $treatmentName) {
            $isAccepted = $consents[$property] ?? false;
            $treatment = $treatments->get($treatmentName);

            if ($treatment) {
                Consent::create([
                    'user_id' => $user->id,
                    'user_type' => get_class($user),
                    'treatment_id' => $treatment->id,
                    'type' => $treatmentName,
                    'accepted_at' => $isAccepted ? now() : null,
                    'subject_id' => $user->id,
                    'created_by' => 'gdpr_register_widget',
                    'updated_by' => 'gdpr_register_widget',
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                ]);
            }
        }

        Log::info('GDPR consents saved', [
            'user_id' => $user->id,
            'ip' => $ipAddress,
            'consents' => $consents,
        ]);
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
            ->log('User registered via GDPR-compliant RegisterWidget');
    }

    protected function handleSuccessfulRegistration(User $user): void
    {
        Auth::login($user);

        Notification::make()
            ->title(__('gdpr::register.success'))
            ->body(__('gdpr::register.success_message'))
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

        Notification::make()
            ->title(__('gdpr::register.error'))
            ->body(__('gdpr::register.error_message'))
            ->danger()
            ->send();
    }
}