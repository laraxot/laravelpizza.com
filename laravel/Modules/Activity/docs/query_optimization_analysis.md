# Activity Module - Query Optimization Analysis

## Overview
The Activity module has several critical query performance issues, particularly around activity logging, event sourcing, and batch processing. This analysis identifies specific inefficiencies and provides concrete optimization strategies.

## Critical Query Issues Identified

### 1. Activity Log Retrieval (HIGH IMPACT)

**File**: `Modules/Activity/app/Filament/Resources/ActivityResource.php`
**Problem**: Missing eager loading for polymorphic relationships

```php
// Current inefficient pattern
public static function getTableQuery(): Builder
{
    return parent::getTableQuery()
        ->latest(); // No eager loading for subject/causer
}
```

**Issue**: Each activity record triggers 2 additional queries to load subject and causer:
- Query 1: `SELECT * FROM activity_log ORDER BY created_at DESC LIMIT 50`
- Query 2-101: `SELECT * FROM users WHERE id = ?` (for each causer)
- Query 102-151: `SELECT * FROM [model_table] WHERE id = ?` (for each subject)

**Optimization**:
```php
public static function getTableQuery(): Builder
{
    return parent::getTableQuery()
        ->with(['subject', 'causer'])
        ->latest();
}

// Add to ActivityResource table configuration
Tables\Columns\TextColumn::make('causer.name')
    ->label('User')
    ->sortable(['causer_type', 'causer_id'])
    ->searchable(),
```

### 2. Batch Activity Processing (CRITICAL)

**File**: `Modules/Activity/app/Models/Activity.php`
**Problem**: Individual database inserts for batch operations

```php
// Current inefficient pattern - found in listeners
foreach ($items as $item) {
    activity()
        ->on($item)
        ->by($user)
        ->log('Item processed');
}
```

**Issue**: Each loop iteration creates a separate database transaction
**Impact**: 1000 items = 1000 separate INSERT queries

**Optimization**:
```php
// Batch insert approach
$activities = collect($items)->map(function ($item) use ($user) {
    return [
        'log_name' => 'default',
        'description' => 'Item processed',
        'subject_type' => get_class($item),
        'subject_id' => $item->id,
        'causer_type' => get_class($user),
        'causer_id' => $user->id,
        'properties' => json_encode([]),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});

Activity::insert($activities->toArray());
```

### 3. Activity Search and Filtering (HIGH IMPACT)

**File**: Filament ActivityResource table filters
**Problem**: Inefficient filtering without proper indexes

```php
// Current filtering causes full table scans
Tables\Filters\SelectFilter::make('log_name')
    ->options(function () {
        return Activity::distinct()
            ->pluck('log_name', 'log_name')
            ->toArray(); // Scans entire table!
    }),
```

**Required Database Optimization**:
```sql
-- Add composite indexes for common filter combinations
CREATE INDEX idx_activity_log_name_created ON activity_log(log_name, created_at);
CREATE INDEX idx_activity_subject_type_created ON activity_log(subject_type, created_at);
CREATE INDEX idx_activity_causer_created ON activity_log(causer_type, causer_id, created_at);
CREATE INDEX idx_activity_batch_uuid ON activity_log(batch_uuid) WHERE batch_uuid IS NOT NULL;
```

**Optimized Filter Options**:
```php
Tables\Filters\SelectFilter::make('log_name')
    ->options(function () {
        return Cache::remember('activity_log_names', 3600, function () {
            return Activity::select('log_name')
                ->distinct()
                ->orderBy('log_name')
                ->pluck('log_name', 'log_name')
                ->toArray();
        });
    }),
```

### 4. Event Sourcing Query Patterns (MEDIUM IMPACT)

**File**: `Modules/Activity/app/Models/StoredEvent.php`
**Problem**: Inefficient event replay queries

```php
// Current pattern loads all events into memory
public function getEventsAfter($timestamp)
{
    return StoredEvent::where('created_at', '>', $timestamp)
        ->orderBy('created_at')
        ->get(); // Loads potentially millions of records!
}
```

**Optimization**:
```php
// Use chunked processing for large event replays
public function replayEventsAfter($timestamp, callable $callback)
{
    StoredEvent::where('created_at', '>', $timestamp)
        ->orderBy('created_at')
        ->chunk(1000, function ($events) use ($callback) {
            foreach ($events as $event) {
                $callback($event);
            }
        });
}

// For Filament display, use pagination
public static function getTableQuery(): Builder
{
    return parent::getTableQuery()
        ->select(['id', 'event_class', 'created_at', 'aggregate_uuid'])
        ->latest();
}
```

### 5. Snapshot Generation (HIGH IMPACT)

**File**: `Modules/Activity/app/Models/Snapshot.php`
**Problem**: Heavy aggregation queries without optimization

```php
// Current expensive aggregation
public function generateSnapshot($aggregateId)
{
    $events = StoredEvent::where('aggregate_uuid', $aggregateId)
        ->orderBy('created_at')
        ->get(); // Loads all events for aggregate

    // Heavy processing in PHP instead of database
    $state = [];
    foreach ($events as $event) {
        $state = $this->applyEvent($state, $event);
    }
}
```

**Optimization**:
```php
// Use database aggregation where possible
public function generateSnapshot($aggregateId)
{
    // Get latest snapshot first
    $latestSnapshot = Snapshot::where('aggregate_uuid', $aggregateId)
        ->latest('created_at')
        ->first();

    $fromDate = $latestSnapshot ? $latestSnapshot->created_at : null;

    // Only process events since last snapshot
    $query = StoredEvent::where('aggregate_uuid', $aggregateId)
        ->orderBy('created_at');

    if ($fromDate) {
        $query->where('created_at', '>', $fromDate);
    }

    // Use chunked processing
    $state = $latestSnapshot ? $latestSnapshot->state : [];

    $query->chunk(500, function ($events) use (&$state) {
        foreach ($events as $event) {
            $state = $this->applyEvent($state, $event);
        }
    });
}
```

## Activity Module Specific Optimizations

### Database Schema Improvements
```sql
-- Activity log partitioning for large datasets
ALTER TABLE activity_log PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2023 VALUES LESS THAN (2024),
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION pmax VALUES LESS THAN MAXVALUE
);

-- Stored events optimization
CREATE INDEX idx_stored_events_aggregate_created ON stored_events(aggregate_uuid, created_at);
CREATE INDEX idx_stored_events_event_class ON stored_events(event_class);

-- Snapshots optimization
CREATE INDEX idx_snapshots_aggregate_created ON snapshots(aggregate_uuid, created_at DESC);
```

### Caching Strategy
```php
// Activity statistics caching
class ActivityStatsService
{
    public function getTodayStats(): array
    {
        return Cache::remember('activity_today_stats', 300, function () {
            return [
                'total_activities' => Activity::whereDate('created_at', today())->count(),
                'unique_users' => Activity::whereDate('created_at', today())
                    ->distinct('causer_id')
                    ->count('causer_id'),
                'top_actions' => Activity::whereDate('created_at', today())
                    ->groupBy('description')
                    ->selectRaw('description, COUNT(*) as count')
                    ->orderByDesc('count')
                    ->limit(5)
                    ->pluck('count', 'description')
                    ->toArray(),
            ];
        });
    }
}
```

### Background Processing
```php
// Queue heavy activity processing
class ProcessBatchActivitiesJob implements ShouldQueue
{
    public function handle(array $activities): void
    {
        // Process activities in background to avoid blocking requests
        $chunks = array_chunk($activities, 100);

        foreach ($chunks as $chunk) {
            Activity::insert($chunk);
        }
    }
}

// Usage in controllers/listeners
dispatch(new ProcessBatchActivitiesJob($activitiesData));
```

## Performance Impact Assessment

### Current Performance Issues:
- **Activity listing**: 50-100 additional queries per page load
- **Batch processing**: Linear degradation with batch size
- **Search operations**: Full table scans on large datasets
- **Event replay**: Memory exhaustion on large event streams

### Expected Improvements:
- **Activity listing**: 95% reduction in queries (50-100 queries → 2-3 queries)
- **Batch processing**: 90% faster with bulk inserts
- **Search operations**: 80% faster with proper indexing
- **Event replay**: Memory usage reduced from GB to MB scale

### Implementation Priority:
1. **Immediate** (1-2 days): Fix eager loading in ActivityResource
2. **High** (1 week): Implement batch processing optimizations
3. **Medium** (2 weeks): Add database indexes and caching
4. **Long-term** (1 month): Implement table partitioning

## Monitoring and Metrics

### Key Performance Indicators:
- Average query time for activity listing
- Number of queries per activity page load
- Memory usage during batch operations
- Event replay processing time

### Monitoring Setup:
```php
// Add to AppServiceProvider
DB::listen(function ($query) {
    if ($query->time > 1000) { // Queries over 1 second
        Log::warning('Slow query detected', [
            'sql' => $query->sql,
            'bindings' => $query->bindings,
            'time' => $query->time
        ]);
    }
});
```

This optimization plan will significantly improve the Activity module's performance while maintaining all existing functionality.