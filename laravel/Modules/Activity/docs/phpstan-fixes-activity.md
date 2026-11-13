---
title: fix phpstan modulo activity
type: memory
tags: [phpstan, activity, filament]
created: 2026-05-21
updated: 2026-05-27
status: approved
related:
  - ./phpstan-analysis-activity.md
  - ../../../../docs/wiki/memories/phpstan-modules-inventory.md
---

# Fix PHPStan — modulo Activity

> Pattern riusabili e ultimo scan; **updated** in YAML — mai date nel nome file.

## Ultimo scan — risolto (0 errori)

**Issue:** [provtv/module_activity_fila5#10](https://github.com/provtv/module_activity_fila5/issues/10)

| Area | Fix applicato |
|------|----------------|
| `ListLogActivities.php` | `translationToString()` per `__()` → stringa |
| `*Form.php` / `ActivityInfolist.php` | `@return array<string, Filament\Schemas\Components\Component>` |
| `ActivitysTable.php` | PHPDoc duplicato rimosso |
| `lang/it/snapshot.php` | Chiavi duplicate rimosse |

---

## phpstan fixes per modulo activity

**Stato attuale (2026-06-10)**: `./vendor/bin/phpstan analyse Modules/Activity` → **0 errori** (livello max, senza baseline e senza modifiche a `phpstan.neon`).

### test pest/phpunit (causa principale delle segnalazioni)

- **Contesto**: il codice `app/` era già conforme; oltre 1000 errori erano nei test (Pest + factory + asserzioni migrate male).
- **Factory**: `Model::factory()->create()` è `mixed` per PHPStan → usare `XxxFactory::new()->createOne()` per un record e `->count(n)->create()` per batch.
- **Asserzioni**: sostituire `expect()` e `$this->assert*` nelle closure Pest con `PHPUnit\Framework\Assert` (PHPStan tipizza `$this` come `TestCall`, non `TestCase`).
- **Modelli concreti**: evitare `new BaseModel` (astratto) → `TestActivityModel` o classi in `tests/Fixtures/`.
- **Relazioni / mock Filament**: stub concreti in `tests/Fixtures/` (es. `ListLogActivitiesActionStubs.php`) al posto di `Mockery` dove PHPStan non risolve l'unione.
- **Logout senza utente**: creare `Logout` con utente reale e azzerare `user` via `ReflectionClass` (il costruttore non accetta `null`).
- **Properties schemaless**: normalizzare `array|Collection` prima di `assertArrayHasKey` / `array_merge`.
- **Script di supporto** (fuori da `Modules/Activity` per non essere analizzati): `laravel/scripts/activity/fix-phpstan-tests.php`.

### listlogactivities (filament page)

- **Problemi rilevati**:
  - `getTitle()` dichiarato `string` ma PHPStan vedeva `mixed` (Htmlable|string).
  - `createFieldLabelMap()` usava `mapWithKeys()` su una collection non tipizzata, producendo template `*NEVER*`.
  - `Notification::title()` riceveva valori non tipizzati (`array|string|null`) generando errori `argument.type` e `cast.string`.

- **Soluzioni applicate**:
  - Normalizzazione di `getTitle()` con cast esplicito a `string` dopo gestione `Htmlable` → `string`.
  - Tipizzazione esplicita di `createFieldLabelMap()` come `Collection<string, string>` e normalizzazione degli array figli con `array_values()` prima di `merge()` per rispettare i generics di Laravel Collection.
  - Uso di `->title(fn (): string => (string) __('...'))` nelle notifiche, in modo che `Notification::title()` riceva sempre una `Closure<string>` sicura.

### activity (modello spatie activitylog)

- **Problemi rilevati**:
  - Vari errori `return.type` su metodi statici wrapper del query builder (`query, selectRaw, latest, limit, with, count, clone, where*`) che creavano unioni di tipi incompatibili con il builder generico atteso da PHPStan.

- **Soluzioni applicate**:
  - Rimozione di tutti i wrapper statici superflui che delegavano semplicemente a `static::query()...`.
  - Mantenimento delle sole annotazioni `@method` nella PHPDoc, affidando il contratto di tipo alla classe base `Spatie\Activitylog\Models\Activity` e ai suoi stub PHPStan.

### activitymassseeder (seeder di massa)

- **Problemi rilevati**:
  - `method.notFound` e `method.nonObject` su `Snapshot::count()` e `StoredEvent::where(...)->count()` a causa di unioni di tipo sui builder generici.

- **Soluzioni applicate**:
  - Introduzione di variabili builder tipizzate:
    - `/** @var \Illuminate\Database\Eloquent\Builder<Snapshot> $snapshotQuery */ $snapshotQuery = Snapshot::query();`
    - `/** @var \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<StoredEvent> $storedEventQuery */ $storedEventQuery = StoredEvent::query();`
  - Tutte le chiamate a `count()` e `where()` avvengono ora su variabili con tipo noto, eliminando le ambiguità per PHPStan.

### pattern riutilizzabili

- **Non duplicare il query builder statico**: per modelli che estendono classi base Spatie o Laravel già supportate da PHPStan, evitare override statici dei metodi fluent e affidarsi a `@method` nella PHPDoc.
- **Collection tipizzate**: quando si usa `mapWithKeys()` o `merge()` su componenti Filament, tipizzare chiaramente `Collection<int, Component>` → `Collection<string, string>` e normalizzare gli array con `array_values()`.
- **Builder specializzati**: per builder custom (es. `EloquentStoredEventQueryBuilder`), assegnare sempre a una variabile annotata prima di invocare `count()/where()`.

Queste regole vanno seguite per tutte le future modifiche al modulo Activity e aggiornate in questa doc quando emergono nuovi pattern di correzione.
# Correzioni PHPStan - Modulo Activity

## 🚨 Errori PHPStan Risolti

### 1. StoredEventFactory.php - Type Safety
**Errore**: `array_merge` con parametri mixed invece di array
**Soluzione**: Cast esplicito per garantire type safety

```php
// ✅ CORRETTO
'event_properties' => array_merge(
    is_array($attributes['event_properties'] ?? []) ? $attributes['event_properties'] : [],
    [
        'user_id' => $this->faker->numberBetween(1, 100),
        'action' => 'user_registered',
    ]
),
```

### 2. ActivityMassSeeder.php - Factory Method
**Errore**: `Activity::factory()` metodo non trovato
**Soluzione**: Utilizzo diretto della factory class

```php
// ✅ CORRETTO
$activities = \Modules\Activity\Database\Factories\ActivityFactory::new()
    ->count(2000)
    ->create([
        'created_at' => Carbon::now()->subDays(rand(1, 90)),
    ]);
```

### 3. File Traduzione - Chiavi Duplicate
**Errore**: Chiavi 'navigation' e 'fields' duplicate nei file DE e EN
**Soluzione**: Rimozione sezioni duplicate alla fine dei file

## ✅ Risultati

- **Type safety**: Garantita per factory
- **Factory calls**: Corretti per seeder
- **Translation files**: Chiavi duplicate rimosse
- **PHPStan Level 9**: Compliance ripristinata

*Ultimo aggiornamento: gennaio 2025*