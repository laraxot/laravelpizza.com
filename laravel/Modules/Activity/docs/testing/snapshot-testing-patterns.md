# Snapshot Testing Patterns - Best Practices

## Overview

Pattern e best practice per testare il modello `Snapshot` che implementa Event Sourcing snapshot pattern.

## Pattern Fondamentale: Manual Cleanup

```php
test('snapshot test', function (): void {
    // 1. Arrange - Usa UUID univoco
    $uuid = Str::uuid()->toString();
    
    // 2. Act - Crea snapshot
    $snapshot = Snapshot::create([
        'aggregate_uuid' => $uuid,
        'aggregate_version' => 1,
        'state' => json_encode(['data' => 'value']),
    ]);
    
    // 3. Assert - Verifica comportamento
    expect($snapshot)->toBeInstanceOf(Snapshot::class);
    
    // 4. ✅ Cleanup MANUALE
    $snapshot->delete();
});
```

## Best Practices per Snapshot Tests

### 1. UUID Univoci per Isolation

```php
test('multiple snapshots dont interfere', function () {
    $uuid1 = Str::uuid()->toString();
    $uuid2 = Str::uuid()->toString();
    
    $s1 = Snapshot::create(['aggregate_uuid' => $uuid1, 'aggregate_version' => 1]);
    $s2 = Snapshot::create(['aggregate_uuid' => $uuid2, 'aggregate_version' => 1]);
    
    // ✅ Isolati: UUID diversi
    expect(Snapshot::where('aggregate_uuid', $uuid1)->count())->toBe(1)
        ->and(Snapshot::where('aggregate_uuid', $uuid2)->count())->toBe(1);
    
    $s1->delete();
    $s2->delete();
});
```

### 2. Versioning Tests

```php
test('snapshot versioning maintains chronology', function () {
    $uuid = Str::uuid()->toString();
    
    // Crea versioni in ordine
    $versions = collect([1, 2, 3, 4, 5])->map(fn ($v) =>
        Snapshot::create([
            'aggregate_uuid' => $uuid,
            'aggregate_version' => $v,
            'state' => json_encode(['version' => $v]),
        ])
    );
    
    // Verifica ordine cronologico
    $snapshots = Snapshot::where('aggregate_uuid', $uuid)
        ->orderBy('aggregate_version')
        ->get();
    
    expect($snapshots)->toHaveCount(5)
        ->and($snapshots->pluck('aggregate_version')->toArray())->toBe([1, 2, 3, 4, 5]);
    
    // ✅ Cleanup collection
    $versions->each->delete();
});
```

### 3. State Complex Tests

```php
test('snapshot stores complex nested state', function () {
    $complexState = [
        'user' => ['id' => 1, 'name' => 'Test'],
        'permissions' => ['create', 'read', 'update'],
        'metadata' => [
            'timestamps' => [
                'created' => now()->toISOString(),
                'modified' => now()->toISOString(),
            ],
            'flags' => ['active' => true, 'verified' => false],
        ],
    ];
    
    $snapshot = Snapshot::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => json_encode($complexState),
    ]);
    
    // Assert deep nesting
    expect($snapshot->state)->toBeArray()
        ->and($snapshot->state['user']['name'])->toBe('Test')
        ->and($snapshot->state['permissions'])->toHaveCount(3)
        ->and($snapshot->state['metadata']['flags']['active'])->toBeTrue();
    
    $snapshot->delete();
});
```

### 4. Query Pattern Tests

```php
test('can query latest snapshot version', function () {
    $uuid = Str::uuid()->toString();
    
    $s1 = Snapshot::create(['aggregate_uuid' => $uuid, 'aggregate_version' => 1]);
    $s2 = Snapshot::create(['aggregate_uuid' => $uuid, 'aggregate_version' => 5]);
    $s3 = Snapshot::create(['aggregate_uuid' => $uuid, 'aggregate_version' => 10]);
    
    // Query latest
    $latest = Snapshot::where('aggregate_uuid', $uuid)
        ->orderByDesc('aggregate_version')
        ->first();
    
    expect($latest->aggregate_version)->toBe(10);
    
    $s1->delete();
    $s2->delete();
    $s3->delete();
});
```

### 5. Date Range Tests

```php
test('can filter snapshots by date range', function () {
    $yesterday = now()->subDay();
    $today = now();
    
    $s1 = Snapshot::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => json_encode(['date' => 'yesterday']),
        'created_at' => $yesterday,
    ]);
    
    $s2 = Snapshot::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => json_encode(['date' => 'today']),
        'created_at' => $today,
    ]);
    
    $todaySnapshots = Snapshot::whereDate('created_at', today())->get();
    
    expect($todaySnapshots)->toHaveCount(1)
        ->and($todaySnapshots->first()->state['date'])->toBe('today');
    
    $s1->delete();
    $s2->delete();
});
```

## Cleanup Helpers

### Helper Trait (Opzionale)

```php
// Modules/Activity/tests/Traits/CleansSnapshots.php

trait CleansSnapshots
{
    protected array $createdSnapshots = [];
    
    protected function createSnapshot(array $data): Snapshot
    {
        $snapshot = Snapshot::create($data);
        $this->createdSnapshots[] = $snapshot;
        
        return $snapshot;
    }
    
    protected function tearDown(): void
    {
        foreach ($this->createdSnapshots as $snapshot) {
            $snapshot->delete();
        }
        
        parent::tearDown();
    }
}
```

**Utilizzo**:
```php
uses(CleansSnapshots::class);

test('example', function () {
    $s1 = $this->createSnapshot([...]);  // ✅ Auto-tracked
    $s2 = $this->createSnapshot([...]);  // ✅ Auto-tracked
    
    // Test...
    
    // ✅ Cleanup automatico in tearDown()
});
```

## Testing Event Sourcing Scenarios

### Scenario: Aggregate Reconstruction

```php
test('can reconstruct aggregate from snapshots', function () {
    $uuid = Str::uuid()->toString();
    
    // Crea storia eventi via snapshot
    $snapshots = collect([
        ['version' => 1, 'value' => 100, 'action' => 'created'],
        ['version' => 2, 'value' => 150, 'action' => 'updated'],
        ['version' => 3, 'value' => 200, 'action' => 'finalized'],
    ])->map(fn ($data) =>
        Snapshot::create([
            'aggregate_uuid' => $uuid,
            'aggregate_version' => $data['version'],
            'state' => json_encode($data),
        ])
    );
    
    // Ricostruisci aggregate
    $history = Snapshot::where('aggregate_uuid', $uuid)
        ->orderBy('aggregate_version')
        ->get();
    
    // Simula replay eventi
    $finalState = $history->reduce(function ($state, $snapshot) {
        return array_merge($state, $snapshot->state);
    }, []);
    
    expect($finalState['value'])->toBe(200)
        ->and($finalState['action'])->toBe('finalized');
    
    $snapshots->each->delete();
});
```

## Collegamenti

### Documentazione
- [Testing Strategy](../../Xot/docs/testing-strategy.md) - **Policy ufficiale**
- [No RefreshDatabase Policy](./no-refresh-database-policy.md)
- [Event Sourcing Introduction](../event-sourcing-introduction.md)
- [Snapshot Model](../models/snapshot-model.md)

### Test Esempi
- [SnapshotBusinessLogicTest](../tests/Feature/SnapshotBusinessLogicTest.php)
- [ActivityBusinessLogicTest](../tests/Feature/ActivityBusinessLogicTest.php)

---

**Pattern**: Manual Cleanup con UUID Isolation  
**Status**: ✅ STANDARD PROGETTO  
**Ultimo aggiornamento**: 27 Ottobre 2025

