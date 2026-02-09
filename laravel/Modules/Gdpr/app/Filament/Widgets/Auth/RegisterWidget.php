<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Widgets\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
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

/**
 * GDPR-Compliant Registration Widget
 * 
 * Questo widget gestisce l'intero processo di registrazione
 * inclusi utente, validazione e consensi GDPR, garantendo
 * coesione completa delle responsabilità privacy.
 * 
 * @package Modules\Gdpr\Filament\Widgets\Auth
 */
class RegisterWidget extends XotBaseWidget
{
    protected static ?string $maxHeight = '700px';

    public static function canView(): bool
    {
        return ! Auth::check();
    }

    public function mount(): void
    {
        $this->form->fill([]);
        Log::debug('GDPR Registration form initialized', [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'module' => 'Gdpr',
        ]);
    }

    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'user_info' => Section::make(__('gdpr::register.sections.user_info'))
                ->description(__('gdpr::register.sections.user_info_description'))
                ->schema([
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
                    'password' => PasswordData::make()->getPasswordFormComponents('password')[0],
                    'password_confirmation' => PasswordData::make()->getPasswordFormComponents('password')[1],
                ]),
            'required_consents' => Section::make(__('gdpr::register.sections.required_consents'))
                ->description(__('gdpr::register.sections.required_consents_description'))
                ->schema([
                    'privacy_policy_accepted' => Checkbox::make('privacy_policy_accepted')
                        ->accepted()
                        ->required()
                        ->validationMessages([
                            'accepted' => __('gdpr::register.consents.privacy_policy_required'),
                        ])
                        ->default(false),

                    'terms_accepted' => Checkbox::make('terms_accepted')
                        ->accepted()
                        ->required()
                        ->validationMessages([
                            'accepted' => __('gdpr::register.consents.terms_required'),
                        ])
                        ->default(false),
                ]),
            'optional_consents' => Section::make(__('gdpr::register.sections.optional_consents'))
                ->description(__('gdpr::register.sections.optional_consents_description'))
                ->schema([
                    'marketing_consent' => Checkbox::make('marketing_consent')
                        ->default(false),
                ]),
        ];
    }

    public function submit(): void
    {
        try {
            $formData = $this->form->getState();
            $this->validateRequiredConsents($formData);
            
            $validatedData = $this->validateUserData($formData);
            $this->logRegistrationAttempt($formData);

            $user = DB::transaction(function () use ($validatedData, $formData) {
                $user = $this->createUser($validatedData);
                $this->saveAllGDPRConsents($user, $formData);
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
     * Valida solo i consensi obbligatori per GDPR
     */
    protected function validateRequiredConsents(array $formData): void
    {
        $requiredConsents = ['privacy_policy_accepted', 'terms_accepted', 'data_processing_accepted'];
        
        foreach ($requiredConsents as $consent) {
            if (true !== ($formData[$consent] ?? false)) {
                throw ValidationException::withMessages([
                    $consent => __('gdpr::register.consents.required_consent_missing'),
                ]);
            }
        }
    }

    /**
     * Valida e sanitizza i dati utente
     * 
     * @param array<string, mixed> $formData
     * @return array<string, mixed>
     */
    protected function validateUserData(array $formData): array
    {
        /** @var array<string, mixed> $data */
        $data = [
            'first_name' => app(SafeStringCastAction::class)->execute($formData['first_name']),
            'last_name' => app(SafeStringCastAction::class)->execute($formData['last_name']),
            'email' => app(SafeStringCastAction::class)->execute($formData['email']),
            'password' => Hash::make(
                app(SafeStringCastAction::class)->execute($formData['password']),
            ),
            'type' => 'standard',
            'state' => 'active', // Utente attivo direttamente dopo registrazione GDPR-compliant
            'email_verified_at' => now(), // Email verificata automaticamente per semplificare
        ];

        return $data;
    }

    /**
     * Crea l'utente nel database
     * 
     * @param array<string, mixed> $data
     */
    protected function createUser(array $data): User
    {
        return User::create($data);
    }

    /**
     * Salva TUTTI i consensi GDPR nel modulo dedicato
     */
    protected function saveAllGDPRConsents(User $user, array $formData): void
    {
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        
        // Ottieni o crea i trattamenti GDPR
        $treatments = Treatment::whereIn('name', [
            'privacy_policy',
            'terms_conditions', 
            'data_processing',
            'marketing_consent',
            'profiling_consent',
            'analytics_consent',
            'third_party_consent',
        ])->get()->keyBy('name');

        // Mapping completo campi → trattamenti
        $consentMapping = [
            'privacy_policy_accepted' => 'privacy_policy',
            'terms_accepted' => 'terms_conditions',
            'data_processing_accepted' => 'data_processing',
            'marketing_consent' => 'marketing_consent',
            'profiling_consent' => 'profiling_consent',
            'analytics_consent' => 'analytics_consent',
            'third_party_consent' => 'third_party_consent',
        ];

        // Crea record di consenso per ogni campo
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
                    'created_by' => 'gdpr_register_widget',
                    'updated_by' => 'gdpr_register_widget',
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                ]);
            }
        }

        Log::info('GDPR consents saved by dedicated widget', [
            'user_id' => $user->id,
            'ip' => $ipAddress,
            'consents_count' => count(array_filter($formData, fn($v) => $v === true)),
            'module' => 'Gdpr',
        ]);
    }

    /**
     * Log del tentativo di registrazione
     */
    protected function logRegistrationAttempt(array $formData): void
    {
        $email = app(SafeStringCastAction::class)->execute($formData['email']);
        
        Log::info('GDPR-compliant registration attempt', [
            'email_hash' => hash('sha256', $email),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'gdpr_module' => true,
            'consents_summary' => [
                'required' => [
                    'privacy_policy' => $formData['privacy_policy_accepted'] ?? false,
                    'terms' => $formData['terms_accepted'] ?? false,
                    'data_processing' => $formData['data_processing_accepted'] ?? false,
                ],
                'optional' => [
                    'marketing' => $formData['marketing_consent'] ?? false,
                    'profiling' => $formData['profiling_consent'] ?? false,
                    'analytics' => $formData['analytics_consent'] ?? false,
                    'third_party' => $formData['third_party_consent'] ?? false,
                ],
            ],
        ]);
    }

    /**
     * Post-creazione utente con GDPR
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
                'gdpr_compliant' => true,
                'registration_module' => 'Gdpr',
                'consents' => [
                    'required' => [
                        'privacy_policy_accepted' => $formData['privacy_policy_accepted'] ?? false,
                        'terms_accepted' => $formData['terms_accepted'] ?? false,
                        'data_processing_accepted' => $formData['data_processing_accepted'] ?? false,
                    ],
                    'optional' => [
                        'marketing_consent' => $formData['marketing_consent'] ?? false,
                        'profiling_consent' => $formData['profiling_consent'] ?? false,
                        'analytics_consent' => $formData['analytics_consent'] ?? false,
                        'third_party_consent' => $formData['third_party_consent'] ?? false,
                    ],
                ],
            ])
            ->log('User registered via GDPR-compliant registration widget');
    }

    protected function handleSuccessfulRegistration(User $user): void
    {
        // Login diretto dopo registrazione
        Auth::login($user);

        Notification::make()
            ->title(__('gdpr::register.success'))
            ->body(__('gdpr::register.success_message'))
            ->success()
            ->send();

        // Redirect alla dashboard con contesto privacy
        $this->redirect(route('dashboard'));
    }

    protected function handleRegistrationError(\Exception $e): void
    {
        Log::error('GDPR Registration failed: '.$e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'module' => 'Gdpr',
        ]);

        Notification::make()
            ->title(__('gdpr::register.error'))
            ->body(__('gdpr::register.error_message'))
            ->danger()
            ->send();
    }
}