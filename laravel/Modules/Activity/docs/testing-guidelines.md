# Activity Module - Testing Guidelines

## Pre-requisiti (CRITICO)

**Prima di eseguire i test**, migrare il DB di test:

```bash
php artisan migrate --env=testing --force
```

**phpunit.xml**: `ACTIVITY_LOGGER_DB_CONNECTION=mysql` per usare la connessione default (activity_log migrata su mysql). Nessun hack nel modello: la connessione viene risolta solo via config `activitylog.database_connection`.

La tabella `activity_log` deve avere `subject_id` e `causer_id` come `string(36)` per supportare User UUID. Vedi [subject-id-causer-id-uuid-migration-fix](./errori/subject-id-causer-id-uuid-migration-fix.md).

## Testing Framework Requirements

### Environment Configuration
All tests MUST use `.env.testing` configuration con MySQL (no SQLite), copia carbone del `.env` con suffisso `_test`:
```env
APP_ENV=testing
DB_CONNECTION=mysql
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
DB_DATABASE=<nome progetto>_data_test
DB_DATABASE_USER=<nome progetto>_user_test
=======
DB_DATABASE=laravelpizza_data_test
DB_DATABASE_USER=laravelpizza_user_test
>>>>>>> a038b0f2 (.)
=======
DB_DATABASE=<nome progetto>_data_test
DB_DATABASE_USER=<nome progetto>_user_test
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
DB_DATABASE=laravelpizza_data_test
DB_DATABASE_USER=laravelpizza_user_test
>>>>>>> a038b0f2 (.)
=======
DB_DATABASE=<nome progetto>_data_test
DB_DATABASE_USER=<nome progetto>_user_test
>>>>>>> 9daa1718 (refactor: update project references to use `<nome progetto>` in various documentation and configuration files)
=======
DB_DATABASE=laravelpizza_data_test
DB_DATABASE_USER=laravelpizza_user_test
>>>>>>> a21dc33d (.)
```

### Pest Framework Usage
All tests MUST be written in Pest format. Convert any PHPUnit tests to Pest syntax.

## Business Logic Test Coverage

### 1. Activity Model Tests

#### Core Functionality Tests
```php
<?php

declare(strict_types=1);

use Modules\Activity\Models\Activity;

describe('Activity Business Logic', function () {
    it('creates activity with required fields', function () {
        $activity = Activity::factory()->create([
            'log_name' => 'test_log',
            'description' => 'Test activity',
        ]);

        expect($activity)
            ->toBeInstanceOf(Activity::class)
            ->and($activity->log_name)->toBe('test_log')
            ->and($activity->description)->toBe('Test activity');
    });

    it('validates causer relationship', function () {
        $user = User::factory()->create();
        $activity = Activity::factory()->create([
            'causer_type' => User::class,
            'causer_id' => $user->id,
        ]);

        expect($activity->causer)->toBeInstanceOf(User::class)
            ->and($activity->causer->id)->toBe($user->id);
    });

    it('handles properties as JSON', function () {
        $properties = ['key' => 'value', 'nested' => ['data' => 'test']];
        $activity = Activity::factory()->create([
            'properties' => $properties,
        ]);

        expect($activity->properties->toArray())->toBe($properties);
    });
});
```

### 2. Event Sourcing Tests

#### StoredEvent Business Logic
```php
describe('StoredEvent Business Logic', function () {
    it('stores events immutably', function () {
        $event = StoredEvent::factory()->create();
        $originalData = $event->event_properties;

        // Attempt to modify should not affect stored data
        expect($event->event_properties)->toBe($originalData);
    });

    it('supports event replay', function () {
        $events = StoredEvent::factory()->count(5)->create([
            'aggregate_uuid' => 'test-aggregate',
        ]);

        $replayedEvents = StoredEvent::whereAggregateUuid('test-aggregate')
            ->orderBy('aggregate_version')
            ->get();

        expect($replayedEvents)->toHaveCount(5);
    });
});
```

### 3. Snapshot Business Logic Tests

```php
describe('Snapshot Business Logic', function () {
    it('creates snapshots at intervals', function () {
        $snapshot = Snapshot::factory()->create([
            'aggregate_uuid' => 'test-aggregate',
            'aggregate_version' => 10,
        ]);

        expect($snapshot->aggregate_version)->toBe(10)
            ->and($snapshot->state)->toBeArray();
    });

    it('retrieves latest snapshot', function () {
        Snapshot::factory()->create([
            'aggregate_uuid' => 'test-aggregate',
            'aggregate_version' => 5,
        ]);

        $latestSnapshot = Snapshot::factory()->create([
            'aggregate_uuid' => 'test-aggregate',
            'aggregate_version' => 10,
        ]);

        $retrieved = Snapshot::whereAggregateUuid('test-aggregate')
            ->orderByDesc('aggregate_version')
            ->first();

        expect($retrieved->id)->toBe($latestSnapshot->id);
    });
});
```

### 4. Integration Tests

#### Activity Logging Integration
```php
describe('Activity Logging Integration', function () {
    it('logs model changes automatically', function () {
        $user = User::factory()->create();

        // Trigger activity logging
        $user->update(['name' => 'Updated Name']);

        $activity = Activity::latest()->first();

        expect($activity)
            ->not->toBeNull()
            ->and($activity->subject_type)->toBe(User::class)
            ->and($activity->subject_id)->toBe($user->id);
    });

    it('handles batch operations', function () {
        $batchUuid = 'test-batch-' . uniqid();

        Activity::factory()->count(3)->create([
            'batch_uuid' => $batchUuid,
        ]);

        $batchActivities = Activity::forBatch($batchUuid)->get();

        expect($batchActivities)->toHaveCount(3);
    });
});
```

## Test Organization

### Directory Structure
```
tests/
├── Feature/
│   ├── ActivityBusinessLogicTest.php
│   ├── ActivityManagementTest.php
│   ├── StoredEventBusinessLogicTest.php
│   └── SnapshotBusinessLogicTest.php
└── Unit/
    ├── Models/
    │   ├── ActivityBusinessLogicTest.php
    │   ├── ActivityTest.php
    │   ├── StoredEventBusinessLogicTest.php
    │   └── SnapshotBusinessLogicTest.php
    └── EventSourcingBusinessLogicTest.php
```

### Test Data Management

#### Factory Usage
- Use factories for consistent test data
- Create realistic business scenarios
- Test edge cases and boundary conditions

#### Database Isolation
- Each test should be isolated
- Use database transactions for cleanup
- Avoid test interdependencies

## Performance Testing

### Event Store Performance
```php
it('handles large event volumes efficiently', function () {
    $startTime = microtime(true);

    StoredEvent::factory()->count(1000)->create();

    $endTime = microtime(true);
    $duration = $endTime - $startTime;

    expect($duration)->toBeLessThan(5.0); // 5 seconds max
});
```

### Snapshot Performance
```php
it('creates snapshots efficiently', function () {
    // Create many events
    StoredEvent::factory()->count(100)->create([
        'aggregate_uuid' => 'performance-test',
    ]);

    $startTime = microtime(true);

    // Create snapshot
    Snapshot::factory()->create([
        'aggregate_uuid' => 'performance-test',
        'aggregate_version' => 100,
    ]);

    $endTime = microtime(true);
    $duration = $endTime - $startTime;

    expect($duration)->toBeLessThan(1.0); // 1 second max
});
```

## Quality Standards

### Test Requirements
- All tests use `declare(strict_types=1);`
- Descriptive test names explaining business scenarios
- Complete setup and teardown
- Meaningful assertions
- Error scenario coverage

### Business Logic Focus
- Model relationship integrity
- Business rule enforcement
- Data consistency validation
- Performance characteristics
- Edge case handling

---


**Testing Framework**: Pest
**Environment**: .env.testing
