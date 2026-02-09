<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Datas\PasswordData;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class RegisterWidget extends XotBaseWidget
{
    //protected string $view = 'pub_theme::filament.widgets.auth.register';
    
    //protected static ?int $sort = 2;

    //protected static ?int $sort = 2;

    protected static ?string $maxHeight = '600px';

    public static function canView(): bool
    {
        return ! Auth::check();
    }

    public function mount(): void
    {
        $this->form->fill([]);
        Log::debug('Registration form initialized', [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'user_info' => Section::make()->schema([
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
                    ->unique(User::class, 'email')
                    ->autocomplete('email'),
                'password_grid' => Grid::make(2)->schema([
                    'password' => TextInput::make('password')
                        ->password()
                        ->required()
                        ->rule(PasswordData::make()->getPasswordRule())
                        ->validationMessages([
                            'password.regex' => __('user::auth.validation.password.complexity'),
                        ])
                        ->helperText(PasswordData::make()->getHelperText())
                        ->autocomplete('new-password')
                        ->confirmed(),
                    'password_confirmation' => TextInput::make('password_confirmation')
                        ->password()
                        ->required()
                        ->string()
                        //->minLength(12)
                        //->maxLength(255)
                        ->autocomplete('new-password')
                        ->dehydrated(false)
                        ->same('password'),
                ]),
            ]),
            'gdpr' => Section::make()->schema([
                'privacy_policy_accepted' => Checkbox::make('privacy_policy_accepted')
                    ->accepted()
                    ->required()
                    ->validationMessages([
                        'accepted' => __('user::auth.gdpr.privacy_policy_required'),
                    ])
                    ->helperText(__('user::auth.gdpr.privacy_policy_hint'))
                    ->default(false),
                'terms_accepted' => Checkbox::make('terms_accepted')
                    ->accepted()
                    ->required()
                    ->validationMessages([
                        'accepted' => __('user::auth.gdpr.terms_required'),
                    ])
                    ->helperText(__('user::auth.gdpr.terms_hint'))
                    ->default(false),
                'data_processing_accepted' => Checkbox::make('data_processing_accepted')
                    ->accepted()
                    ->required()
                    ->validationMessages([
                        'accepted' => __('user::auth.gdpr.data_processing_required'),
                    ])
                    ->helperText(__('user::auth.gdpr.data_processing_hint'))
                    ->default(false),
                'marketing_consent' => Checkbox::make('marketing_consent')
                    ->helperText(__('user::auth.gdpr.marketing_hint'))
                    ->default(false),
                'profiling_consent' => Checkbox::make('profiling_consent')
                    ->helperText(__('user::auth.gdpr.profiling_hint'))
                    ->default(false),
                'analytics_consent' => Checkbox::make('analytics_consent')
                    ->helperText(__('user::auth.gdpr.analytics_hint'))
                    ->default(false),
                'third_party_consent' => Checkbox::make('third_party_consent')
                    ->helperText(__('user::auth.gdpr.third_party_hint'))
                    ->default(false),
            ]),
        ];
    }

    public function submit(): void
    {
        try {
            $formData = $this->form->getState();
            $this->validateGDPRConsent($formData);
            
            $validatedData = $this->validateForm($formData);
            $this->logRegistrationAttempt($formData);

            $user = DB::transaction(function () use ($validatedData, $formData) {
                $user = $this->createUser($validatedData);
                $this->saveGDPRConsents($user, $formData);
                $this->afterUserCreated($user, $formData);

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
     * Validate GDPR consent requirements.
     *
     * @param array<string, mixed> $formData
     * @throws ValidationException
     */
    protected function validateGDPRConsent(array $formData): void
    {
        $validator = validator($formData, [
            'privacy_policy_accepted' => 'accepted',
            'terms_accepted' => 'accepted',
            'data_processing_accepted' => 'accepted',
        ], [
            'privacy_policy_accepted.accepted' => __('user::auth.gdpr.privacy_policy_required'),
            'terms_accepted.accepted' => __('user::auth.gdpr.terms_required'),
            'data_processing_accepted.accepted' => __('user::auth.gdpr.data_processing_required'),
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Save GDPR consents to database using Gdpr module.
     *
     * @param User $user
     * @param array<string, mixed> $formData
     */
    protected function saveGDPRConsents(User $user, array $formData): void
    {
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        
        // Get or create treatments
        $treatments = Treatment::whereIn('name', [
            'privacy_policy',
            'terms_conditions',
            'data_processing',
            'marketing_consent',
            'profiling_consent',
            'analytics_consent',
            'third_party_consent',
        ])->get()->keyBy('name');

        // Map form field names to treatment names
        $consentMapping = [
            'privacy_policy_accepted' => 'privacy_policy',
            'terms_accepted' => 'terms_conditions',
            'data_processing_accepted' => 'data_processing',
            'marketing_consent' => 'marketing_consent',
            'profiling_consent' => 'profiling_consent',
            'analytics_consent' => 'analytics_consent',
            'third_party_consent' => 'third_party_consent',
        ];

        // Create consent records
        foreach ($consentMapping as $formField => $treatmentName) {
            if (!isset($formData[$formField])) {
                continue;
            }

            $isAccepted = (bool) $formData[$formField];
            $treatment = $treatments->get($treatmentName);

            if ($treatment) {
                Consent::create([
                    'user_id' => $user->id,
                    'user_type' => get_class($user),
                    'treatment_id' => $treatment->id,
                    'type' => $treatmentName,
                    'accepted_at' => $isAccepted ? now() : null,
                    'subject_id' => $user->id,
                    'created_by' => 'system',
                    'updated_by' => 'system',
                ]);
            }
        }

        Log::info('GDPR consents saved for user registration', [
            'user_id' => $user->id,
            'ip' => $ipAddress,
            'consents' => array_keys($consentMapping),
        ]);
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
     * @param array<string, mixed> $formData
     */
    protected function logRegistrationAttempt(array $formData): void
    {
        $email = app(SafeStringCastAction::class)->execute($formData['email']);
        Log::info('Registration attempt', [
            'email_hash' => hash('sha256', $email),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'gdpr_consents' => [
                'privacy_policy_accepted' => $formData['privacy_policy_accepted'] ?? false,
                'terms_accepted' => $formData['terms_accepted'] ?? false,
                'data_processing_accepted' => $formData['data_processing_accepted'] ?? false,
                'marketing_consent' => $formData['marketing_consent'] ?? false,
                'profiling_consent' => $formData['profiling_consent'] ?? false,
                'analytics_consent' => $formData['analytics_consent'] ?? false,
                'third_party_consent' => $formData['third_party_consent'] ?? false,
            ],
        ]);
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function createUser(array $data): User
    {
        return User::create($data);
    }

    /**
     * @param User $user
     * @param array<string, mixed> $formData
     */
    protected function afterUserCreated(User $user, array $formData): void
    {
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'type' => $user->type,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'gdpr_consents' => [
                    'privacy_policy_accepted' => $formData['privacy_policy_accepted'] ?? false,
                    'terms_accepted' => $formData['terms_accepted'] ?? false,
                    'data_processing_accepted' => $formData['data_processing_accepted'] ?? false,
                    'marketing_consent' => $formData['marketing_consent'] ?? false,
                    'profiling_consent' => $formData['profiling_consent'] ?? false,
                    'analytics_consent' => $formData['analytics_consent'] ?? false,
                    'third_party_consent' => $formData['third_party_consent'] ?? false,
                ],
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
