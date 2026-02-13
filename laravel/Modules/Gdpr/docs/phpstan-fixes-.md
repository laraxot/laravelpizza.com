# PHPStan Fixes - Gdpr Module - 2025-10-13

## Summary

**Starting Errors**: 57 (reduced from initial pass that went 57 → 26)
**Current Errors**: 18
**Progress**: 68% reduction (39 errors fixed)

## Major Fixes Implemented

### 1. Enhanced Consent Model PHPDoc and Relationships
**File**: `app/Models/Consent.php`

**Added Missing Properties**:
```php
@property string|null $consent_type
@property string|null $ip_address
@property Carbon|null $consented_at
@property Carbon|null $withdrawn_at
@property Carbon|null $consent_date
@property Carbon|null $expires_at
@property string|null $user_agent
@property Carbon|null $verified_at
@property \Modules\User\Models\User|null $user
```

**Added User Relationship**:
```php
/**
 * @return BelongsTo<\Modules\User\Models\User, Consent>
 */
public function user(): BelongsTo
{
    return $this->belongsTo(\Modules\User\Models\User::class);
}
```

**Impact**: Fixed undefined property errors in all test files

### 2. Fixed Pest.php Configuration
**File**: `tests/Pest.php`

**Issue**: `toBeConsent` expect extension had undefined `$this` variable

**Before**:
```php
expect()->extend('toBeConsent', function (): \Pest\Expectation {
    return $this->toBeInstanceOf(Consent::class);
});
```

**After**:
```php
expect()->extend('toBeConsent', fn () => expect($this->value)->toBeInstanceOf(Consent::class));
```

**Impact**: Fixed 3 errors related to expect extensions

### 3. Helper Function Type Hints
**File**: `tests/Pest.php`

**Enhancement**: Already had proper PHPDoc and factory type hints:
```php
/**
 * @param array<string, mixed> $attributes
 * @return Consent
 */
function createConsent(array $attributes = []): Consent
{
    /** @var \Illuminate\Database\Eloquent\Factories\Factory<Consent> $factory */
    $factory = Consent::factory();

    /** @var Consent $consent */
    $consent = $factory->create($attributes);

    return $consent;
}
```

## Remaining Issues (18 errors)

### 1. Undefined Static Method
**File**: `tests/Unit/Models/GdprConsentBusinessLogicTest.php:118`

**Issue**: Calling non-existent method `Consent::getConsentHistory()`
```php
$history = Consent::getConsentHistory($user->id, 'analytics');
```

**Options**:
- Implement `getConsentHistory()` static method on Consent model
- Remove or comment out this test
- Add scope/query builder method instead

### 2. Pest Expect Template Types
**Multiple Files**: Various template type resolution issues with Pest's `expect()->and()` chaining

**Pattern**:
```php
expect($consent)
    ->toBeInstanceOf(Consent::class)
    ->and($consent->property)  // Template type TValue unresolved
    ->toBe($value);
```

**Impact**: ~14 errors
**Status**: Many already have `@phpstan-ignore-line` from linter

### 3. Factory Return Types
**Issue**: `User::factory()->create()` annotated but still showing as mixed in some places

**Status**: Linter has applied ignores in most places

## Files Modified

1. ✅ `app/Models/Consent.php` - Enhanced PHPDoc, added user() relationship
2. ✅ `tests/Pest.php` - Fixed expect extension

## Recommendations

1. **Implement getConsentHistory()**: Add static method or scope to Consent model:
```php
/**
 * @return \Illuminate\Database\Eloquent\Collection<int, Consent>
 */
public static function getConsentHistory(int $userId, string $purpose): Collection
{
    return static::where('user_id', $userId)
        ->where('purpose', $purpose)
        ->orderBy('consent_date', 'desc')
        ->get();
}
```

2. **Refactor Pest Chaining**: Break complex expect chains into separate assertions:
```php
// Instead of:
expect($consent)->toBeInstanceOf(Consent::class)->and($consent->property)->toBe($value);

// Use:
expect($consent)->toBeInstanceOf(Consent::class);
expect($consent->property)->toBe($value);
```

3. **Review Test Completeness**: Ensure all tests have necessary model methods implemented

## Next Steps

1. Implement missing `getConsentHistory()` method
2. Refactor Pest expect chains (or accept linter ignores)
3. Move to next module

---

*
*Progress: 68% complete (18 errors remaining)*
*Module Status: Substantial progress - main model issues resolved*
# GDPR Module - PHPStan Fixes Session 2025-10-01

## ✅ Stato: ZERO ERRORI - PHPStan Level 9 Compliance

**Data correzione**: 1 Ottobre 2025
**Analizzati**: 81 file
**Errori prima**: 2
**Errori dopo**: 0

---

## 🛠️ Correzioni Implementate

### 1. ConsentResource.php - Rimozione getTableColumns()

**File**: `app/Filament/Resources/ConsentResource.php`
**Problema**: Metodo `getTableColumns()` non dovrebbe esistere quando si estende `XotBaseResource`

**Codice rimosso**:
```php
public function getTableColumns(): array
{
    return [
        TextColumn::make('id')->searchable(),
        TextColumn::make('treatment.name')->searchable(),
        TextColumn::make('subject_id')->searchable(),
        TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
    ];
}
```

**Motivo**: `XotBaseResource` gestisce automaticamente la configurazione della tabella tramite il trait `HasXotTable`

### 2. TreatmentResource.php - Rimozione getTableColumns()

**File**: `app/Filament/Resources/TreatmentResource.php`
**Problema**: Stesso problema di ConsentResource

**Codice rimosso**:
```php
public function getTableColumns(): array
{
    return [
        IconColumn::make('active')->boolean(),
        IconColumn::make('required')->boolean(),
        TextColumn::make('name')->searchable(),
        TextColumn::make('documentVersion')->searchable(),
        TextColumn::make('documentUrl')->searchable(),
        TextColumn::make('weight')->numeric()->sortable(),
        TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
    ];
}
```

---

## 📋 Pattern Applicato

### Regola: No getTableColumns() in XotBaseResource

**❌ ERRATO**:
```php
class MyResource extends XotBaseResource
{
    public function getTableColumns(): array
    {
        return [...]; // Non serve!
    }
}
```

**✅ CORRETTO**:
```php
class MyResource extends XotBaseResource
{
    // XotBaseResource gestisce tutto automaticamente
    // Le colonne vengono configurate via trait HasXotTable
}
```

---

## 🎯 Architettura GDPR Module

### Resources
- **ConsentResource** ✅ - Pulito, estende XotBaseResource correttamente
- **TreatmentResource** ✅ - Pulito, estende XotBaseResource correttamente
- **EventResource** ✅ - Già corretto
- **ProfileResource** ✅ - Già corretto

### Models
- Consent
- Treatment
- Event
- Profile

### Funzionalità
Il modulo GDPR gestisce:
- Consensi utente per trattamenti dati
- Definizione trattamenti GDPR
- Eventi di consenso/revoca
- Profili privacy

---

## 📊 Risultato

**Prima della correzione**:
- 2 errori PHPStan
- Metodi ridondanti in 2 Resource

**Dopo la correzione**:
- ✅ **0 errori PHPStan Level 9**
- ✅ Architettura conforme a XotBase pattern
- ✅ Codice più pulito e manutenibile

---

## 🔗 Collegamenti

- [← GDPR Module README](./README.md)
- [← PHPStan Session Report](../../../docs/phpstan/filament-v4-fixes-session.md)
- [← Root Documentation](../../../docs/index.md)

---

**Status**: ✅ COMPLETATO
**PHPStan Level**: 9
**Maintenance**: Nessuna azione richiesta
