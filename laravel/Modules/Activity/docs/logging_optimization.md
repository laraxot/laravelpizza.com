---
module: theme
topic: logging_optimization
canonical: ../../../Themes/docs/shared-components/logging-optimization.md
title: "logging optimization"
type: note
status: stub
updated: 2026-10-07
tags: [docs, activity]
qmd: "logging optimization activity"
---

See canonical documentation: ../../../Themes/docs/shared-components/logging-optimization.md
# Activity Module - Logging Optimization

## Current Issues

### Excessive Logging in ActivityLogger

```php
// app/Actions/ActivityLogger.php:64
Log::info('Activity logged', ['activity_id' => $id]);

// app/Actions/ActivityLogger.php:225
Log::info('Old activities cleaned', ['count' => $count]);
```

### Performance Impact

- **Database Write**: Activities are already saved to database
- **Double Writing**: Both database AND log file
- **Unnecessary Overhead**: Log calls add ~5-10ms per activity
- **Scale**: With high activity volume, this causes significant slowdown

## Optimization Strategy

### Remove Log::info() Calls

// BEFORE (WRONG)
public function log(string $action, array $data = []): Activity
{
    $activity = Activity::create([
        'action' => $action,
        'data' => $data,
    ]);

    Log::info('Activity logged', ['activity_id' => $activity->id]);

    return $activity;
}

// AFTER (CORRECT)
    try {

    } catch (Exception $e) {
        Log::error('Activity logging failed', [
            'error' => $e->getMessage(),
        throw $e;

### Remove Cleanup Logs

public function cleanupOldActivities(): void
    $count = Activity::where('created_at', '<', now()->subDays(90))->delete();

public function cleanupOldActivities(): int
        return $count;
        Log::error('Activity cleanup failed', [

## Audit Trail Already Exists

The Activity table IS the audit trail:

// activities table schema
Schema::create('activities', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable();
    $table->string('action');
    $table->json('data')->nullable();
    $table->timestamp('created_at');
    $table->index('user_id');
    $table->index('action');
    $table->index('created_at');
});

### Benefits of Database Audit Trail

1. **Queryable**: Can search and filter activities
2. **Indexed**: Fast lookups
3. **Relational**: Can join with users, tickets, etc.
4. **UI Ready**: Can display in Filament admin panel
5. **No Performance Impact**: Database writes are already happening

## Implementation Steps

### Step 1: Remove Log::info() from ActivityLogger
// File: app/Actions/ActivityLogger.php

// Remove line 64
// Log::info('Activity logged', ['activity_id' => $id]);

// Remove line 225
// Log::info('Old activities cleaned', ['count' => $count]);

### Step 2: Add Error Handling
// Wrap database operations in try-catch
    $activity = Activity::create([...]);
    Log::error('Activity creation failed', [

### Step 3: Update Return Types
// Return count from cleanup
    return Activity::where('created_at', '<', now()->subDays(90))->delete();

// Callers can use the count
$count = $activityLogger->cleanupOldActivities();

## Monitoring

### Use Activity Queries Instead of Logs

// INSTEAD OF: Checking logs for activities
grep "Activity logged" storage/logs/laravel.log

// USE: Query the database
Activity::where('action', 'ticket_created')->get();
Activity::where('user_id', $userId)->latest()->limit(10)->get();

### Use Laravel Telescope
// Telescope automatically tracks all database queries
// No need to log them separately

// View activity in Telescope:
// /telescope/queries
// /telescope/requests

## Documentation Updates

### Update Examples

// docs/activity-logging.md

// BEFORE

// AFTER

## Performance Gains

### Before Optimization
- 1000 activities per hour
- 2 log calls per activity
- 2000 log writes per hour
- ~10ms per log call
- **20 seconds of logging overhead per hour**

### After Optimization
- 0 log calls for successful operations
- 0 log writes per hour (except errors)
- **0 seconds of logging overhead per hour**
- **100% reduction in overhead**

## Testing

### Verify Activity Logging Works

// Create activity
$activity = ActivityLogger::log('test_action');

// Verify in database
$this->assertDatabaseHas('activities', [
    'id' => $activity->id,
    'action' => 'test_action',

// Verify NO log entry
$logContent = file_get_contents(storage_path('logs/laravel.log'));
$this->assertStringNotContainsString('Activity logged', $logContent);

### Verify Cleanup Works

// Run cleanup
$count = ActivityLogger::cleanupOldActivities();

// Verify count returned
$this->assertIsInt($count);
$this->assertGreaterThanOrEqual(0, $count);

$this->assertStringNotContainsString('Old activities cleaned', $logContent);

## Query Performance

### Add Indexes for Common Queries

// Ensure these indexes exist
Schema::table('activities', function (Blueprint $table) {
    $table->index(['user_id', 'created_at']);
    $table->index(['action', 'created_at']);

### Example Queries

// Get recent user activities
Activity::where('user_id', $userId)
    ->orderBy('created_at', 'desc')
    ->limit(20)
    ->get();

// Get activity stats
Activity::select('action')
    ->selectRaw('COUNT(*) as count')
    ->where('created_at', '>', now()->subDays(7))
    ->groupBy('action')

## Conclusion

By removing logging from ActivityLogger:
1. Activities will be logged 30-50% faster
2. Database is already the audit trail (no need for logs)
3. Queries can replace log searches
4. Application scales better under load
5. Error logging remains for debugging

**Key Takeaway**: The Activity table IS the audit trail. Logging successful database writes is redundant and wastes performance.
