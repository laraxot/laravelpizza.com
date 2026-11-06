---
type: note
tags: [documentation]
created: 2026-09-26
qmd: "TROUBLESHOOTING"
issues: []
discussions: []
title: "Job Module Troubleshooting Guide"
category: "operations"
owner: "Job"
status: "active"
updated: "2026-07-28"
---

# ⚠️ Job Module Troubleshooting Guide

**Last updated:** 2026-07-28

---

## Overview

This guide covers common errors, root causes, solutions, and prevention strategies for the Job module's async processing system.

---

## Error Category 1: Dispatch Failures

**Symptoms:** Job never appears in queue, immediate error when calling `.dispatch()`

### Error Pattern

```
BadMethodCallException: Call to undefined method dispatch()
Queue driver error: Connection refused
Serialization failed: Object could not be serialized
```

### Root Causes

1. Action doesn't implement `ShouldQueue` interface
2. Queue driver misconfigured (Redis/Database not accessible)
3. Object contains non-serializable properties (closures, streams)
4. Job payload exceeds queue driver size limit (~64KB)

### Solution (Step-by-Step)

**Step 1: Verify ShouldQueue Implementation**
```php
// WRONG
class ProcessDataAction
{
    public function handle() { }
}

// CORRECT
class ProcessDataAction implements ShouldQueue
{
    use Dispatchable, SerializesModels;
    public function handle() { }
}
```

**Step 2: Check Queue Driver Configuration**
```bash
# Verify .env
grep QUEUE_CONNECTION .env

# Test Redis connection
redis-cli ping
# Expected: PONG

# Test Database tables exist
php artisan migrate --path="database/migrations/queue"
```

**Step 3: Remove Non-Serializable Properties**
```php
// WRONG: Contains closure (non-serializable)
class ProcessDataAction implements ShouldQueue
{
    public function __construct(
        private int $id,
        private Closure $callback  // ❌ NOT serializable
    ) {}
}

// CORRECT: Pass only serializable data
class ProcessDataAction implements ShouldQueue
{
    public function __construct(
        private int $id,
        private string $callbackKey  // ✅ Reference to callback
    ) {}

    public function handle()
    {
        $callback = $this->getCallback($this->callbackKey);
    }
}
```

**Step 4: Check Payload Size**
```php
// Monitor payload size
$action = new ProcessDataAction(123);
$size = strlen(serialize($action)); // Check bytes

if ($size > 60000) { // Leave 4KB buffer
    // Split into smaller chunks or pass IDs only
    ProcessDataAction::dispatch($id); // Pass ID instead of full object
}
```

### Prevention

- [ ] Always implement `ShouldQueue` on async actions
- [ ] Use dependency injection; pass IDs, not full objects
- [ ] Test job dispatch in test suite: `Queue::fake(); Action::dispatch(...); Queue::assertPushed(...);`
- [ ] Monitor queue driver health (Redis connection, Database table growth)
- [ ] Set up alerts for queue driver errors

### Reference

- [Queue Serialization Issues](./best-practices.md#serialization)
- [Queue Driver Configuration](./configuration.md#queue-drivers)

---

## Error Category 2: Queue Timeouts

**Symptoms:** Job killed mid-execution, "Maximum execution time exceeded", incomplete data processing

### Error Pattern

```
Maximum execution time exceeded
SIGTERM received: worker terminating
Job timeout after 3600 seconds
PHP Fatal error: Maximum execution time of 30 seconds exceeded
```

### Root Causes

1. Job's `$timeout` value too low for actual work
2. Worker's `--timeout` value too low
3. Infinite loop or deadlock in job code
4. Database/API calls hanging without timeout

### Solution (Step-by-Step)

**Step 1: Verify Job Timeout Configuration**
```php
class LongRunningAction implements ShouldQueue
{
    // ❌ DEFAULT: 60 seconds (may be too short)
    // Set explicitly for long operations
    public $timeout = 3600; // ✅ 1 hour
}
```

**Step 2: Check Worker Timeout**
```bash
# Current worker configuration
ps aux | grep "queue:work"

# Example: worker with 1-hour timeout
php artisan queue:work --timeout=3600

# Verify in config
grep -A 5 "queue:" config/queue.php
```

**Step 3: Add Timeout to External Calls**
```php
// WRONG: No timeout on API call
$response = Http::get('https://api.example.com/data');

// CORRECT: Explicit timeout
$response = Http::timeout(30)->get('https://api.example.com/data');

// CORRECT: Database query timeout
$data = DB::timeout(120)->select('SELECT * FROM large_table WHERE ...');
```

**Step 4: Detect Infinite Loops/Deadlocks**
```php
class ProcessDataAction implements ShouldQueue
{
    public $timeout = 300;

    public function handle()
    {
        $maxIterations = 10000;
        $iteration = 0;

        while ($condition) {
            if (++$iteration > $maxIterations) {
                throw new Exception('Possible infinite loop detected');
            }
            // Process data
        }
    }
}
```

**Step 5: Monitor with Dashboard**
```php
// Filament widget to check long-running jobs
JobMonitor::where('status', 'processing')
    ->where('started_at', '<', now()->subHours(1))
    ->each(fn($job) => \Log::warning("Long job: {$job->job_id}"));
```

### Prevention

- [ ] Set explicit `$timeout` for every job based on typical runtime + 50% buffer
- [ ] Test with realistic data volume to measure actual duration
- [ ] Add timeouts to HTTP, database, and file operations
- [ ] Implement progress checkpoints for long jobs
- [ ] Monitor job duration dashboard; alert if jobs exceed expected duration
- [ ] Use `--max-time` flag to restart workers periodically

### Reference

- [Timeout Configuration](./configuration.md#timeouts)
- [Performance Optimization](./performance-optimization.md)

---

## Error Category 3: Retry Exhaustion

**Symptoms:** Job marked failed after all retries, no more attempts, data left in inconsistent state

### Error Pattern

```
Job failed and no longer retrying
Exhausted 3 retry attempts
Maximum retries exceeded
Job marked as dead-lettered
```

### Root Causes

1. External service down (API, database, payment processor)
2. Insufficient permissions/credentials
3. Data validation fails repeatedly (not a transient error)
4. Retry strategy too aggressive or too passive

### Solution (Step-by-Step)

**Step 1: Distinguish Transient vs. Permanent Errors**
```php
class SendPaymentAction implements ShouldQueue
{
    public $tries = 5;

    public function handle(Payment $payment)
    {
        try {
            $this->processPayment($payment);
        } catch (TemporaryNetworkError $e) {
            // Transient: will retry automatically
            throw $e;
        } catch (InvalidPaymentDataException $e) {
            // Permanent: don't retry
            $payment->update(['status' => 'failed', 'error' => $e->getMessage()]);
            return;
        }
    }

    public function failed(Throwable $e)
    {
        // Called when all retries exhausted
        \Log::error("Payment failed permanently: {$e->getMessage()}");
        Notification::send(User::admins(), new PaymentFailedNotification($payment));
    }
}
```

**Step 2: Implement Smart Backoff**
```php
public function backoff(): array
{
    // Progressive backoff: 10s, 30s, 2min, 5min, 15min
    return [10, 30, 120, 300, 900];
}

public function retryUntil(): DateTime
{
    // Stop retrying after 24 hours
    return now()->addHours(24);
}
```

**Step 3: Check External Service Health**
```bash
# Test API connectivity
curl -v https://payment-api.example.com/health

# Check database status
php artisan tinker
> DB::connection()->getPdo()  # Verify connection
> DB::table('users')->count() # Quick query

# Verify credentials
# .env: Check API_KEY, API_SECRET, etc.
```

**Step 4: Enable Manual Retry Option**
```php
// Filament Action on JobMonitor resource
Tables\Actions\Action::make('retry')
    ->requiresConfirmation()
    ->action(function (JobMonitor $record) {
        // Re-dispatch original job with same payload
        $originalClass = $record->class_name;
        $originalClass::dispatch(...$record->original_payload);
        $record->update(['status' => 'retrying', 'attempts' => 0]);
    }),
```

**Step 5: Create Alerting System**
```php
// Monitor failed jobs
class CheckFailedJobsAction
{
    public function handle()
    {
        JobMonitor::where('status', 'failed')
            ->where('created_at', '>', now()->subHours(1))
            ->each(function ($job) {
                Notification::send(
                    User::admins(),
                    new JobPermanentlyFailedNotification($job)
                );
            });
    }
}

// Schedule in kernel.php
$schedule->call(new CheckFailedJobsAction())->everyMinute();
```

### Prevention

- [ ] Classify errors as transient vs. permanent in catch blocks
- [ ] Use `retryUntil()` to prevent indefinite retries
- [ ] Implement circuit breaker pattern for external services
- [ ] Log full error context for each retry attempt
- [ ] Create monitoring dashboard for failed jobs
- [ ] Test failure scenarios in unit/integration tests
- [ ] Document expected failures in code comments

### Reference

- [Retry Strategies](./patterns.md#pattern-2-retry-strategy)
- [Failure Handling](./patterns.md#pattern-5-failure-handling)

---

## Error Category 4: Batch Processing Errors

**Symptoms:** Some jobs in batch succeed, others fail; inconsistent data; partial updates

### Error Pattern

```
Batch failure detected
Job failed but batch continues
Partial batch completion
Orphaned records from failed chunk
```

### Root Causes

1. No transaction boundaries; some writes succeed before error
2. Chunk jobs not idempotent (fail if re-run)
3. Batch failure callback not handling cleanup
4. Inter-chunk dependencies broken on partial failure

### Solution (Step-by-Step)

**Step 1: Wrap Chunk Processing in Transaction**
```php
class ProcessChunkAction implements ShouldQueue
{
    public function handle(array $chunk)
    {
        DB::transaction(function () use ($chunk) {
            foreach ($chunk as $item) {
                Item::findOrFail($item['id'])->update(['processed' => true]);
            }
        });
    }
}
```

**Step 2: Make Chunk Jobs Idempotent**
```php
// WRONG: Re-running creates duplicate entries
public function handle(array $chunk)
{
    foreach ($chunk as $data) {
        DB::table('results')->insert($data); // Duplicate on retry!
    }
}

// CORRECT: Use firstOrCreate pattern
public function handle(array $chunk)
{
    foreach ($chunk as $data) {
        Result::firstOrCreate(
            ['source_id' => $data['id']],
            $data
        );
    }
}
```

**Step 3: Implement Batch Failure Handling**
```php
$batch = Bus::batch($jobs)
    ->then(function (Batch $batch) {
        // Success
        BatchMonitor::create(['id' => $batch->id, 'status' => 'completed']);
    })
    ->catch(function (Batch $batch, Throwable $e) {
        // At least one job failed
        BatchMonitor::create(['id' => $batch->id, 'status' => 'failed', 'error' => $e->getMessage()]);

        // Optionally: retry failed jobs only
        $batch->failedJobs->each(fn($job) => $originalJobClass::dispatch(...$job->payload));
    })
    ->finally(function (Batch $batch) {
        // Always runs: cleanup, notifications
        Notification::send(User::admins(), new BatchCompletionNotification($batch));
    })
    ->dispatch();
```

**Step 4: Track Progress Independently**
```php
// In each chunk job
class ProcessChunkAction implements ShouldQueue
{
    public function handle(array $chunk)
    {
        DB::table('batch_progress')->updateOrCreate(
            ['batch_id' => $this->batchId, 'chunk_index' => $this->chunkIndex],
            ['status' => 'processing', 'started_at' => now()]
        );

        try {
            // Process chunk
            DB::table('batch_progress')->where('chunk_index', $this->chunkIndex)
                ->update(['status' => 'completed', 'completed_at' => now()]);
        } catch (Exception $e) {
            DB::table('batch_progress')->where('chunk_index', $this->chunkIndex)
                ->update(['status' => 'failed', 'error' => $e->getMessage()]);
            throw $e;
        }
    }
}
```

### Prevention

- [ ] Wrap all database operations in transactions
- [ ] Test chunk jobs with same data twice (idempotency test)
- [ ] Implement progress tracking independent of job completion
- [ ] Use `->catch()` and `->finally()` callbacks comprehensively
- [ ] Monitor batch progress dashboard in real-time
- [ ] Test batch failure scenarios (kill one job, verify recovery)

### Reference

- [Batch Processing Pattern](./patterns.md#pattern-3-batch-processing)
- [Database Transactions](./best-practices.md#transactions)

---

## Error Category 5: Memory Issues

**Symptoms:** Worker runs out of memory, jobs killed, "Allowed memory size exhausted"

### Error Pattern

```
PHP Fatal error: Allowed memory size of 134217728 bytes exhausted
Out of memory: Kill process
Memory leak detected in long-running process
```

### Root Causes

1. Loading too many records into memory at once
2. Unbounded loops accumulating data
3. Memory leak in third-party library
4. Worker not recycling between jobs (memory not released)

### Solution (Step-by-Step)

**Step 1: Process Data in Chunks, Not All at Once**
```php
// WRONG: Loads all records into memory
$users = User::all(); // ❌ Could be millions!
foreach ($users as $user) {
    // Process
}

// CORRECT: Chunk to limit memory usage
User::chunk(1000, function ($users) {
    foreach ($users as $user) {
        // Process
    }
});

// CORRECT: Use lazy cursor for even lower memory
User::lazy()->each(function ($user) {
    // Process one at a time
});
```

**Step 2: Unset/Clear Large Collections**
```php
class ProcessLargeDatasetAction implements ShouldQueue
{
    public function handle()
    {
        $dataset = $this->fetchData(); // 100MB dataset
        $results = [];

        foreach ($dataset as $item) {
            $results[] = $this->process($item);

            // Prevent memory accumulation
            if (count($results) > 10000) {
                $this->persistResults($results);
                $results = [];
            }
        }

        unset($dataset); // Explicitly free memory
        $this->persistResults($results);
    }
}
```

**Step 3: Configure Worker Memory Limit**
```bash
# Run worker with higher memory limit
php -d memory_limit=512M artisan queue:work

# Or in queue worker configuration
php artisan queue:work \
    --memory=512 \
    --timeout=3600 \
    --max-jobs=100 \
    --max-time=3600
```

**Step 4: Monitor Memory Usage**
```php
// Add to job for visibility
class ProcessDataAction implements ShouldQueue
{
    public function handle()
    {
        $initialMemory = memory_get_usage(true);
        \Log::info("Job started: " . ($initialMemory / 1024 / 1024) . "MB");

        // Process...

        $finalMemory = memory_get_usage(true);
        \Log::info("Job ended: " . ($finalMemory / 1024 / 1024) . "MB");
    }
}
```

**Step 5: Set Worker Recycling Options**
```bash
# Restart worker after processing 100 jobs (prevent memory creep)
php artisan queue:work --max-jobs=100

# Restart worker after 1 hour of running
php artisan queue:work --max-time=3600
```

### Prevention

- [ ] Always use `chunk()` or `lazy()` for large collections
- [ ] Test with realistic data volume (10K+, 100K+ records)
- [ ] Monitor worker memory usage in dashboard
- [ ] Set `--max-jobs` and `--max-time` flags to restart workers periodically
- [ ] Use profiling tools (Xdebug, Blackfire) to detect memory leaks
- [ ] Document expected memory consumption for each job

### Reference

- [Memory Management](./best-practices.md#memory-management)
- [Performance Optimization](./performance-optimization.md)

---

## Error Category 6: Missed/Lost Jobs

**Symptoms:** Job dispatch called but never executed, orphaned jobs, silent failures

### Error Pattern

```
Job never appears in queue
No error, job just disappears
Worker crashed but recovery not automated
Dead-letter queue filling up
```

### Root Causes

1. Queue driver misconfigured (Redis key expiration, DB cleanup)
2. Worker crashed without error handling
3. Job payload corruption
4. Queue pruning deleting unprocessed jobs

### Solution (Step-by-Step)

**Step 1: Verify Queue Driver Health**
```bash
# Redis: check for key expiration
redis-cli MONITOR | grep "job" # Watch in real-time

# Database: verify jobs table exists and grows
php artisan tinker
> DB::table('jobs')->count()
> DB::table('failed_jobs')->count()

# Check for Redis TTL issues
> redis-cli TTL "queues:default"  # Should be -1 (no expiration)
```

**Step 2: Implement Dispatch Acknowledgment**
```php
// Log dispatch with tracking ID
class ProcessDataAction implements ShouldQueue
{
    public function __construct(private string $trackingId) {}

    public function handle()
    {
        // Log start with tracking ID for audit trail
        \Log::info("Job started", ['tracking_id' => $this->trackingId]);
    }
}

// On dispatch:
$trackingId = (string) Str::uuid();
ProcessDataAction::dispatch($trackingId);

// Store dispatch record
JobDispatch::create([
    'tracking_id' => $trackingId,
    'job_class' => 'ProcessDataAction',
    'dispatched_at' => now(),
]);
```

**Step 3: Monitor Queue Depth**
```php
// Alert if queue grows too large
$queueDepth = DB::table('jobs')->count();

if ($queueDepth > 10000) {
    Notification::send(User::admins(), new QueueBacklogAlert($queueDepth));
}
```

**Step 4: Implement Dead-Letter Handling**
```php
// Catch jobs stuck in failed state
class MonitorFailedJobsAction
{
    public function handle()
    {
        $oldFailed = DB::table('failed_jobs')
            ->where('failed_at', '<', now()->subDays(7))
            ->get();

        foreach ($oldFailed as $job) {
            // Archive to permanent storage for audit
            FailedJobArchive::create([
                'job_payload' => $job->payload,
                'exception' => $job->exception,
            ]);

            // Delete from queue
            DB::table('failed_jobs')->where('id', $job->id)->delete();
        }
    }
}

// Schedule: $schedule->call(new MonitorFailedJobsAction())->daily();
```

**Step 5: Ensure Worker Resilience**
```bash
# Use supervisor to auto-restart crashed workers
# /etc/supervisor/conf.d/laravel-worker.conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/laravel-worker.log
```

### Prevention

- [ ] Store dispatch events in database for audit trail
- [ ] Monitor queue depth with alerts for backlog
- [ ] Implement dead-letter handling to prevent permanent loss
- [ ] Use supervisor or systemd to auto-restart workers
- [ ] Test worker crash scenarios with graceful recovery
- [ ] Archive failed jobs for later investigation
- [ ] Set up alerting for queue driver errors

### Reference

- [Queue Driver Configuration](./configuration.md)
- [Job Monitoring](./patterns.md#pattern-4-job-monitoring)
- [Failure Handling](./patterns.md#pattern-5-failure-handling)

---

## Summary Table

| Error Category | Common Cause | Quick Fix |
|---|---|---|
| **Dispatch Failures** | Missing `ShouldQueue` or serialization | Implement interface, pass IDs |
| **Timeouts** | Too-low `$timeout` value | Increase timeout or optimize code |
| **Retry Exhaustion** | External service down | Check service health, distinguish transient vs. permanent |
| **Batch Errors** | No transaction wrapping | Wrap in `DB::transaction()` |
| **Memory Issues** | Loading all data at once | Use `chunk()` or `lazy()` |
| **Missed Jobs** | Queue driver misconfiguration | Monitor queue depth, implement dispatch tracking |

---

## Emergency Checklist

When a critical job failure occurs:

- [ ] Check worker is running: `ps aux | grep queue:work`
- [ ] Verify queue driver health (Redis/DB connectivity)
- [ ] Review failed_jobs table: `php artisan queue:failed`
- [ ] Check worker logs: `tail -f /var/log/laravel-worker.log`
- [ ] Verify job timeout: `$timeout` in job class + worker `--timeout` flag
- [ ] Review recent deployments for code changes
- [ ] Test job dispatch: `php artisan tinker; Action::dispatch(...)`
- [ ] Notify stakeholders of impact
- [ ] Restore queue if corrupted: `php artisan queue:restart`

---

## References

- [Laravel Queue Documentation](https://laravel.com/docs/queues)
- [Patterns & Best Practices](./patterns.md)
- [Configuration Guide](./configuration.md)
- [Performance Optimization](./performance-optimization.md)

---

**Document:** job-module-troubleshooting-guide.md  
**Version:** 1.0  
**Status:** Active (2026-07-28)
