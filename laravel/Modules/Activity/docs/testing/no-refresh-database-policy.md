# Policy: MAI Usare RefreshDatabase nei Test

## Regola Fondamentale

**In questo progetto è VIETATO l'uso del trait `RefreshDatabase` nei test.**

```php
// ❌ MAI FARE QUESTO
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyTest extends TestCase
{
    use RefreshDatabase;  // ← VIETATO!
}
```

```php
// ✅ PATTERN CORRETTO
class MyTest extends TestCase
{
    // NO trait RefreshDatabase
    // Cleanup manuale se necessario
}
```

## Business Logic

### Perché NON Usare RefreshDatabase?

#### 1. Database Multi-Connection

Il progetto usa **multiple connessioni database**:

```php
// Modelli con connection custom
class Activity extends BaseModel
{
    protected $connection = 'activity';  // ← Connessione dedicata
}

class MailTemplate extends BaseModel
{
    protected $connection = 'notify';  // ← Connessione dedicata
}

class User extends BaseModel
{
    protected $connection = 'user';  // ← Connessione dedicata
}
```

**Problema con RefreshDatabase**:
- Resetta **SOLO** la connessione default
- Le altre connessioni **NON** vengono resettate
- Causa inconsistenze tra database
- Dati "fantasma" persistono in connessioni secondarie

#### 2. Real-World Fidelity

**Obiettivo**: Test che rispecchiano la produzione

```php
// PRODUZIONE
DB_CONNECTION=mysql
DB_DATABASE=ptvx_production

// TEST
DB_CONNECTION=mysql         // ✅ Stesso engine
DB_DATABASE=ptvx_test       // ✅ Database separato ma stesso tipo
```

**Vantaggi**:
- ✅ Scopre problemi MySQL-specific
- ✅ Performance characteristics realistiche
- ✅ Testa vincoli database reali
- ✅ Comportamento identico a produzione

**RefreshDatabase con SQLite** → falsi positivi/negativi

#### 3. Event Sourcing e Snapshots

Il modulo Activity usa **Event Sourcing**:

```php
// Event Store Pattern
Activity (eventi)
  └─> Snapshot (stato aggregate)
       └─> Versioning (1, 2, 3...)
```

**Problema con RefreshDatabase**:
- Resetta tutto → perde **storia eventi**
- Event sourcing RICHIEDE persistenza eventi
- Snapshot versioning perde senso se resettiamo
- Impossibile testare replay eventi

**Pattern Corretto**: Cleanup selettivo manuale

```php
test('snapshot versioning works', function () {
    $uuid = Str::uuid();
    
    // Crea versioni 1, 2, 3
    $s1 = Snapshot::create(['aggregate_uuid' => $uuid, 'aggregate_version' => 1]);
    $s2 = Snapshot::create(['aggregate_uuid' => $uuid, 'aggregate_version' => 2]);
    $s3 = Snapshot::create(['aggregate_uuid' => $uuid, 'aggregate_version' => 3]);
    
    // Test versioning logic
    expect(Snapshot::where('aggregate_uuid', $uuid)->count())->toBe(3);
    
    // ✅ Cleanup MANUALE
    $s1->delete();
    $s2->delete();
    $s3->delete();
});
```

#### 4. Testing Strategy Documentata

Esiste documentazione ufficiale: `Modules/Xot/docs/testing-strategy.md`

**Strategia Approvata**:
- MySQL real database per test
- Manual cleanup invece di RefreshDatabase
- Test isolation tramite UUID univoci
- Cleanup esplicito a fine test

### Vantaggi Pattern Manuale

#### 1. Controllo Granulare

```php
test('user creation', function () {
    $user = User::factory()->create();
    
    // Test logic...
    
    // ✅ Cleanup SOLO ciò che abbiamo creato
    $user->forceDelete();
});
```

#### 2. Debug Facilitato

```php
test('complex workflow', function () {
    $record = Model::create([...]);
    
    // Se test fallisce, il record RESTA nel database
    // Posso ispezionarlo con:
    // - MySQL Workbench
    // - php artisan tinker
    // - SELECT * FROM ...
    
    $record->delete();  // Cleanup esplicito
});
```

#### 3. Test Paralleli

```php
test('parallel safe test', function () {
    // Usa UUID univoci
    $uuid = Str::uuid();
    
    $snapshot = Snapshot::create([
        'aggregate_uuid' => $uuid,  // ← Univoco!
        // ...
    ]);
    
    // Nessun conflitto con altri test paralleli
    
    $snapshot->delete();
});
```

#### 4. Performance Predicibili

- NO overhead migration re-run
- NO locking database per transaction
- Velocità costante (non dipende da # tabelle)

## Pattern Corretto per Test Activity

### SnapshotBusinessLogicTest - Esempio

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

// ❌ NO: use RefreshDatabase;
// ✅ SÌ: Manual cleanup

test('it can create snapshot', function (): void {
    // Arrange
    $snapshotData = [
        'aggregate_uuid' => Str::uuid()->toString(),  // UUID univoco
        'aggregate_version' => 1,
        'state' => json_encode(['name' => 'Test']),
    ];
    
    // Act
    $snapshot = Snapshot::create($snapshotData);
    
    // Assert
    expect($snapshot->aggregate_uuid)->toBe($snapshotData['aggregate_uuid']);
    
    // ✅ Cleanup MANUALE
    $snapshot->delete();
});
```

### Cleanup Strategies

#### Strategy 1: Inline Cleanup (Preferita)

```php
test('example test', function () {
    $record = Model::create([...]);
    
    // ... test logic ...
    
    $record->delete();  // ✅ Cleanup a fine test
});
```

#### Strategy 2: AfterEach Hook

```php
uses(TestCase::class);

beforeEach(function () {
    // Setup se necessario
});

afterEach(function () {
    // ✅ Cleanup globale se serve
    Snapshot::whereDate('created_at', today())->delete();
});
```

#### Strategy 3: UUID-Based Isolation

```php
test('isolated test', function () {
    $testUuid = 'test-'.Str::uuid();
    
    // Usa testUuid per isolare dati
    $record = Model::create(['uuid' => $testUuid]);
    
    // Test...
    
    // Cleanup tutti i record con questo UUID
    Model::where('uuid', 'like', 'test-%')->delete();
});
```

## Anti-Pattern da Evitare

### ❌ Anti-Pattern 1: RefreshDatabase

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class Test extends TestCase
{
    use RefreshDatabase;  // ← VIETATO!
}
```

**Problemi**:
- Reset solo connessione default
- Perde eventi Event Sourcing
- Falsi positivi con SQLite
- Overhead performance

### ❌ Anti-Pattern 2: DatabaseTransactions

```php
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Test extends TestCase
{
    use DatabaseTransactions;  // ← Evitare con multi-connection
}
```

**Problemi**:
- Transaction solo su connessione default
- Altre connessioni non in transaction
- Problemi con nested transactions
- Deadlock potenziali

### ❌ Anti-Pattern 3: Global Truncate

```php
protected function setUp(): void
{
    parent::setUp();
    
    // ❌ Truncate TUTTE le tabelle ad ogni test
    DB::table('snapshots')->truncate();
    DB::table('activities')->truncate();
    // ...
}
```

**Problemi**:
- Performance pessime
- Reset dati NON creati dal test
- Interferenza tra test
- Lentezza esponenziale

## Checklist Test Cleanup

Ogni test DEVE:

- [ ] **NO** `use RefreshDatabase`
- [ ] **NO** `use DatabaseTransactions` (salvo casi specifici singola connessione)
- [ ] Usa UUID univoci per isolation
- [ ] Cleanup esplicito: `$record->delete()` a fine test
- [ ] Cleanup in `afterEach()` se pattern ripetitivo
- [ ] Commenti che spiegano cleanup strategy

## Esempio Completo Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

/**
 * Test business logic Snapshot model.
 * 
 * ✅ NO RefreshDatabase: Usa MySQL reale con manual cleanup
 * ✅ UUID univoci per test isolation
 * ✅ Cleanup esplicito a fine ogni test
 * 
 * @see \Modules\Xot\docs\testing-strategy.md
 */

test('snapshot versioning maintains history', function (): void {
    $uuid = Str::uuid()->toString();
    
    // Crea 3 versioni
    $v1 = Snapshot::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'state' => json_encode(['version' => 1, 'value' => 100]),
    ]);
    
    $v2 = Snapshot::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 2,
        'state' => json_encode(['version' => 2, 'value' => 200]),
    ]);
    
    $v3 = Snapshot::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 3,
        'state' => json_encode(['version' => 3, 'value' => 300]),
    ]);
    
    // Test event sourcing replay
    $allVersions = Snapshot::where('aggregate_uuid', $uuid)
        ->orderBy('aggregate_version')
        ->get();
    
    expect($allVersions)->toHaveCount(3)
        ->and($allVersions[0]->state['value'])->toBe(100)
        ->and($allVersions[1]->state['value'])->toBe(200)
        ->and($allVersions[2]->state['value'])->toBe(300);
    
    // ✅ Cleanup manuale
    $v1->delete();
    $v2->delete();
    $v3->delete();
});
```

## Eccezioni alla Regola

### Quando DatabaseTransactions È OK

**Scenario**: Test su **SINGOLA connessione** senza Event Sourcing

```php
test('simple user CRUD', function () {
    // Solo se:
    // 1. User usa connessione default
    // 2. Non coinvolge altre connessioni
    // 3. Non è Event Sourcing
    // 4. Cleanup automatico desiderato
    
    DB::beginTransaction();
    
    $user = User::create([...]);
    
    // Test...
    
    DB::rollBack();  // Auto-cleanup
});
```

**MA**: Preferire sempre cleanup esplicito per coerenza.

## Validazione Test

### Script Validazione

```bash
#!/bin/bash
# scripts/validate-no-refresh-database.sh

echo "🔍 Cercando usi vietati di RefreshDatabase..."

FILES=$(grep -r "use RefreshDatabase" --include="*.php" Modules/*/tests/)

if [ -n "$FILES" ]; then
    echo "❌ ERRORI TROVATI:"
    echo "$FILES"
    echo ""
    echo "Fix: Rimuovere 'use RefreshDatabase' e implementare cleanup manuale"
    exit 1
else
    echo "✅ Nessun uso di RefreshDatabase trovato"
    exit 0
fi
```

### Pre-Commit Hook

```bash
# .git/hooks/pre-commit

#!/bin/bash

# Blocca commit se RefreshDatabase presente in test
if git diff --cached --name-only | grep "Test.php$" | xargs grep -l "RefreshDatabase" 2>/dev/null; then
    echo "❌ ERRORE: RefreshDatabase vietato nei test!"
    echo "Consultare: Modules/Xot/docs/testing-strategy.md"
    exit 1
fi
```

## Collegamenti

### Documentazione Ufficiale
- [Testing Strategy](../../Xot/docs/testing-strategy.md) - **Strategia testing approvata**
- [Testing Best Practices](../../Xot/docs/testing-best-practices.md)
- [Real Data vs Mock Testing](../../Xot/docs/archive/testing/real-data-vs-mock-testing-strategy.md)

### Test Esempi
- [SnapshotBusinessLogicTest](../tests/Feature/SnapshotBusinessLogicTest.php) - Esempio corretto
- [ActivityBusinessLogicTest](../tests/Feature/ActivityBusinessLogicTest.php)

---

**Policy Status**: 🔴 OBBLIGATORIA  
**Eccezioni**: Nessuna per modulo Activity (Event Sourcing)  
**Ultimo aggiornamento**: 27 Ottobre 2025

