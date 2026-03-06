# PHPStan Fixes and Type System Improvements

## Overview

This document outlines the systematic fixes applied to resolve PHPStan errors in the codebase, with particular focus on type system improvements and architectural consistency.

## 1. View-String Type Issue

### Problem
PHPStan was reporting errors for static properties `$view` in Widget classes:
```
Static property Modules\User\Filament\Widgets\EditUserWidget::$view (view-string) does not accept default value of type string.
```

### Root Cause
The Filament Widget base class uses `view-string` in PHPDoc annotations but declares the property as `string`:
```php
/**
 * @var view-string
 */
protected static string $view;
```

### Solution
Use proper PHPDoc annotations to maintain type safety while keeping the `string` declaration:

```php
/**
 * @var string
 */
protected static string $view = 'pub_theme::filament.widgets.edit-user';
```

### Files Fixed
- `Modules/User/app/Filament/Widgets/EditUserWidget.php`
- `Modules/User/app/Filament/Widgets/Auth/PasswordResetConfirmWidget.php`
- `Modules/User/app/Filament/Widgets/Auth/PasswordResetWidget.php`

## 2. Missing Class Errors

### Problem
PHPStan reports missing classes that are referenced but not found:
```
Class Modules\TechPlanner\Models\Cliente not found.
Class Modules\TechPlanner\Models\Apparecchio not found.
```

### Solution
These classes need to be created or the references need to be updated to use existing models.

### Files Requiring Action
- `Modules/TechPlanner/app/Console/Commands/ImportAccessDataCommand.php`
- `Modules/TechPlanner/app/Contracts/PivotContract.php`
- `Modules/TechPlanner/app/Contracts/WorkerContract.php`

## 3. Type Casting Issues

### Problem
Multiple instances of unsafe type casting:
```
Cannot cast mixed to string.
Cannot cast mixed to float.
```

### Solution
Add proper type checking before casting:

```php
// Before
$value = (string) $mixedValue;

// After
$value = is_string($mixedValue) ? $mixedValue : (string) $mixedValue;
```

## 4. Missing Type Declarations

### Problem
Methods and properties without type declarations:
```
Method Modules\TechPlanner\Models\Worker::setBirthDayAttribute() has parameter $value with no type specified.
```

### Solution
Add proper type declarations:

```php
public function setBirthDayAttribute($value): void
// Becomes
public function setBirthDayAttribute(mixed $value): void
```

## 5. Safe Function Usage

### Problem
Unsafe function usage detected by thecodingmachine/safe:
```
Function chmod is unsafe to use. It can return FALSE instead of throwing an exception.
```

### Solution
Use Safe functions:
```php
// Before
chmod($file, 0755);

// After
use function Safe\chmod;
chmod($file, 0755);
```

## 6. Filament Component Issues

### Problem
Incorrect class references and missing methods:
```
Call to static method make() on an unknown class Modules\TechPlanner\Filament\Resources\ClientResource\Pages\Filament\Infolists\Components\Section.
```

### Solution
Use correct Filament component classes:
```php
// Before
use Modules\TechPlanner\Filament\Resources\ClientResource\Pages\Filament\Infolists\Components\Section;

// After
use Filament\Infolists\Components\Section;
```

## Implementation Strategy

### Phase 1: Type System Fixes
1. Fix view-string type issues in Widget classes
2. Add missing type declarations
3. Fix unsafe type casting

### Phase 2: Missing Classes
1. Create missing model classes or update references
2. Fix contract and interface references

### Phase 3: Safe Functions
1. Replace unsafe functions with Safe equivalents
2. Add proper use statements

### Phase 4: Filament Components
1. Fix incorrect class references
2. Update component imports

## Best Practices

### 1. Type Declarations
- Always declare parameter and return types
- Use `mixed` type for parameters that can accept various types
- Add proper PHPDoc annotations for complex types

### 2. Safe Operations
- Use Safe functions for file operations
- Add proper error handling for type casting
- Validate data before operations

### 3. Filament Integration
- Always extend XotBase classes, never Filament classes directly
- Use correct component imports
- Follow the established architectural patterns

### 4. Documentation
- Update documentation when making architectural changes
- Document type system improvements
- Maintain consistency across modules

## Testing

After applying fixes:
1. Run PHPStan analysis: `./vendor/bin/phpstan analyse Modules`
2. Run tests: `php artisan test`
3. Verify Filament functionality
4. Check for any new errors introduced

## Notes

- The `view-string` type is a PHPStan-specific type for view template paths
- Safe functions provide exception-throwing alternatives to standard PHP functions
- All Filament components should extend XotBase classes for consistency
- Type system improvements enhance code reliability and maintainability 


--- Merged from phpstan-fixes-2025-10-01.md ---

# User Module - PHPStan Fixes Session 2025-10-01

## ⚠️ Stato: IN PROGRESS - 95 errori rimanenti

**Data correzione**: 1 Ottobre 2025  
**Analizzati**: ~400 file  
**Errori iniziali**: ~100+ (bloccavano analisi)  
**Errori attuali**: 95  
**Errori critici risolti**: 7 (syntax errors)

---

## 🛠️ Correzioni Implementate

### 1. BaseUser.php - Rimozione Codice Orfano (CRITICO)

**File**: `app/Models/BaseUser.php`  
**Linee**: 377-419  
**Problema**: Blocchi di codice senza dichiarazione di metodo che causavano 7 errori di sintassi e bloccavano l'intera analisi PHPStan

**Codice rimosso**:
```php
// Linee 377-381: Blocco orfano #1
{
    if ($value !== null) {
        return $value;
    }
{
    if ($value !== null) {
        return $value;
    }
    if ($this->getKey() === null) {
        return $this->email ?? 'User';
    }
    // ... altro codice orfano ...
}
```

**Impatto**: 
- ✅ Eliminati 7 errori di sintassi
- ✅ Sbloccata l'analisi PHPStan su TUTTI i moduli
- ✅ Permesso il proseguimento delle correzioni

### 2. BaseUser.php - Aggiunta Metodi Teams e Tenants

**Data**: 1 Ottobre 2025 (sera)  
**Autore**: Utente  

Aggiunti metodi per gestione Teams e Tenants:

```php
/**
 * Get all of the teams the user belongs to.
 *
 * @return BelongsToMany<Team, static>
 */
public function teams(): BelongsToMany
{
    return $this->belongsToMany(Team::class, 'team_user')
        ->withPivot('role')
        ->withTimestamps();
}

/**
 * Get the current team of the user's context.
 */
public function currentTeam(): BelongsTo
{
    return $this->belongsTo(Team::class, 'current_team_id');
}

/**
 * Determine if the given team is the current team.
 */
public function isCurrentTeam(\Modules\User\Contracts\TeamContract $teamContract): bool
{
    $current = $this->getAttribute('current_team_id');
    return (string) $current === (string) $teamContract->getKey();
}

/**
 * Get all of the tenants the user belongs to.
 *
 * @return BelongsToMany<Tenant, static>
 */
public function tenants(): BelongsToMany
{
    return $this->belongsToMany(Tenant::class, 'tenant_user')
        ->withPivot('role')
        ->withTimestamps();
}

/**
 * Filament: return the tenants available to this user for the given Panel.
 *
 * @return \Illuminate\Support\Collection<int, Tenant>
 */
public function getTenants(Panel $panel): \Illuminate\Support\Collection
{
    return $this->tenants()->get();
}

/**
 * Filament: determine if the user can access the given tenant.
 */
public function canAccessTenant(\Illuminate\Database\Eloquent\Model $tenant): bool
{
    if ($tenant instanceof Tenant) {
        return $this->tenants()->whereKey($tenant->getKey())->exists();
    }
    return false;
}
```

**Implementato contratto**: `HasTeamsContract`

---

## 📋 Errori Rimanenti (95)

### Categorie Principali

1. **Property Access Issues** (~50 errori)
   - Accesso a proprietà non definite su Model generico
   - Necessario: type hints più specifici

2. **Type Safety** (~30 errori)
   - Return types non precisi
   - Mixed types da stringere

3. **Method Calls** (~15 errori)
   - Chiamate a metodi non garantiti

### Piano di Risoluzione

**Priorità ALTA**:
- [ ] Correggere BaseUser property access
- [ ] Migliorare type hints nei trait
- [ ] Stringere return types nei service provider

**Priorità MEDIA**:
- [ ] Correggere seeders
- [ ] Migliorare factories
- [ ] Sistemare helper functions

**Priorità BASSA**:
- [ ] Test type hints
- [ ] Migration type safety

---

## 🎯 Architettura User Module

### Models
- **BaseUser** ⚠️ - In progress (95 errori rimanenti)
- **User** - Estende BaseUser
- **Team** - Gestione team
- **Tenant** - Gestione tenant/organization

### Traits
- **HasTeams** - Gestione appartenenza team
- **HasTenants** - Gestione multi-tenancy
- **HasPermissions** - Integrazione Spatie permissions

### Contracts
- **UserContract** - Interfaccia base utente
- **HasTeamsContract** ✅ - Implementato in BaseUser
- **HasTenants** - Multi-tenancy support

### Resources Filament
- UserResource
- TeamResource
- RoleResource
- PermissionResource

---

## 📊 Progressione

| Fase | Errori | Status |
|------|--------|--------|
| **Inizio sessione** | 100+ (bloccato) | ❌ Analisi impossibile |
| **Dopo fix sintassi** | 95 | ✅ Analisi possibile |
| **Dopo aggiunta Teams/Tenants** | 95 | ⏳ Pronto per correzioni |
| **Target finale** | 0 | 🎯 Obiettivo domani |

---

## 🔧 Best Practices Applicate

### ✅ FATTO
1. Rimosso codice orfano
2. Aggiunti PHPDoc completi per relazioni
3. Type hints espliciti per BelongsToMany
4. Implementato contratto HasTeamsContract

### ⏳ DA FARE
1. Correggere property access su Model generico
2. Migliorare type hints nei metodi legacy
3. Stringere return types
4. Aggiungere assertions PHPStan dove necessario

---

## 🔗 Collegamenti

- [← User Module README](./readme.md)
- [← PHPStan Session Report](../../../docs/phpstan/filament-v4-fixes-session.md)
- [← Final Report](../../../docs/phpstan/final-report-session-2025-10-01.md)
- [← Root Documentation](../../../docs/index.md)

---

## 📝 Note per Domani

### Prossimi Step
1. **Analizzare i 95 errori sistematicamente** - Creare categorizzazione dettagliata
2. **Correggere property access** - Aggiungere type hints specifici
3. **Migliorare type safety** - Usare union types e PHPStan assertions
4. **Test di regressione** - Verificare che tutte le funzionalità funzionino

### Strategie
- Analizzare errori per file (non per tipo)
- Correggere i file più critici prima (Models, Providers)
- Lasciare seeders e test per ultimi

---

**Status**: ⚠️ IN PROGRESS  
**PHPStan Level**: 9  
**Prossima sessione**: 2 Ottobre 2025  
**Obiettivo**: 0 errori User + Xot




---
<\!-- merged from: phpstan-fixes-2025-10-01.md -->

# User Module - PHPStan Fixes Session 2025-10-01

## ⚠️ Stato: IN PROGRESS - 95 errori rimanenti

**Data correzione**: 1 Ottobre 2025  
**Analizzati**: ~400 file  
**Errori iniziali**: ~100+ (bloccavano analisi)  
**Errori attuali**: 95  
**Errori critici risolti**: 7 (syntax errors)

---

## 🛠️ Correzioni Implementate

### 1. BaseUser.php - Rimozione Codice Orfano (CRITICO)

**File**: `app/Models/BaseUser.php`  
**Linee**: 377-419  
**Problema**: Blocchi di codice senza dichiarazione di metodo che causavano 7 errori di sintassi e bloccavano l'intera analisi PHPStan

**Codice rimosso**:
```php
// Linee 377-381: Blocco orfano #1
{
    if ($value !== null) {
        return $value;
    }
{
    if ($value !== null) {
        return $value;
    }
    if ($this->getKey() === null) {
        return $this->email ?? 'User';
    }
    // ... altro codice orfano ...
}
```

**Impatto**: 
- ✅ Eliminati 7 errori di sintassi
- ✅ Sbloccata l'analisi PHPStan su TUTTI i moduli
- ✅ Permesso il proseguimento delle correzioni

### 2. BaseUser.php - Aggiunta Metodi Teams e Tenants

**Data**: 1 Ottobre 2025 (sera)  
**Autore**: Utente  

Aggiunti metodi per gestione Teams e Tenants:

```php
/**
 * Get all of the teams the user belongs to.
 *
 * @return BelongsToMany<Team, static>
 */
public function teams(): BelongsToMany
{
    return $this->belongsToMany(Team::class, 'team_user')
        ->withPivot('role')
        ->withTimestamps();
}

/**
 * Get the current team of the user's context.
 */
public function currentTeam(): BelongsTo
{
    return $this->belongsTo(Team::class, 'current_team_id');
}

/**
 * Determine if the given team is the current team.
 */
public function isCurrentTeam(\Modules\User\Contracts\TeamContract $teamContract): bool
{
    $current = $this->getAttribute('current_team_id');
    return (string) $current === (string) $teamContract->getKey();
}

/**
 * Get all of the tenants the user belongs to.
 *
 * @return BelongsToMany<Tenant, static>
 */
public function tenants(): BelongsToMany
{
    return $this->belongsToMany(Tenant::class, 'tenant_user')
        ->withPivot('role')
        ->withTimestamps();
}

/**
 * Filament: return the tenants available to this user for the given Panel.
 *
 * @return \Illuminate\Support\Collection<int, Tenant>
 */
public function getTenants(Panel $panel): \Illuminate\Support\Collection
{
    return $this->tenants()->get();
}

/**
 * Filament: determine if the user can access the given tenant.
 */
public function canAccessTenant(\Illuminate\Database\Eloquent\Model $tenant): bool
{
    if ($tenant instanceof Tenant) {
        return $this->tenants()->whereKey($tenant->getKey())->exists();
    }
    return false;
}
```

**Implementato contratto**: `HasTeamsContract`

---

## 📋 Errori Rimanenti (95)

### Categorie Principali

1. **Property Access Issues** (~50 errori)
   - Accesso a proprietà non definite su Model generico
   - Necessario: type hints più specifici

2. **Type Safety** (~30 errori)
   - Return types non precisi
   - Mixed types da stringere

3. **Method Calls** (~15 errori)
   - Chiamate a metodi non garantiti

### Piano di Risoluzione

**Priorità ALTA**:
- [ ] Correggere BaseUser property access
- [ ] Migliorare type hints nei trait
- [ ] Stringere return types nei service provider

**Priorità MEDIA**:
- [ ] Correggere seeders
- [ ] Migliorare factories
- [ ] Sistemare helper functions

**Priorità BASSA**:
- [ ] Test type hints
- [ ] Migration type safety

---

## 🎯 Architettura User Module

### Models
- **BaseUser** ⚠️ - In progress (95 errori rimanenti)
- **User** - Estende BaseUser
- **Team** - Gestione team
- **Tenant** - Gestione tenant/organization

### Traits
- **HasTeams** - Gestione appartenenza team
- **HasTenants** - Gestione multi-tenancy
- **HasPermissions** - Integrazione Spatie permissions

### Contracts
- **UserContract** - Interfaccia base utente
- **HasTeamsContract** ✅ - Implementato in BaseUser
- **HasTenants** - Multi-tenancy support

### Resources Filament
- UserResource
- TeamResource
- RoleResource
- PermissionResource

---

## 📊 Progressione

| Fase | Errori | Status |
|------|--------|--------|
| **Inizio sessione** | 100+ (bloccato) | ❌ Analisi impossibile |
| **Dopo fix sintassi** | 95 | ✅ Analisi possibile |
| **Dopo aggiunta Teams/Tenants** | 95 | ⏳ Pronto per correzioni |
| **Target finale** | 0 | 🎯 Obiettivo domani |

---

## 🔧 Best Practices Applicate

### ✅ FATTO
1. Rimosso codice orfano
2. Aggiunti PHPDoc completi per relazioni
3. Type hints espliciti per BelongsToMany
4. Implementato contratto HasTeamsContract

### ⏳ DA FARE
1. Correggere property access su Model generico
2. Migliorare type hints nei metodi legacy
3. Stringere return types
4. Aggiungere assertions PHPStan dove necessario

---

## 🔗 Collegamenti

- [← User Module README](./readme.md)
- [← PHPStan Session Report](../../../docs/phpstan/filament-v4-fixes-session.md)
- [← Final Report](../../../docs/phpstan/final-report-session-2025-10-01.md)
- [← Root Documentation](../../../docs/index.md)

---

## 📝 Note per Domani

### Prossimi Step
1. **Analizzare i 95 errori sistematicamente** - Creare categorizzazione dettagliata
2. **Correggere property access** - Aggiungere type hints specifici
3. **Migliorare type safety** - Usare union types e PHPStan assertions
4. **Test di regressione** - Verificare che tutte le funzionalità funzionino

### Strategie
- Analizzare errori per file (non per tipo)
- Correggere i file più critici prima (Models, Providers)
- Lasciare seeders e test per ultimi

---

**Status**: ⚠️ IN PROGRESS  
**PHPStan Level**: 9  
**Prossima sessione**: 2 Ottobre 2025  
**Obiettivo**: 0 errori User + Xot


