# Laraxot Code Quality Standards

## Overview

This document defines the mandatory code quality standards for Laraxot projects. These rules ensure consistency, maintainability, and adherence to the Laraxot framework philosophy across all modules.

## Core Principles

### 1. Strict Typing and PHPStan level 10+
- **ALWAYS** use `declare(strict_types=1);` at the beginning of every PHP file
- **MINIMUM** PHPStan level 10 for all new code
- **NEVER** use `mixed` types unless absolutely necessary
- **ALWAYS** provide explicit return types and parameter types

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Models;

use Modules\ModuleName\Models\BaseModel;

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

### 2. Laraxot Module Structure Compliance

#### Model Inheritance
- **ALWAYS** extend `BaseModel` of the same module
- **NEVER** extend `Illuminate\Database\Eloquent\Model` directly
- **NEVER** extend `Modules\Xot\Models\XotBaseModel` directly

```php
// ✅ CORRECT
class User extends \Modules\User\Models\BaseModel

// ❌ WRONG
class User extends \Illuminate\Database\Eloquent\Model
class User extends \Modules\Xot\Models\XotBaseModel
```

#### Migration Standards
- **ALWAYS** use anonymous classes extending `XotBaseMigration`
- **NEVER** implement `down()` method
- **ALWAYS** use `hasTable()` and `hasColumn()` checks

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

### 3. Namespace Conventions
- **NEVER** include 'App' segment in module namespaces
- **ALWAYS** use `Modules\{ModuleName}\{Directory}\{ClassName}` pattern

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
cd /var/www/html/_bases/base_<nome progetto>/laravel
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

**Data**: 2025-08-01  
**Versione**: 2.0  
**Compatibilità**: Laraxot <nome progetto>, PHP 8.2+, Laravel 11+

---

*"Nel codice Laraxot, ogni riga è un verso della sinfonia dell'architettura perfetta."*
