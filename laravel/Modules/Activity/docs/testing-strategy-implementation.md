# Testing Strategy Implementation - Activity Module

## Status

✅ **SnapshotBusinessLogicTest**: Rimosso RefreshDatabase (COMPLETATO)
⚠️  **Esecuzione Test**: Bloccata da conflitti Git in altri file

## Modifiche Applicate

### SnapshotBusinessLogicTest.php

**PRIMA** (errato):
```php
namespace Modules\Activity\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;  // ❌ VIETATO!
```

**DOPO** (corretto):
```php
namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Activity\Models\Snapshot;
// ✅ NO RefreshDatabase
```

## Documentazione Creata

### 1. no-refresh-database-policy.md

Policy ufficiale che spiega:
- ❌ Perché RefreshDatabase è vietato
- ✅ Pattern manual cleanup corretto
- 🎯 Business logic: multi-connection, Event Sourcing
- 📊 Vantaggi Real-World Fidelity

### 2. snapshot-testing-patterns.md

Best practices per testare Snapshot:
- UUID-based isolation
- Manual cleanup patterns
- Event Sourcing scenarios
- Helper traits opzionali

## Pattern Implementato

### Manual Cleanup con UUID Isolation

```php
test('snapshot test', function (): void {
    // 1. UUID univoco per isolation
    $uuid = Str::uuid()->toString();

    // 2. Crea snapshot
    $snapshot = Snapshot::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'state' => json_encode(['data' => 'value']),
    ]);

    // 3. Test logic
    expect($snapshot)->toBeInstanceOf(Snapshot::class);

    // 4. ✅ Cleanup MANUALE
    $snapshot->delete();
});
```

**Tutti i 10 test** in `SnapshotBusinessLogicTest.php` seguono questo pattern.

## Business Logic: Perché NO RefreshDatabase

### Motivazione 1: Database Multi-Connection

```
activity    → Activity, Snapshot, ActivityLog
notify      → MailTemplate, Notification
user        → User, Profile, Team
mysql       → Default connection
```

**RefreshDatabase** resetta SOLO connessione default → dati inconsistenti!

### Motivazione 2: Event Sourcing

```
Snapshot = Event Store Pattern
  ├─ aggregate_uuid (entità)
  ├─ aggregate_version (sequenza eventi)
  └─ state (snapshot stato)
```

**RefreshDatabase** cancellerebbe storia eventi → impossibile testare Event Sourcing!

### Motivazione 3: Real Production Fidelity

```
PRODUZIONE: MySQL 8.0
TEST:       MySQL 8.0  ✅ Stesso engine

vs.

RefreshDatabase + SQLite:
- Comportamenti diversi
- Vincoli diversi
- Performance diverse
- Falsi positivi/negativi
```

## Stato Attuale Test

### Test Scritti (10)

✅ All tests use manual cleanup pattern:
1. `it can create snapshot with basic information`
2. `it can create snapshot with complex state`
3. `it can manage snapshot versioning`
4. `it can query snapshots by aggregate uuid`
5. `it can query snapshots by version`
6. `it can handle snapshot with empty state`
7. `it can handle snapshot with null state`
8. `it can restore state from snapshot`
9. `it can compare snapshot versions`
10. `it can handle snapshot with timestamps`

### Esecuzione

⚠️  **Bloccata** da 590+ file con conflitti Git non risolti nel progetto

**Fix Richiesto**: Risoluzione sistematica conflitti Git

```bash
# Trova tutti i conflitti

# Risolvi usando:
git checkout --ours {file}   # Mantieni versione HEAD
# oppure
git checkout --theirs {file}  # Usa versione incoming
```

## Prossimi Passi

### 1. Risoluzione Conflitti Git (URGENTE)

```bash
cd laravel

# Risolvi tutti i conflitti

# Clear cache
php artisan optimize:clear

# Test
php artisan test Modules/Activity/tests/Feature/SnapshotBusinessLogicTest.php
```

### 2. Validazione Test

Dopo risoluzione conflitti:

```bash
# Test singolo
php artisan test --filter=SnapshotBusinessLogicTest

# Test con coverage
php artisan test Modules/Activity --coverage

# PHPStan
./vendor/bin/phpstan analyze Modules/Activity/tests --level=9
```

### 3. Propagazione Pattern

Applicare pattern NO RefreshDatabase a tutti i test Activity:

- [ ] ActivityBusinessLogicTest.php
- [ ] ActivityLogBusinessLogicTest.php
- [ ] Altri test del modulo

## Collegamenti

### Documentazione
- [No RefreshDatabase Policy](./testing/no-refresh-database-policy.md) - **Policy ufficiale**
- [Snapshot Testing Patterns](./testing/snapshot-testing-patterns.md) - **Best practices**
- [Xot Testing Strategy](../../Xot/docs/testing-strategy.md) - **Strategia globale**

### Codice
- [SnapshotBusinessLogicTest](../tests/Feature/SnapshotBusinessLogicTest.php) - **Implementazione**
- [Snapshot Model](../app/Models/Snapshot.php)

---

**Status**: ⚠️  COMPLETATO ma esecuzione test bloccata da conflitti Git
**Pattern**: ✅ Manual Cleanup con UUID Isolation
**Documentazione**: ✅ COMPLETA
**Ultimo aggiornamento**: 27 Ottobre 2025
