<?php

/**
 * Classe per la gestione delle configurazioni delle password.
 */

declare(strict_types=1);

namespace Modules\User\Datas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput as FormsTextInput;
use Illuminate\Validation\Rules\Password;
use Modules\Tenant\Services\TenantService;
use Spatie\LaravelData\Data;

/**
 * Classe per la gestione dei dati relativi alle password.
 */
class PasswordData extends Data
{
    private static ?self $instance = null;

    public function __construct(
        public int $otp_expiration_minutes = 5,
        public int $otp_length = 6,
        public int $expires_in = 60,
        public int $min = 8,
        public bool $mixedCase = true,
        public bool $letters = true,
        public bool $numbers = true,
        public bool $symbols = true,
        public bool $uncompromised = true,
        public int $compromisedThreshold = 0,
        public ?string $failMessage = null,
        private ?string $field_name = null,
    ) {
    }

    /**
     * Crea un'istanza della classe PasswordData.
     */
    public static function make(): self
    {
        if (! self::$instance) {
            /** @var array<string, mixed> $data */
            $data = TenantService::getConfig('password');
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    /**
     * Get the password validation rule.
     */
    public function getPasswordRule(): Password
    {
        $pwd = Password::min($this->min);

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
     * Get the validation messages.
     *
     * @return array<string, string>
     */
    public function getValidationMessages(): array
    {
        return [
            'required' => __('user::validation.required'),
            'same' => __('user::validation.same'),
        ];
    }

    /**
     * Get the helper text.
     */
    public function getHelperText(): string
    {
        $msg = 'La password deve essere composta da minimo '.$this->min.' caratteri';

        if ($this->mixedCase) {
            $msg .= ', contenere almeno una lettera maiuscola e una minuscola';
        }

        if ($this->letters) {
            $msg .= ', contenere almeno una lettera';
        }

        if ($this->numbers) {
            $msg .= ', contenere almeno un numero';
        }

        if ($this->symbols) {
            $msg .= ', contenere almeno un carattere speciale';
        }

        if ($this->uncompromised) {
            $msg .= ', non essere stata compromessa in precedenti violazioni di dati';
        }

        return $msg;
    }

    /**
     * Set the field name.
     */
    public function setFieldName(string $field_name): self
    {
        $this->field_name = $field_name;

        return $this;
    }

    /**
     * Get the password form component.
     */
    public function getPasswordFormComponent(string $field_name): FormsTextInput
    {
        return FormsTextInput::make($field_name)
            ->password()
            ->required()
            ->validationMessages($this->getValidationMessages())
            ->helperText($this->getHelperText());
    }

    /**
     * Get the password confirmation form component.
     */
    public function getPasswordConfirmationFormComponent(): FormsTextInput
    {
        if (null === $this->field_name) {
            throw new \RuntimeException('Il nome del campo password non è stato impostato. Utilizzare setFieldName() prima di chiamare questo metodo.');
        }

        return FormsTextInput::make('password_confirmation')
            ->password()
            ->required()
            ->same($this->field_name)
            ->validationMessages($this->getValidationMessages());
    }

    /**
     * Get both password form components.
     *
     * @return array<TextInput>
     */
    public function getPasswordFormComponents(string $field_name): array
    {
        if (empty($field_name)) {
            throw new \InvalidArgumentException('Il nome del campo password non può essere vuoto');
        }

        $this->setFieldName($field_name);

        return [
            $this->getPasswordFormComponent($field_name),
            $this->getPasswordConfirmationFormComponent(),
        ];
    }

    public static function getFormSchema(): array
    {
        return [
            'password' => FormsTextInput::make('password')
                ->password()
                ->required()
                ->minLength(8)
                ->maxLength(255),
            'password_confirmation' => FormsTextInput::make('password_confirmation')
                ->password()
                ->required()
                ->minLength(8)
                ->maxLength(255),
        ];
    }
}
