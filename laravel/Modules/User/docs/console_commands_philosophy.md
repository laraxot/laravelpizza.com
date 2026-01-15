# Filosofia dei Console Commands in Laraxot (Standard Supremo)

## Filosofia Fondamentale

### Principi Immutabili
- **Strict Types**: `declare(strict_types=1);` sempre obbligatorio
- **Laravel Prompts Moderni**: Solo `text()`, `select()`, `confirm()` - mai `ask()` o `choice()` obsolete
- **Contracts e XotData**: Mai accesso diretto ai modelli, sempre tramite `UserContract` e `XotData::make()`
- **Error Handling Robusto**: Controlli preventivi con `method_exists()`, `is_null()`, validazioni
- **Enum Handling Moderno**: Gestione con `tryFrom()`, `getLabel()`, type safety completa
- **Array Helpers Eleganti**: `Arr::mapWithKeys()`, `Arr::where()` per manipolazioni funzionali

### Religione dei Command
- *"Non avrai altro framework di prompts all'infuori di Laravel Prompts"*
- *"Non avrai altro accesso ai modelli all'infuori di XotData e Contracts"*
- *"Non avrai altro error handling all'infuori di quello preventivo e chiaro"*

### Politica Architetturale
- **Centralizzazione**: Tutto passa per XotData, nessun bypass
- **Contracts**: Astrazione obbligatoria, mai implementation coupling
- **Type Safety**: PHPDoc completo, generics, union types quando necessari
- **User Experience**: Feedback chiaro, errori comprensibili, flusso logico

### Zen dell'Interaction Design
- Serenità nel flusso utente: prompts chiari, opzioni ben definite
- Error handling che non confonde: messaggi specifici, return immediato
- Code commentato per evoluzioni future: activity logging, audit trail
- Documentazione che guida: PHPDoc completo, esempi pratici

## Template Supremo per Command

```php
<?php

declare(strict_types=1);

namespace Modules\\{ModuleName}\\Console\\Commands;

use Illuminate\\Console\\Command;
use Modules\\Xot\\Contracts\\UserContract;
use Modules\\Xot\\Datas\\XotData;
use Illuminate\\Support\\Arr;

use function Laravel\\Prompts\\text;
use function Laravel\\Prompts\\select;
use function Laravel\\Prompts\\confirm;

class {CommandName}Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = '{module}:{action}';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Detailed description of what this command does';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Input gathering with Laravel Prompts
        $input = text('Prompt description?');
        
        // Data retrieval via XotData and Contracts
        /** @var UserContract */
        $entity = XotData::make()->getMethodByParameter($input);
        
        // Robust error handling
        if (!$entity) {
            $this->error(\"Entity with '{$input}' not found.\");
            return;
        }
        
        // Method existence checking
        if (!method_exists($entity, 'requiredMethod')) {
            $this->error('Entity does not have required method.');
            return;
        }
        
        // Current state information
        $this->info(\"Current state: {$entity->currentValue}\");
        
        // Options preparation with Array helpers
        $options = Arr::mapWithKeys($entity->getOptions(),
            function ($item, string $key) use ($someClass) {
                $label = $someClass::tryFrom($key)->getLabel();
                return [$key => $label];
            }
        );
        
        // User selection
        $newValue = select('Select new option:', $options);
        
        // Confirmation for destructive actions
        if (!confirm('Are you sure?')) {
            $this->info('Operation cancelled.');
            return;
        }
        
        // State update
        $entity->property = $newValue;
        $entity->save();
        
        // Success feedback
        $this->info(\"Operation completed successfully for {$input}\");
        
        // Future implementation placeholders
        // $this->logActivity($entity, $oldValue, $newValue);
        // $this->sendNotification($entity);
    }
}
```

## Esempi Concreti per Diversi Scenari

### Command per User Management
```php
// user:change-type, user:activate, user:deactivate
$email = text('User email?');
$user = XotData::make()->getUserByEmail($email);
```

### Command per Data Migration
```php
// data:migrate, data:clean, data:validate
$source = select('Source:', ['database', 'file', 'api']);
$target = select('Target:', ['production', 'staging', 'local']);
```

### Command per System Management
```php
// system:backup, system:restore, system:health-check
$operation = select('Operation:', $this->getSystemOperations());
$force = confirm('Force operation without confirmation prompts?');
```

## Anti-Pattern da Evitare Assolutamente

### ❌ Framework Prompts Obsoleti
```php
// MAI USARE
$email = $this->ask('Email?');
$type = $this->choice('Type?', $options);
```

### ❌ Accesso Diretto ai Modelli
```php
// MAI USARE
$user = User::where('email', $email)->first();
```

### ❌ Error Handling Scarso
```php
// MAI USARE
$user->type = $newType; // Senza controlli preventivi
```

### ❌ Array Manipulation Primitiva
```php
// MAI USARE
foreach ($types as $key => $type) {
    $options[$key] = $type->getLabel();
}
```

## Checklist Qualità Command

- [ ] `declare(strict_types=1);` presente
- [ ] Namespace corretto del modulo
- [ ] Laravel Prompts utilizzati correttamente
- [ ] XotData e Contracts per data access
- [ ] Error handling preventivo e chiaro
- [ ] Method existence checking dove necessario
- [ ] Enum handling moderno con tryFrom()
- [ ] Array helpers per manipolazioni eleganti
- [ ] Feedback utente chiaro (info/error)
- [ ] PHPDoc completo con tipi
- [ ] Future implementation commentata
- [ ] Confirmation per azioni distruttive

## Collegamenti
- [ChangeTypeCommand.php](../app/Console/Commands/ChangeTypeCommand.php) - Il comando supremo di riferimento
- [README.md](README.md)
- [.cursor/rules/console_commands_philosophy.mdc](../../../.cursor/rules/console_commands_philosophy.mdc)
- [.windsurf/rules/console_commands_philosophy.mdc](../../../.windsurf/rules/console_commands_philosophy.mdc)

*Ultimo aggiornamento: giugno 2025 - Standard estratto dal capolavoro ChangeTypeCommand.php*