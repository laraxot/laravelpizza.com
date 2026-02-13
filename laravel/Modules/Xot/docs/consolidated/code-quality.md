# Code Quality Guidelines for Laravel Modules

## Overview
This document outlines the best practices for maintaining high code quality within a Laravel module. Adhering to these standards ensures consistency, readability, and maintainability across the codebase.

## Key Principles
1. **Strict Typing**: Always use strict typing in PHP to prevent type-related errors and improve code reliability.
2. **Static Analysis**: Utilize tools like PHPStan for static analysis to catch potential issues before runtime.
3. **Consistent Formatting**: Follow PSR-12 coding standards for consistent code formatting.
4. **Documentation**: Document all public methods and classes using PHPDoc to aid in code understanding and maintenance.

## Implementation Guidelines
### 1. PHP Strict Types
- Declare strict types at the beginning of every PHP file to enforce type safety.
  ```php
  declare(strict_types=1);
  ```

### 2. PHPStan Configuration
- Configure PHPStan for each module with a `phpstan.neon.dist` file to set analysis levels and paths.
  ```neon
  parameters:
      level: 5
      paths:
          - app
  ```
- Use higher levels (e.g., 5 or 8) for new modules or projects to enforce stricter checks.

### 3. Safe Library Usage
- Use the `Safe` library for safer function calls that throw exceptions instead of returning `false`.
  ```php
  use function Safe\file_get_contents;
  $content = Safe\file_get_contents('file.txt');
  ```

### 4. Class and Method Length
- Keep methods under 20 lines and classes under 200 lines to maintain readability and single responsibility.

### 5. Dependency Injection
- Use dependency injection to avoid direct instantiation of dependencies, promoting testability and flexibility.

## Code Quality Tools

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 */
class ExampleModel extends BaseModel
{
    /** @var list<string> */
    protected $fillable = ['name'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
```
### Automation Scripts

- [fix_docs_case](../../../../../bashscripts/project_docs/docs/fix_docs_case.md) - Automatic standardization of documentation filenames
- Run automation scripts regularly to maintain code consistency

## Strumenti di Qualità del Codice

### Scripts di Automazione

- [fix_docs_case](../../../../../bashscripts/project_docs/docs/fix_docs_case.md) - Standardizzazione automatica dei nomi file nella documentazione
- Eseguire gli script di automazione regolarmente per mantenere la coerenza del codice

## Common Issues and Fixes
- **Type Errors**: Ensure all methods and functions have explicit return types and parameter types to avoid type-related bugs.
- **Static Analysis Failures**: Address PHPStan errors by refining code or updating the baseline for existing code.
- **Code Duplication**: Refactor duplicated code into reusable methods or traits to reduce maintenance overhead.

```php
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, false);
        });
    }
};
```
## Testing and Verification
- Run PHPStan analysis regularly to maintain code quality (`./vendor/bin/phpstan analyse`).
- Use automated tools in CI/CD pipelines to enforce coding standards on every commit or pull request.

## Documentation and Updates
- Document any deviations from these guidelines or custom quality rules in the relevant module's documentation folder.
- Update this document if new tools or standards for code quality are introduced.

```php
// ✅ CORRECT
namespace Modules\Performance\Models;
namespace Modules\Performance\Http\Controllers;

// ❌ WRONG
namespace Modules\Performance\App\Models;
namespace App\Modules\Performance\Models;
```

### 4. Translation File Standards
- **NEVER** remove existing keys from translation files
- **ALWAYS** use expanded structure for fields and actions
- **ALWAYS** use short array syntax `[]`
- **NEVER** hardcode strings in components

```php
// ✅ CORRECT
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome completo dell\'utente',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea',
            'success' => 'Creato con successo',
            'error' => 'Errore durante la creazione',
        ],
    ],
];
```

### 5. Filament Component Rules
- **NEVER** use `->label()` in form components
- **ALWAYS** extend XotBase classes
- **ALWAYS** return associative arrays from `getFormSchema()`

```php
// ✅ CORRECT
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name'),
        'email' => TextInput::make('email'),
    ];
}

// ❌ WRONG
public static function getFormSchema(): array
{
    return [
        TextInput::make('name')->label('Nome'),
        TextInput::make('email')->label('Email'),
    ];
}
```

## PHPStan Configuration

### Execution Rules
- **ALWAYS** run from `/laravel` directory
- **NEVER** use `php artisan test:phpstan`
- **ALWAYS** use `./vendor/bin/phpstan analyze --level=9 --memory-limit=2G`

### Error Resolution Patterns
1. **Property Access**: Add `@property` annotations to models
2. **Method Returns**: Add explicit return types
3. **Generics**: Use specific types instead of interfaces in collections
4. **Null Safety**: Add null checks before method/property access

## Safe Library Integration

**ALWAYS** use Safe library functions for potentially unsafe operations:

```php
use function Safe\json_encode;
use function Safe\file_get_contents;
use function Safe\preg_match;

// ✅ CORRETTO
$content = file_get_contents($path);
$data = json_decode($content, true);

// ❌ ERRATO
$content = \file_get_contents($path); // Può restituire false
```

## Controlli di Qualità Obbligatori

### 1. PHPStan Pre-Commit
```bash
cd laravel
./vendor/bin/phpstan analyze Modules/ModuleName --level=9
```

### 2. Documentazione Lowercase
- **TUTTI** i file e cartelle in `docs/` devono essere lowercase
- **UNICA** eccezione: `README.md`
- Utilizzare trattini invece di underscore: `code-quality.md`

### 3. Testing Senza RefreshDatabase
- **MAI** usare `RefreshDatabase` trait nei test
- Database pre-popolato in `.env.testing`
- Test devono funzionare con dati esistenti

## Regole Specifiche Laraxot

### Dashboard Classes
```php
// ✅ CORRETTO - Dashboard senza proprietà di navigazione
class Dashboard extends XotBaseDashboard
{
    // NIENTE navigationIcon, navigationGroup, ecc.
}
```

### Service Providers
```php
// ✅ CORRETTO
class ModuleServiceProvider extends XotBaseServiceProvider
{
    protected string $module_name = 'ModuleName';

    // Solo personalizzazioni specifiche del modulo
}
```

### Migration Rules
- Classi anonime che estendono `XotBaseMigration`
- MAI implementare `down()`
- Sempre verificare esistenza con `hasTable()` e `hasColumn()`
- Per aggiungere colonne: copiare migrazione originale con nuovo timestamp

## Anti-Pattern da Evitare

### ❌ Errori Comuni
```php
// Namespace errato
namespace Modules\ModuleName\App\Models;

// Estensione diretta di classi Laravel
class MyModel extends Model;
class MyResource extends Resource;

// Stringhe hardcoded
TextInput::make('name')->label('Nome');

// Struttura traduzioni piatta
'name_label' => 'Nome'

// PHPStan livello troppo basso
level: 5 // Minimo 9!

// Rimozione contenuto traduzioni
unset($translations['existing_key']); // MAI!
```

## Workflow di Qualità

### 1. Pre-Development
- Studiare documentazione esistente
- Verificare convenzioni specifiche del progetto
- Controllare esempi nel codebase

### 2. Durante Development
- Strict types in ogni file
- Estendere sempre classi XotBase
- Usare enum per stati e tipi
- Traduzioni con struttura espansa

### 3. Pre-Commit
- PHPStan livello 9+
- Verifica naming lowercase per docs
- Test senza RefreshDatabase
- Documentazione aggiornata

## Collegamenti e Risorse

- [xot-base-classes.md](./xot-base-classes.md)
- [filament-resource-rules.md](./filament-resource-rules.md)
- [migration-standards.md](./migration-standards.md)
- [phpstan-implementation-guide.md](./phpstan-implementation-guide.md)
- [translations-best-practices.md](./translations-best-practices.md)
- [namespace-conventions.md](./namespace-conventions.md)

## Ultimo Aggiornamento

**Versione**: 2.0
**Compatibilità**: Laraxot <nome progetto>, PHP 8.2+, Laravel 11+

---

*"Nel codice Laraxot, ogni riga è un verso della sinfonia dell'architettura perfetta."*
# Code Quality Guidelines for Laravel Modules

## Overview
This document outlines the best practices for maintaining high code quality within a Laravel module. Adhering to these standards ensures consistency, readability, and maintainability across the codebase.

## Key Principles
1. **Strict Typing**: Always use strict typing in PHP to prevent type-related errors and improve code reliability.
2. **Static Analysis**: Utilize tools like PHPStan for static analysis to catch potential issues before runtime.
3. **Consistent Formatting**: Follow PSR-12 coding standards for consistent code formatting.
4. **Documentation**: Document all public methods and classes using PHPDoc to aid in code understanding and maintenance.

## Implementation Guidelines
### 1. PHP Strict Types
- Declare strict types at the beginning of every PHP file to enforce type safety.
  ```php
  declare(strict_types=1);
  ```

### 2. PHPStan Configuration
- Configure PHPStan for each module with a `phpstan.neon.dist` file to set analysis levels and paths.
  ```neon
  parameters:
      level: 5
      paths:
          - app
  ```
- Use higher levels (e.g., 5 or 8) for new modules or projects to enforce stricter checks.

### 3. Safe Library Usage
- Use the `Safe` library for safer function calls that throw exceptions instead of returning `false`.
  ```php
  use function Safe\file_get_contents;
  $content = Safe\file_get_contents('file.txt');
  ```

### 4. Class and Method Length
- Keep methods under 20 lines and classes under 200 lines to maintain readability and single responsibility.

### 5. Dependency Injection
- Use dependency injection to avoid direct instantiation of dependencies, promoting testability and flexibility.

## Common Issues and Fixes
- **Type Errors**: Ensure all methods and functions have explicit return types and parameter types to avoid type-related bugs.
- **Static Analysis Failures**: Address PHPStan errors by refining code or updating the baseline for existing code.
- **Code Duplication**: Refactor duplicated code into reusable methods or traits to reduce maintenance overhead.

## Testing and Verification
- Run PHPStan analysis regularly to maintain code quality (`./vendor/bin/phpstan analyse`).
- Use automated tools in CI/CD pipelines to enforce coding standards on every commit or pull request.

## Documentation and Updates
- Document any deviations from these guidelines or custom quality rules in the relevant module's documentation folder.
- Update this document if new tools or standards for code quality are introduced.

## Links to Related Documentation
- [Xot Base Classes](../Xot/project_docs/XOT_BASE_CLASSES.md)
- [Filament Extension Pattern](../../Notify/project_docs/FILAMENT_EXTENSION_PATTERN.md)
- [Filament Extension Pattern Analysis](../../Notify/project_docs/FILAMENT_EXTENSION_PATTERN_ANALYSIS.md)
- [Patient Module - Namespace Conventions](../../Patient/project_docs/NAMESPACE_CONVENTIONS.md)
- [Patient Module - Validation Errors](../../Patient/project_docs/VALIDATION_ERRORS.md)
- [PHP Strict Types](./PHP-STRICT-TYPES.md)
- [PHPStan Implementation Guide](./PHPSTAN-IMPLEMENTATION-GUIDE.md)
- [Naming Conventions](./NAMING-CONVENTIONS.md)
- [Service Provider Best Practices](./SERVICE-PROVIDER-BEST-PRACTICES.md)
- [Filament Best Practices](./FILAMENT-BEST-PRACTICES.md)
# Code Quality Guidelines for Laravel Modules

## Overview
This document outlines the best practices for maintaining high code quality within a Laravel module. Adhering to these standards ensures consistency, readability, and maintainability across the codebase.

## Key Principles
1. **Strict Typing**: Always use strict typing in PHP to prevent type-related errors and improve code reliability.
2. **Static Analysis**: Utilize tools like PHPStan for static analysis to catch potential issues before runtime.
3. **Consistent Formatting**: Follow PSR-12 coding standards for consistent code formatting.
4. **Documentation**: Document all public methods and classes using PHPDoc to aid in code understanding and maintenance.

## Implementation Guidelines
### 1. PHP Strict Types
- Declare strict types at the beginning of every PHP file to enforce type safety.
  ```php
  declare(strict_types=1);
  ```

### 2. PHPStan Configuration
- Configure PHPStan for each module with a `phpstan.neon.dist` file to set analysis levels and paths.
  ```neon
  parameters:
      level: 5
      paths:
          - app
  ```
- Use higher levels (e.g., 5 or 8) for new modules or projects to enforce stricter checks.

### 3. Safe Library Usage
- Use the `Safe` library for safer function calls that throw exceptions instead of returning `false`.
  ```php
  use function Safe\file_get_contents;
  $content = Safe\file_get_contents('file.txt');
  ```

### 4. Class and Method Length
- Keep methods under 20 lines and classes under 200 lines to maintain readability and single responsibility.

### 5. Dependency Injection
- Use dependency injection to avoid direct instantiation of dependencies, promoting testability and flexibility.

## Code Quality Tools

### Automation Scripts

- [fix_docs_case](../../../../../bashscripts/project_docs/docs/fix_docs_case.md) - Automatic standardization of documentation filenames
- Run automation scripts regularly to maintain code consistency

## Strumenti di Qualità del Codice

### Scripts di Automazione

- [fix_docs_case](../../../../../bashscripts/project_docs/docs/fix_docs_case.md) - Standardizzazione automatica dei nomi file nella documentazione
- Eseguire gli script di automazione regolarmente per mantenere la coerenza del codice

## Common Issues and Fixes
- **Type Errors**: Ensure all methods and functions have explicit return types and parameter types to avoid type-related bugs.
- **Static Analysis Failures**: Address PHPStan errors by refining code or updating the baseline for existing code.
- **Code Duplication**: Refactor duplicated code into reusable methods or traits to reduce maintenance overhead.

## Testing and Verification
- Run PHPStan analysis regularly to maintain code quality (`./vendor/bin/phpstan analyse`).
- Use automated tools in CI/CD pipelines to enforce coding standards on every commit or pull request.

## Documentation and Updates
- Document any deviations from these guidelines or custom quality rules in the relevant module's documentation folder.
- Update this document if new tools or standards for code quality are introduced.

## Links to Related Documentation
- [Xot Base Classes](../Xot/project_docs/XOT_BASE_CLASSES.md)
- [Filament Extension Pattern](../../Notify/project_docs/FILAMENT_EXTENSION_PATTERN.md)
- [Filament Extension Pattern Analysis](../../Notify/project_docs/FILAMENT_EXTENSION_PATTERN_ANALYSIS.md)
- [Patient Module - Namespace Conventions](../../Patient/project_docs/NAMESPACE_CONVENTIONS.md)
- [Patient Module - Validation Errors](../../Patient/project_docs/VALIDATION_ERRORS.md)
- [PHP Strict Types](./PHP-STRICT-TYPES.md)
- [PHPStan Implementation Guide](./PHPSTAN-IMPLEMENTATION-GUIDE.md)
- [Naming Conventions](./NAMING-CONVENTIONS.md)
- [Service Provider Best Practices](./SERVICE-PROVIDER-BEST-PRACTICES.md)
- [Filament Best Practices](./FILAMENT-BEST-PRACTICES.md)
