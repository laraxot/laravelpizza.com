# Xot Module - Roadmap, Issues & Optimization

**Modulo**: Xot (Core Framework Base)
**Data Analisi**: 1 Ottobre 2025
**Maintainer**: Laraxot Core Team
**Status PHPStan**: ⚠️ 9 errori (Level 10)

---

## 📊 STATO ATTUALE

### Completezza Funzionale: 95%

| Area | Completezza | Note |
|------|-------------|------|
| Base Classes | 100% | XotBaseResource, XotBasePage, XotBaseWidget |
| Service Providers | 100% | XotBaseServiceProvider completo |
| Traits | 95% | HasXotTable, Updater, ecc. |
| Actions Framework | 90% | Completo, manca documentazione |
| Contracts | 90% | Manca isSuperAdmin() in ProfileContract |
| Type Safety | 98% | 9 errori PHPStan da risolvere |

---

## 🔴 COMPLETED PHPSTAN DA CORREGGERE (9)

### Priorità CRITICA - Blocca altri moduli

#### Errore #1: ProfileContract - Missing Method
**File**: `app/Datas/XotData.php:103`
**Errore**: `Call to an undefined method Modules\Xot\Contracts\ProfileContract::isSuperAdmin()`

**Soluzione**:
```php
// File: app/Contracts/ProfileContract.php
namespace Modules\Xot\Contracts;

interface ProfileContract
{
    // ... existing methods ...

    /**
     * Check if the profile belongs to a super admin user.
     */
    public function isSuperAdmin(): bool;
}
```

**Implementazione in Profile Model**:
```php
public function isSuperAdmin(): bool
{
    return $this->user?->hasRole('super_admin') ?? false;
}
```

**Tempo Fix**: 20 minuti
**Priorità**: 🔴 CRITICA

---

#### Errore #2-3: MainDashboard - Property Access
**File**: `app/Filament/Pages/MainDashboard.php:44, 48`
**Errore**: `Access to an undefined property Illuminate\Database\Eloquent\Model::$name`

**Codice Attuale**:
```php
// Linea 44 e 48
$user->name  // PHPStan non sa che $user ha property $name
```

**Soluzione Opzione 1** (Type Hint):
```php
use Modules\User\Contracts\UserContract;

/** @var UserContract $user */
$user = auth()->user();
$userName = $user->name;
```

**Soluzione Opzione 2** (Safe Getter):
```php
use Modules\Xot\Actions\Model\SafeAttributeCastAction;

$userName = SafeAttributeCastAction::getString($user, 'name', 'Guest');
```

**Tempo Fix**: 15 minuti
**Priorità**: 🟡 ALTA

---

#### Errore #4: XotBasePage - Return Type
**File**: `app/Filament/Resources/Pages/XotBasePage.php:127`
**Errore**: `Method getModel() should return class-string<Model> but returns string`

**Soluzione**:
```php
/**
 * @return class-string<Model>
 */
protected function getModel(): string
{
    /** @var class-string<Model> */
    return static::$model ?? static::getResource()::getModel();
}
```

**Tempo Fix**: 10 minuti
**Priorità**: 🟡 ALTA

---

#### Errore #5: XotBaseRelationManager - Type Narrowing
**File**: `app/Filament/Resources/RelationManagers/XotBaseRelationManager.php:107`
**Errore**: `Cannot call method getName() on class-string|object`

**Soluzione**:
```php
$modelClass = $this->getModel();

if (is_object($modelClass)) {
    $modelClass = get_class($modelClass);
}

$tableName = (new $modelClass)->getTable();
```

**Tempo Fix**: 15 minuti
**Priorità**: 🟡 ALTA

---

#### Errore #6-7: XotBaseRelationManager - Redundant Checks
**File**: `app/Filament/Resources/RelationManagers/XotBaseRelationManager.php:119, 124`
**Errore**: `method_exists() will always evaluate to true`

**Soluzione**: Rimuovere i check ridondanti
```php
// ❌ ERRATO
if (method_exists($this, 'canEdit')) {
    return $this->canEdit($record);
}

// ✅ CORRETTO: PHPStan sa che il metodo esiste
return $this->canEdit($record);
```

**Tempo Fix**: 5 minuti
**Priorità**: 🟢 BASSA

---

#### Errore #8: XotBaseResource - Filament 4 Compatibility
**File**: `app/Filament/Resources/XotBaseResource.php:98`
**Errore**: `Parameter #1 $components type mismatch`

**Problema**: Filament 4 ha cambiato signature di `components()`

**Soluzione**: Verificare documentazione Filament 4 e adattare
```php
// Potrebbe richiedere:
Schema::components(array_values($components))  // Rimuovere chiavi string
// Oppure:
Schema::components(Components::make($components))
```

**Tempo Fix**: 45 minuti (richiede studio Filament 4 docs)
**Priorità**: 🟡 ALTA

---

#### Errore #9: XotBaseServiceProvider - Dead Catch
**File**: `app/Providers/XotBaseServiceProvider.php:190`
**Errore**: `Dead catch - BladeUI\Icons\Exceptions\CannotRegisterIconSet is never thrown`

**Soluzione**: Rimuovere catch block o verificare se exception può essere thrown
```php
// Rimuovere:
catch (CannotRegisterIconSet $e) {
    // Dead code
}
```

**Tempo Fix**: 5 minuti
**Priorità**: 🟢 BASSA

---

## ⚡ PERFORMANCE ISSUES

### 1. Service Provider Boot Time
**File**: `app/Providers/XotBaseServiceProvider.php`

**Analisi**: Boot troppo pesante per ogni request

**Ottimizzazioni**:
- [ ] Lazy register views
- [ ] Defer non-critical registrations
- [ ] Use deferred service providers

**Gain**: 20-30ms per request

---

### 2. Helper Functions - No Caching
**File**: `Helpers/Helper.php`

**Problema**: Chiamate ripetute senza caching

**Soluzione**:
```php
// Usare once() per memoization
function xot_config(string $key): mixed
{
    return once(fn() => config("xot.{$key}"));
}
```

---

## 🎯 ROADMAP

### IMMEDIATE (Domani - 2 Ottobre)

**Obiettivo**: 0 errori PHPStan

- [ ] Aggiungere `isSuperAdmin()` a ProfileContract (20 min)
- [ ] Fix MainDashboard property access (15 min)
- [ ] Fix XotBasePage getModel() (10 min)
- [ ] Fix XotBaseRelationManager type narrowing (15 min)
- [ ] Rimuovere method_exists ridondanti (5 min)
- [ ] Fix XotBaseResource Filament 4 (45 min)
- [ ] Rimuovere dead catch block (5 min)

**Totale**: ~2 ore
**Risultato**: ✅ 0 errori PHPStan Level 10

---

### BREVE TERMINE (Prossime 2 Settimane)

- [ ] **Documentazione Complete** (8h)
  - PHPDoc tutti i metodi pubblici
  - Examples per ogni classe base
  - Migration guide aggiornata

- [ ] **Performance Optimization** (4h)
  - Lazy service provider registrations
  - Helper memoization
  - Config caching

- [ ] **Test Coverage** (12h)
  - Unit tests base classes
  - Integration tests traits
  - Coverage 90%+

---

### MEDIO TERMINE (Prossimo Mese)

- [ ] **Advanced Caching System** (1 settimana)
  - Cache base classes loading
  - Cache trait resolution
  - Cache service provider boot

- [ ] **Enhanced Type Safety** (3 giorni)
  - Generics per Collections
  - Template types per relations
  - PHPStan Level 10 ready

- [ ] **Developer Experience** (1 settimana)
  - CLI tools per module creation
  - Code generators
  - IDE helper improvements

---

## 📋 CHECKLIST QUALITÀ

### Code Quality ✅
- [x] PHPStan Level 10 (83% - domani 100%)
- [ ] PHPDoc 100% coverage
- [ ] No dead code
- [ ] No deprecated methods

### Performance ⚠️
- [ ] Service provider optimization
- [ ] Helper memoization
- [ ] Config caching
- [ ] Query optimization

### Testing ❌
- [ ] Unit tests base classes
- [ ] Integration tests traits
- [ ] Coverage 90%+
- [ ] Mutation testing

### Documentation ⚠️
- [x] Base classes documented
- [ ] Examples complete
- [ ] Migration guides
- [ ] API reference

---

## 💡 RACCOMANDAZIONI ARCHITETTURALI

### Strengths (Mantieni)
✅ Pattern XotBase eccellente
✅ Separazione concerns perfetta
✅ Trait system potente
✅ Service provider auto-discovery

### Improvements (Considera)
⚠️ Aggiungere more contracts/interfaces
⚠️ Implementare event sourcing per audit
⚠️ Consider microservices preparation
⚠️ Add monitoring/observability hooks

---

## 🔗 Collegamenti

- [← Xot Module README](./readme.md)
- [← Best Practices](./best-practices.md)
- [← Troubleshooting](./troubleshooting.md)
- [← Project Roadmap](../../../docs/project-analysis-and-roadmap.md)
- [← Root Documentation](../../../docs/index.md)

---

**Status**: ⚠️ 9 COMPLETED DA CORREGGERE
**Priorità**: 🔴 CRITICA (Core Framework)
**Timeline**: 2 Ottobre 2025 (domani)
**Effort**: ~2 ore → 100% CLEAN
