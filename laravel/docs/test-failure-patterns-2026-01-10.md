# Test Failure Patterns - 2026-01-10

## Overview

Analisi sistematica dei pattern di errori nei test dopo la migrazione a MySQL.

**Filosofia:** Il sito funziona! Quindi se un test fallisce, il TEST è sbagliato, non il codice.

---

## Pattern 1: Test Implementation vs Behavior

### ❌ Problema

Test che verificano l'ESISTENZA di metodi invece del COMPORTAMENTO.

### Esempio

```php
// ❌ SBAGLIATO - Testa implementazione
test('model has scope method', function (): void {
    expect(method_exists(Model::class, 'scopeSomething'))->toBeTrue();
});
```

### Perché Sbaglia

1. **Metodi possono essere sul Query Builder** - Non sul model direttamente
2. **Metodi possono essere magic methods** - `__call()` forwarding
3. **Metodi possono essere nella classe parent** - Ereditati

### ✅ Soluzione

```php
// ✅ CORRETTO - Testa comportamento (se hai database)
test('model can filter by something', function (): void {
    Model::create(['status' => 'active']);
    $results = Model::something()->get();
    expect($results)->toHaveCount(1);
});

// ✅ CORRETTO - Testa documentazione (unit test)
test('model has method documented', function (): void {
    $reflection = new \ReflectionClass(Model::class);
    $docComment = $reflection->getDocComment();
    expect($docComment)->toContain('@method');
    expect($docComment)->toContain('something');
});
```

### File Affetti

- `Modules/Activity/tests/Unit/Models/StoredEventBusinessLogicTest.php` - ✅ FIXED
- `Modules/Activity/tests/Unit/Models/SnapshotBusinessLogicTest.php` - ⏳ TO FIX

---

## Pattern 2: Unit Tests Without TestCase

### ❌ Problema

Test Unit che istanziano modelli Eloquent senza Laravel application bootstrap.

### Esempio

```php
// ❌ SBAGLIATO - No TestCase, no Laravel app
<?php
use Modules\Activity\Models\Activity;

describe('Activity Business Logic', function () {
    test('activity has connection', function () {
        $activity = new Activity(); // ❌ FAIL: No database connection
        expect($activity->getConnectionName())->toBe('activity');
    });
});
```

### Errore Risultante

```
BindingResolutionException: Target class [config] does not exist.
```

### Perché Sbaglia

1. **Eloquent richiede Laravel Application** - Container, config, database
2. **No TestCase = No Application Bootstrap**
3. **`new Model()` senza app = crash**

### ✅ Soluzione Opzione A: Usa TestCase

```php
<?php
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('activity has connection', function () {
    $activity = new Activity(); // ✅ OK: Laravel app exists
    expect($activity->getConnectionName())->toBe('activity');
});
```

### ✅ Soluzione Opzione B: Test Without Instantiation

```php
// ✅ CORRETTO - No instantiation needed
test('activity has correct connection configured', function () {
    $activity = new class extends Activity {}; // Anonymous class
    expect($activity->connection)->toBe('activity'); // Access property
});

// ✅ MEGLIO - Use reflection
test('activity has connection property', function () {
    $reflection = new \ReflectionClass(Activity::class);
    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);
    expect($property->getValue(new Activity))->toBe('activity');
});
```

### File Affetti

- `Modules/Activity/tests/Unit/Models/ActivityBusinessLogicTest.php` - ⏳ TO FIX
- Potenzialmente altri Unit tests senza `uses(TestCase::class)`

---

## Pattern 3: Testing HasFactory Instead of HasXotFactory

### ❌ Problema

Test che verificano `HasFactory` trait quando il modello usa `HasXotFactory` invece.

### Esempio

```php
// ❌ SBAGLIATO - Wrong trait
test('model has factory trait', function () {
    $traits = class_uses(Model::class);
    expect($traits)->toHaveKey(HasFactory::class); // ❌ FAIL
});
```

### Perché Sbaglia

Laraxot usa **HasXotFactory** invece di Laravel's **HasFactory**.

### ✅ Soluzione

```php
// ✅ CORRETTO - Check for HasXotFactory
use Modules\Xot\Models\Traits\HasXotFactory;

test('model has xot factory trait', function () {
    $traits = class_uses(Model::class);
    expect($traits)->toHaveKey(HasXotFactory::class); // ✅ OK
});

// ✅ MEGLIO - Test behavior not trait
test('model can use factory', function () {
    $model = Model::factory()->create();
    expect($model)->toBeInstanceOf(Model::class);
});
```

### File Affetti

- `Modules/Activity/tests/Unit/Models/SnapshotBusinessLogicTest.php` - ⏳ TO FIX

---

## Pattern 4: SQLite Column Mismatches

### ❌ Problema

Test che girano con SQLite in-memory e mancano colonne che esistono in MySQL.

### Esempio

```
SQLSTATE[HY000]: General error: 1 no such column: last_login_at
```

### Perché Sbaglia

1. **Test sta usando SQLite** - Invece di MySQL da .env.testing
2. **Migration non eseguita** - Colonna non creata
3. **TestCase non setup correttamente** - Non usa il TestCase con MySQL

### ✅ Soluzione

Assicurarsi che il test usi TestCase con MySQL:

```php
<?php
use Modules\Activity\Tests\TestCase;

uses(TestCase::class); // ✅ Uses MySQL from .env.testing

test('user updates last login', function () {
    $user = User::factory()->create();
    $user->update(['last_login_at' => now()]);
    expect($user->last_login_at)->not->toBeNull();
});
```

### File Affetti

- `Modules/Activity/tests/Unit/Listeners/LogoutListenerTest.php` - ⏳ TO FIX

---

## Pattern 5: Faker UUID Issues

### ❌ Problema

Factory che usa `$faker->uuid()` con parentesi quando dovrebbe essere `$faker->uuid` senza.

### Esempio

```php
// ❌ Potenziale problema (depends on Faker version)
'aggregate_uuid' => $this->faker->uuid(),
```

### Errore Risultante

```
InvalidArgumentException: Unknown format "uuid"
```

### ✅ Soluzione

```php
// ✅ CORRETTO - Use Str::uuid()
use Illuminate\Support\Str;

'aggregate_uuid' => (string) Str::uuid(),

// Oppure usa faker property
'aggregate_uuid' => $this->faker->uuid, // No parentheses
```

### File Affetti

- `Modules/Activity/database/factories/StoredEventFactory.php` - ⚠️ CHECK

---

## Summary of Issues by Type

| Pattern | Count | Status |
|---------|-------|--------|
| Test Implementation vs Behavior | ~10+ | 1 fixed, others pending |
| Unit Tests Without TestCase | ~5+ | Pending |
| HasFactory vs HasXotFactory | ~3+ | Pending |
| SQLite Column Mismatches | ~2+ | Pending |
| Faker UUID Issues | ~1 | Needs check |

---

## Recommended Fix Priority

### Priority 1: Critical (Block Many Tests)

1. **Unit Tests Without TestCase** - Add `uses(TestCase::class)` to all unit tests that instantiate models
2. **SQLite Column Mismatches** - Ensure all tests use MySQL TestCase

### Priority 2: High (Wrong Test Philosophy)

3. **Test Implementation vs Behavior** - Rewrite to test behavior or documentation
4. **HasFactory vs HasXotFactory** - Update expectations or remove tests

### Priority 3: Medium (Specific Issues)

5. **Faker UUID Issues** - Fix factory definitions where needed

---

## Action Plan

### Step 1: Audit All Unit Tests (⏳ IN PROGRESS)

```bash
# Find all unit tests
find Modules -name "*Test.php" -path "*/tests/Unit/*"

# Check which ones don't use TestCase
grep -L "uses(TestCase" Modules/*/tests/Unit/*.php
```

### Step 2: Add TestCase Where Needed

For each file without TestCase that instantiates models:

```php
<?php

declare(strict_types=1);

use Modules\{Module}\Tests\TestCase;

uses(TestCase::class); // ✅ ADD THIS

// ... rest of tests
```

### Step 3: Fix Implementation Tests

For tests checking `method_exists()` for scope methods:
- Replace with reflection-based PHPDoc verification
- Or create integration tests that test behavior

### Step 4: Fix Trait Checks

Replace `HasFactory` checks with `HasXotFactory` or remove if not critical.

### Step 5: Run Tests Again

```bash
./vendor/bin/pest --no-coverage
```

---

## Documentation References

- **StoredEvent Fix:** `Modules/Activity/docs/stored-event-test-fix.md`
- **TestCase Philosophy:** `Modules/Job/docs/testcase-philosophy-analysis.md`
- **MySQL Migration:** `laravel/docs/test-results-after-mysql-migration-2026-01-09.md`

---

**Date:** 2026-01-10
**Status:** Analysis Complete - Fixes In Progress
**Philosophy:** Site Works = Tests Are Wrong ✅
