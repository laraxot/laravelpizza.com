# PHPStan Level 10 Rules & Best Practices

## Regola immutabile: phpstan.neon

**NON modificare mai** `laravel/phpstan.neon`. PHPStan deve usare esclusivamente quel file. Le correzioni vanno fatte solo nel codice sorgente (type hints, PHPDoc, @phpstan-ignore). Non aggiungere excludePaths o ignoreErrors globali in phpstan.neon.

## Regola critica: mixed - Solo come Ultima Spiaggia

Il tipo **mixed** deve essere usato **SOLO come ultima spiaggia**. Preferire union types, generics, interfacce. Vedi [mixed-type-ultima-spiaggia.md](mixed-type-ultima-spiaggia.md).

## Regola array iterabili

Ogni parametro o ritorno `array` deve dichiarare il value type tramite PHPDoc quando la firma PHP non lo può esprimere.

```php
// Errato
public function send(array $data = [], array $channels = []): void
{
}

// Corretto
/**
 * @param array<string, mixed> $data
 * @param list<string> $channels
 */
public function send(array $data = [], array $channels = []): void
{
}
```

Per array indicizzati usare `list<T>` quando l'ordine è sequenziale; per mappe usare `array<string, T>`; per payload noti usare array shape.

## Critical Rules Identified from Analysis (2026-03-02)

### 1. Trait Method Declarations
**Severity:** CRITICAL  
**Status:** Enforced

Traits MUST NOT contain abstract method declarations mixed with implementations.

```php
// ❌ WRONG
trait MyTrait {
    public function method(): string;  // Abstract
    public function method(): string { // Implementation
        return 'value';
    }
}

// ✅ CORRECT
trait MyTrait {
    public function method(): string {
        return 'value';
    }
}
```

**Files Fixed:**
- `Modules/Tenant/app/Models/Traits/SushiToJsons.php`
- `Modules/Tenant/app/Models/Traits/SushiToJson.php`

---

### 2. Collection Type Parameters
**Severity:** HIGH  
**Status:** Enforced

All Collection returns MUST include generic type parameters.

```php
// ❌ WRONG
public function getUsers(): Collection {
    return User::all();
}

// ✅ CORRECT
/**
 * @return Collection<int, User>
 */
public function getUsers(): Collection {
    return User::all();
}
```

**Impact:** 12 errors in current codebase  
**Modules Affected:** Fixcity, Cms, Tenant

---

### 3. Property Documentation
**Severity:** HIGH  
**Status:** Enforced

All model properties MUST have `@property` PHPDoc annotations.

```php
// ❌ WRONG
class User extends BaseModel {
    public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }
}

// ✅ CORRECT
/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $name
 * @property-read Collection<int, Post> $posts
 */
class User extends BaseModel {
    public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }
}
```

**Impact:** 18 errors in current codebase  
**Modules Affected:** All modules

---

### 4. Method Return Type Declarations
**Severity:** HIGH  
**Status:** Enforced

All methods MUST have explicit return type declarations.

```php
// ❌ WRONG
public function getData() {
    return $this->data;
}

// ✅ CORRECT
public function getData(): array {
    return $this->data;
}

// ✅ ALSO CORRECT (with PHPDoc for complex types)
/**
 * @return array<string, mixed>
 */
public function getData(): array {
    return $this->data;
}
```

**Impact:** 8 errors in current codebase

---

### 5. Array Access Type Safety
**Severity:** MEDIUM  
**Status:** Enforced

Array access operations MUST have proper type information.

```php
// ❌ WRONG
$data = json_decode($json, true);
$value = $data['key'];  // Cannot verify $data is array

// ✅ CORRECT
/** @var array<string, mixed> $data */
$data = json_decode($json, true);
if (is_array($data)) {
    $value = $data['key'] ?? null;
}
```

**Impact:** 12 errors in current codebase  
**Modules Affected:** Fixcity (seeders), Tenant

---

### 6. Static Method Declarations
**Severity:** MEDIUM  
**Status:** Enforced

Static methods MUST be explicitly declared and typed.

```php
// ❌ WRONG
class Model {
    // Method referenced but not defined
}

// ✅ CORRECT
class Model {
    /**
     * Get options for select field
     *
     * @return array<string, string>
     */
    public static function getOptions(): array {
        return [
            'option1' => 'Label 1',
            'option2' => 'Label 2',
        ];
    }
}
```

**Impact:** 5 errors in current codebase  
**Modules Affected:** Geo, Xot

---

### 7. Class Definition Requirements
**Severity:** MEDIUM  
**Status:** Enforced

All referenced classes MUST be defined and properly namespaced.

```php
// ❌ WRONG
public function getBlockData(): BlockData {
    // BlockData class doesn't exist
}

// ✅ CORRECT
use Modules\Cms\Models\BlockData;

/**
 * @return BlockData
 */
public function getBlockData(): BlockData {
    return new BlockData(...);
}
```

**Impact:** 12 errors in current codebase  
**Modules Affected:** Cms, Fixcity, User

---

## Error Categories & Solutions

### property.notFound (18 errors)
**Root Cause:** Missing `@property` PHPDoc  
**Solution:** Add comprehensive property documentation to all models

### method.notFound (16 errors)
**Root Cause:** Methods referenced but not implemented  
**Solution:** Implement missing methods with proper return types

### class.notFound (12 errors)
**Root Cause:** Missing class definitions  
**Solution:** Create missing Data classes and models

### return.type (8 errors)
**Root Cause:** Missing return type declarations  
**Solution:** Add explicit return types to all methods

### argument.type (10 errors)
**Root Cause:** Type mismatches in arguments  
**Solution:** Add proper type hints to method parameters

### offsetAccess.nonOffsetAccessible (12 errors)
**Root Cause:** Array access on non-array types  
**Solution:** Add type assertions and null checks

### method.nonObject (9 errors)
**Root Cause:** Calling methods on mixed/null  
**Solution:** Add proper type checks before method calls

### staticMethod.notFound (5 errors)
**Root Cause:** Missing static method implementations  
**Solution:** Implement required static methods

---

## Implementation Checklist

- [ ] All traits reviewed for abstract/implementation mixing
- [ ] All Collections have generic type parameters
- [ ] All models have comprehensive `@property` PHPDoc
- [ ] All methods have explicit return types
- [ ] All array operations have type information
- [ ] All static methods are declared and typed
- [ ] All referenced classes are defined
- [ ] PHPStan analysis passes at Level 10

---

## Enforcement

These rules are enforced through:
1. **PHPStan Level 10** - Automated static analysis
2. **Code Review** - Manual verification before merge
3. **CI/CD Pipeline** - Automatic checks on pull requests
4. **Documentation** - This guide and module-specific docs

---

## Related Documentation

- [PHPStan Analysis Report 2026-03-02](./phpstan-analysis-2026-03-02.md)
- [Cms Module PHPStan Fixes](../laravel/Modules/Cms/docs/phpstan-fixes.md)
- [Fixcity Module PHPStan Fixes](../laravel/Modules/Fixcity/docs/phpstan-level-10-fixes.md)
- [PHPStan Official Documentation](https://phpstan.org/)

---

**Last Updated:** 2026-03-02  
**PHPStan Version:** Level 10  
**Status:** Active & Enforced
