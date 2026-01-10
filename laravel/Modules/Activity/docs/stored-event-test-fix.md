# StoredEvent Business Logic Test Fix

## Problema Identificato

Il test `StoredEventBusinessLogicTest.php` sta fallendo perché cerca metodi che non esistono direttamente nella classe.

### ❌ Test Sbagliato

```php
test('stored event has after version scope method', function (): void {
    expect(method_exists(StoredEvent::class, 'scopeAfterVersion'))->toBeTrue();
});

test('stored event has where aggregate root scope method', function (): void {
    expect(method_exists(StoredEvent::class, 'scopeWhereAggregateRoot'))->toBeTrue();
});

test('stored event has where event scope method', function (): void {
    expect(method_exists(StoredEvent::class, 'scopeWhereEvent'))->toBeTrue();
});
```

**Errore:**
```
Failed asserting that false is true.
```

---

## Analisi del Problema

### Dove Sono i Metodi?

Il modello `StoredEvent` estende `Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent`.

**I metodi NON sono nel Model, ma nel Query Builder custom di Spatie:**

```php
/**
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent afterVersion(int $version)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateRoot(string $uuid)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereEvent(string ...$eventClasses)
 */
class StoredEvent extends SpatieStoredEvent
```

### Differenza Critica

**Scope Methods vs Query Builder Methods:**

1. **Scope Method** (Laravel convention):
   ```php
   // Nel model
   public function scopeAfterVersion($query, int $version) {
       return $query->where('aggregate_version', '>', $version);
   }

   // Uso
   StoredEvent::afterVersion(5)->get();
   ```

2. **Query Builder Method** (Spatie convention):
   ```php
   // Nel EloquentStoredEventQueryBuilder (classe separata)
   public function afterVersion(int $version): self {
       return $this->where('aggregate_version', '>', $version);
   }

   // Uso (identico)
   StoredEvent::afterVersion(5)->get();
   ```

**Il test cerca `scopeAfterVersion` nel Model, ma il metodo è `afterVersion` nel Query Builder!**

---

## Perché Il Sito Funziona

Il sito funziona perché:

1. ✅ I metodi esistono nel `EloquentStoredEventQueryBuilder` di Spatie
2. ✅ Laravel forwarda automaticamente i metodi statici al query builder
3. ✅ L'uso è identico: `StoredEvent::afterVersion(5)->get()`
4. ✅ PHPStan è soddisfatto grazie ai @method annotations

**Conclusione:** Il test sta verificando IMPLEMENTAZIONE (method_exists), non COMPORTAMENTO.

---

## Soluzione

### Opzione 1: Testare il Comportamento (RACCOMANDATO)

```php
test('stored event can query after specific version', function (): void {
    // Crea eventi con versioni diverse
    StoredEvent::factory()->create(['aggregate_version' => 1]);
    StoredEvent::factory()->create(['aggregate_version' => 2]);
    StoredEvent::factory()->create(['aggregate_version' => 3]);

    // Testa che il metodo funzioni
    $results = StoredEvent::afterVersion(1)->get();

    expect($results)->toHaveCount(2);
    expect($results->pluck('aggregate_version')->all())->toEqual([2, 3]);
});

test('stored event can query by aggregate root uuid', function (): void {
    $uuid = 'test-uuid-123';

    StoredEvent::factory()->create(['aggregate_uuid' => $uuid]);
    StoredEvent::factory()->create(['aggregate_uuid' => 'other-uuid']);

    $results = StoredEvent::whereAggregateRoot($uuid)->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->aggregate_uuid)->toBe($uuid);
});

test('stored event can query by event class', function (): void {
    $eventClass = 'App\\Events\\UserCreated';

    StoredEvent::factory()->create(['event_class' => $eventClass]);
    StoredEvent::factory()->create(['event_class' => 'App\\Events\\UserUpdated']);

    $results = StoredEvent::whereEvent($eventClass)->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->event_class)->toBe($eventClass);
});
```

### Opzione 2: Eliminare i Test (SE NON CRITICO)

Se il comportamento è già testato da Spatie e il sito funziona, eliminare questi test ridondanti.

```php
// ❌ ELIMINA questi test - testano implementazione di libreria esterna
test('stored event has after version scope method', function (): void {
    expect(method_exists(StoredEvent::class, 'scopeAfterVersion'))->toBeTrue();
});
```

---

## Pattern: Test Behavior, Not Implementation

### ❌ SBAGLIATO - Test Implementation

```php
// Testa se un metodo esiste
test('model has method', function (): void {
    expect(method_exists(Model::class, 'scopeSomething'))->toBeTrue();
});

// Testa se una proprietà ha un valore specifico
test('model has specific fillable', function (): void {
    expect($model->getFillable())->toEqual(['id', 'name', 'email']);
});
```

### ✅ CORRETTO - Test Behavior

```php
// Testa che il metodo FUNZIONI correttamente
test('model can filter by something', function (): void {
    Model::create(['status' => 'active']);
    Model::create(['status' => 'inactive']);

    $results = Model::something()->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->status)->toBe('active');
});

// Testa che i dati POSSANO essere salvati
test('model can save data', function (): void {
    $model = Model::create([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);

    expect($model->name)->toBe('Test');
    expect($model->email)->toBe('test@example.com');
});
```

---

## Decision: Opzione 1 (Test Behavior)

**Scelta:** Riscrivere i test per verificare il COMPORTAMENTO dei query builder methods.

**Motivazione:**
1. Test più robusti - verificano funzionalità reale
2. Test più significativi - se falliscono, c'è un problema reale
3. Test indipendenti da implementazione - non si rompono se Spatie cambia internals
4. Migliore coverage - testa anche dati e risultati

---

## Implementazione

### File: `Modules/Activity/tests/Unit/Models/StoredEventBusinessLogicTest.php`

**Rimuovere:**
```php
test('stored event has after version scope method', function (): void {
    expect(method_exists(StoredEvent::class, 'scopeAfterVersion'))->toBeTrue();
});

test('stored event has where aggregate root scope method', function (): void {
    expect(method_exists(StoredEvent::class, 'scopeWhereAggregateRoot'))->toBeTrue();
});

test('stored event has where event scope method', function (): void {
    expect(method_exists(StoredEvent::class, 'scopeWhereEvent'))->toBeTrue();
});
```

**Sostituire con:** Test di comportamento che creano dati reali e verificano query.

---

## Riferimenti

- Pattern: Test behavior not implementation
- Filosofia: Il sito funziona = il test è sbagliato
- Spatie Event Sourcing: https://spatie.be/docs/laravel-event-sourcing/

---

**Data:** 2026-01-10
**Stato:** Pronto per implementazione
**Test Type:** Behavior > Implementation ✅
