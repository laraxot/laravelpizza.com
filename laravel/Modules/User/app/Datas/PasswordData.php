<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Illuminate\Validation\Rules\Password as LaravelPassword;
use Modules\Tenant\Services\TenantService;
use Spatie\LaravelData\Data;

/**
 * Classe per la gestione delle configurazioni delle password.
 * 
 * Implementa il pattern Singleton con configurazione tenant-aware.
 * Fornisce componenti form pre-configurati per consistenza e DRY.
 */
class PasswordData extends Data
{
    private static ?self $instance = null;

    public function __construct(
        public int $otp_expiration_minutes = 5,
        public int $otp_length = 6,
        public int $expires_in = 90,
        public int $min = 12, // Più sicuro per meetups tech Laravel
        public bool $mixedCase = true,
        public bool $letters = true,
        public bool $numbers = true,
        public bool $symbols = true,
        public bool $uncompromised = true,
        public int $compromisedThreshold = 0, // Zero tolerance per data breaches nel 2025
        public ?string $failMessage = null,
        private ?string $field_name = null,
    ) {
    }

    /**
     * Crea un'istanza della classe PasswordData.
     * Utilizza TenantService per ottenere configurazioni specifiche del tenant.
     * Pattern Singleton per performance e consistenza.
     */
    public static function make(): self
    {
        if (! self::$instance) {
            /** @var array<string, mixed> $data */
            $data = TenantService::getConfig('password');
            
            if (!is_array($data)) {
                // Fallback a valori di default se il tenant non ha configurazione
                $data = self::getDefaultConfig();
            }
            
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    /**
     * Configurazione di default per password sicure.
     * Valori enterprise-grade per meetups tecnologici.
     */
    private static function getDefaultConfig(): array
    {
        return [
            'otp_expiration_minutes' => 15,
            'otp_length' => 6,
            'expires_in' => 90,
            'min' => 12, // Enterprise-grade security
            'mixedCase' => true,
            'letters' => true,
            'numbers' => true,
            'symbols' => true,
            'uncompromised' => true,
            'compromisedThreshold' => 0, // Zero tolerance per security breaches 2025
            'failMessage' => null,
        ];
    }

    /**
     * Get password validation rule con configurazioni dinamiche.
     * Usa le validation rules di Laravel ma con parametri configurabili.
     */
    public function getPasswordRule(): LaravelPassword
    {
        $pwd = LaravelPassword::min($this->min);

        if ($this->mixedCase) {
            $pwd = $pwd->mixedCase();
        }
        if ($this->letters) {
            $pwd = $pwd->letters();
        }
        if ($this->numbers) {
            $pwd = $pwd->numbers();
        }
        if ($this->symbols) {
            $pwd = $pwd->symbols();
        }
        if ($this->uncompromised) {
            $pwd = $pwd->uncompromised($this->compromisedThreshold);
        }

        return $pwd;
    }

    /**
     * Get validation messages specifici per i campi password.
     * Permette messaggi di errore localizzati e dinamici.
     */
    public function getValidationMessages(): array
    {
        return [
            'required' => __('user::validation.required'),
            'same' => __('user::validation.same'),
            'min' => __('user::validation.min', ['min' => $this->min]),
            'regex' => __('user::validation.password.regex'),
        ];
    }

    /**
     * Get helper text dinamico basato sulla configurazione.
     * Genera messaggi informativi multilingua sulle regole password.
     */
    public function getHelperText(): string
    {
        $rules = [];
        
        if ($this->mixedCase) {
            $rules[] = __('user::password.rules.mixed_case');
        }
        if ($this->letters) {
            $rules[] = __('user::password.rules.letters');
        }
        if ($this->numbers) {
            $rules[] = __('user::password.rules.numbers');
        }
        if ($this->symbols) {
            $rules[] = __('user::password.rules.symbols');
        }
        if ($this->uncompromised) {
            $rules[] = __('user::password.rules.uncompromised');
        }

        $baseMessage = __('user::password.helper_min_only', ['min' => $this->min]);

        if (empty($rules)) {
            return $baseMessage;
        }

        // Formatta le regole in una frase leggibile
        $rulesText = strtolower(implode(', ', $rules));
        
        return __('user::password.helper_with_rules', [
            'min' => $this->min,
            'rules' => $rulesText
        ]);
    }

    /**
     * Setta il nome del campo per i messaggi di errore.
     * Necessario per riferimenti dinamici nei messaggi di validazione.
     */
    public function setFieldName(string $field_name): self
    {
        $this->field_name = $field_name;
        
        return $this;
    }

    /**
     * Crea un componente form per il campo password.
     * Pre-configurato con tutte le regole di validazione e messaggi.
     */
    public function getPasswordFormComponent(string $field_name): \Filament\Forms\Components\TextInput
    {
        $this->setFieldName($field_name);
        
        return \Filament\Forms\Components\TextInput::make($field_name)
            ->password()
            ->required()
            ->rule($this->getPasswordRule())
            ->validationMessages($this->getValidationMessages())
            ->helperText($this->getHelperText())
            ->autocomplete('new-password');
    }

    /**
     * Crea un componente form per la conferma password.
     * Convalidazione automatica e messaggi di errore localizzati.
     */
    public function getPasswordConfirmationFormComponent(): \Filament\Forms\Components\TextInput
    {
        if (null === $this->field_name) {
            throw new \RuntimeException(
                'Il nome del campo password non è stato impostato. ' .
                'Utilizzare setFieldName() prima di chiamare questo metodo.'
            );
        }

        return \Filament\Forms\Components\TextInput::make('password_confirmation')
            ->password()
            ->required()
            ->rule('confirmed:' . $this->field_name)
            ->validationMessages($this->getValidationMessages())
            ->autocomplete('new-password')
            ->dehydrated(false);
    }

    /**
     * Crea entrambi i componenti password form.
     * Metodo comodo per ottenere sia password che conferma.
     */
    public function getPasswordFormComponents(string $field_name): array
    {
        return [
            $this->getPasswordFormComponent($field_name),
            $this->getPasswordConfirmationFormComponent(),
        ];
    }

    /**
     * Get schema di default per il form password.
     * Utilizzabile direttamente se non si personalizzano le regole.
     */
    public static function getFormSchema(): array
    {
        $instance = self::make();
        
        return [
            'password' => \Filament\Forms\Components\TextInput::make('password')
                ->password()
                ->required()
                ->rule($instance->getPasswordRule())
                ->validationMessages($instance->getValidationMessages())
                ->helperText($instance->getHelperText())
                ->autocomplete('new-password')
                ->minLength(12)
                ->maxLength(255),
            'password_confirmation' => \Filament\Forms\Components\TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->rule('confirmed:password')
                ->validationMessages($instance->getValidationMessages())
                ->autocomplete('new-password')
                ->minLength(12)
                ->maxLength(255),
        ];
    }
}