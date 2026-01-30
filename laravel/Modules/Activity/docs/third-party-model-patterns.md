# Activity Module - Third-Party Model Patterns

## Spatie Package Integration

### Current Implementation

The Activity module integrates with multiple Spatie packages through direct model extension:

```php
// ✅ CORRECT - Direct Spatie model extension
class Activity extends SpatieActivity
{
    protected $connection = 'activity';
    use HasXotFactory;
}

class StoredEvent extends SpatieStoredEvent
{
    protected $connection = 'activity';
    use HasFactory;
}

class Snapshot extends SpatieSnapshot
{
    protected $connection = 'activity';
}
```

### Package Ecosystem

| Model | Spatie Package | Purpose |
|-------|----------------|---------|
| **Activity** | `spatie/laravel-activitylog` | Comprehensive activity logging |
| **StoredEvent** | `spatie/laravel-event-sourcing` | Event-driven architecture |
| **Snapshot** | `spatie/laravel-event-sourcing` | Event state snapshots |

## Implementation Details

### Activity Model

**File**: `Modules/Activity/app/Models/Activity.php`

```php
class Activity extends SpatieActivity
{
    use HasXotFactory;

    protected $connection = 'activity';

    protected $fillable = [
        'id',
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
        'created_at',
        'updated_at',
    ];
}
```

### StoredEvent Model

**File**: `Modules/Activity/app/Models/StoredEvent.php`

```php
class StoredEvent extends SpatieStoredEvent
{
    use HasFactory;

    protected $connection = 'activity';
    protected $table = 'stored_events';

    protected $fillable = [
        'id',
        'aggregate_uuid',
        'aggregate_version',
        'event_version',
        'event_class',
        'event_properties',
        'meta_data',
        'created_at',
        'updated_by',
        'created_by',
    ];
}
```

### Snapshot Model

**File**: `Modules/Activity/app/Models/Snapshot.php`

```php
class Snapshot extends SpatieSnapshot
{
    protected $connection = 'activity';
}
```

## Laraxot Enhancements

### Connection Isolation

```php
protected $connection = 'activity';
```

Benefits:
- **Performance**: Isolated activity database
- **Scalability**: Separate activity storage
- **Maintenance**: Independent backup and recovery

### Factory Integration

```php
use HasXotFactory;  // Laraxot factory system
use HasFactory;     // Laravel factory system
```

### Extended Fields

**StoredEvent extensions**:
- `updated_by`: Audit tracking
- `created_by`: Audit tracking

## Package Architecture Integration

### ActivityLog Package

Spatie's ActivityLog provides:
- **Automatic Logging**: Model event logging
- **Causer Tracking**: User action tracking
- **Property Changes**: Before/after state tracking
- **Batch Operations**: Grouped activity logging

### EventSourcing Package

Spatie's EventSourcing provides:
- **Event Storage**: Immutable event storage
- **Aggregate Roots**: Domain-driven design patterns
- **Projections**: Event projection system
- **Snapshots**: Performance optimization

## Configuration

### Database Schema

Migrations follow Spatie's table structure:

```php
// Activity table (spatie/laravel-activitylog)
$this->tableCreate(function (Blueprint $table) {
    $table->id();
    $table->string('log_name')->nullable();
    $table->text('description');
    $table->nullableMorphs('subject');
    $table->nullableMorphs('causer');
    $table->json('properties')->nullable();
    $table->uuid('batch_uuid')->nullable();
    $table->string('event')->nullable();
    $table->timestamps();
});

// StoredEvent table (spatie/laravel-event-sourcing)
$this->tableCreate(function (Blueprint $table) {
    $table->id();
    $table->uuid('aggregate_uuid')->nullable();
    $table->unsignedInteger('aggregate_version')->nullable();
    $table->unsignedInteger('event_version')->default(1);
    $table->string('event_class');
    $table->json('event_properties');
    $table->json('meta_data');
    $table->timestamps();
});
```

## Testing Strategy

### Package Functionality Tests

```php
// Test Spatie activity logging
public function test_activity_logging(): void
{
    $user = User::factory()->create();

    activity()
        ->causedBy($user)
        ->log('User created');

    $this->assertDatabaseHas('activity_log', [
        'description' => 'User created',
        'causer_type' => User::class,
        'causer_id' => $user->id,
    ]);
}
```

### Event Sourcing Tests

```php
// Test event sourcing functionality
public function test_event_storage(): void
{
    $event = new TestEvent(['data' => 'test']);

    StoredEvent::create([
        'event_class' => TestEvent::class,
        'event_properties' => ['data' => 'test'],
        'aggregate_uuid' => 'test-uuid',
        'aggregate_version' => 1,
    ]);

    $this->assertCount(1, StoredEvent::all());
}
```

## Best Practices

### ✅ DO

- Extend Spatie models directly
- Use `activity` database connection
- Follow Spatie's table naming conventions
- Test package integration thoroughly
- Document package-specific features

### ❌ DON'T

- Modify Spatie's core table structure
- Break package update compatibility
- Replicate package functionality
- Ignore package best practices

## Performance Considerations

### Activity Logging

- **Batch Operations**: Use Spatie's batch UUID for performance
- **Selective Logging**: Configure which events to log
- **Cleanup**: Implement regular activity log cleanup

### Event Sourcing

- **Snapshot Strategy**: Use snapshots for performance
- **Projection Optimization**: Optimize event projections
- **Storage Strategy**: Consider event archiving

## Documentation References

### Package Documentation
- [Spatie Laravel ActivityLog](https://spatie.be/docs/laravel-activitylog/v4/introduction)
- [Spatie Laravel EventSourcing](https://spatie.be/docs/laravel-event-sourcing/v1/introduction)

### Laraxot Philosophy
- [Third-Party Model Inheritance](../Xot/docs/third-party-model-inheritance-philosophy.md)
- [Event Sourcing Patterns](../Xot/docs/event-sourcing-patterns.md)

---

**Integration Status**: ✅ Fully compatible with Spatie package ecosystem
**Performance**: High - leverages optimized package implementations
**Scalability**: Excellent - designed for high-volume activity logging