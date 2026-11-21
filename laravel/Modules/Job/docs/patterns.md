---
type: note
tags: [documentation]
created: 2026-09-26
qmd: "patterns"
issues: []
discussions: []
title: "Job Module Architectural Patterns"
category: "architecture"
owner: "Job"
status: "active"
updated: "2026-07-28"
---

# ⭐ Job Module Architectural Patterns

**Last updated:** 2026-07-28

---

## Overview

This document describes the core architectural patterns used in the Job module for building robust, scalable asynchronous processing systems.

---

## Pattern 1: QueueableAction

**Purpose:** Execute long-running operations asynchronously while keeping the request-response cycle fast.

### Structure

```php
<?php

namespace Modules\Job\Actions;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessLargeExportAction implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public function __construct(
        private int $datasetId,
        private string $format = 'csv'
    ) {}

    public function handle(): void
    {
        // Processing logic here
        $data = collect()->range(0, 10000)->map(fn($i) => $i * 2);
        // Write to storage, send notification, etc.
    }
}
```

### Implementation Checklist

- [ ] Implement `ShouldQueue` interface
- [ ] Use `Dispatchable` trait for `.dispatch()` method
- [ ] Serialize only essential data (IDs, not full models)
- [ ] Use `SerializesModels` for Eloquent models if needed
- [ ] Add timeout configuration in job's `$timeout` property
- [ ] Implement retry logic with `$maxExceptions`, `$tries`
- [ ] Add monitoring/logging for job start/completion

### Best Practices

1. **Serialize IDs, not objects:** Pass only identifiers; reload from database in `handle()`
2. **Set appropriate timeouts:** Long jobs should have explicit `$timeout` values
3. **Handle failures gracefully:** Use `failed()` method for exception handling
4. **Test synchronously first:** Test action logic without queue to isolate bugs

---

## Pattern 2: Retry Strategy

**Purpose:** Implement intelligent retry logic with exponential backoff and failure tracking.

### Basic Retry Configuration

```php
class SendNotificationAction implements ShouldQueue
{
    public $tries = 3;
    public $backoff = [10, 30, 60]; // 10s, 30s, 60s delays

    public function handle(): void
    {
        // Retry logic automatically applied by framework
    }

    public function failed(Throwable $exception): void
    {
        // Log failure, send alert, etc.
        \Log::error("Notification send failed: {$exception->getMessage()}");
    }
}
```

### Advanced Retry with Exponential Backoff

```php
class RetryableJobAction implements ShouldQueue
{
    public $tries = 5;

    public function backoff(): array
    {
        // Exponential backoff: 2, 4, 8, 16, 32 seconds
        return array_map(fn($i) => 2 ** $i, range(1, $this->tries));
    }

    public function retryUntil(): DateTime
    {
        return now()->addHours(4); // Stop retrying after 4 hours
    }
}
```

### Implementation Checklist

- [ ] Define `$tries` for maximum attempt count
- [ ] Set `$backoff` array or implement `backoff()` method
- [ ] Use `retryUntil()` to set absolute timeout
- [ ] Implement `failed()` for cleanup on exhaustion
- [ ] Log retry attempts with context
- [ ] Test retry behavior in test suite
- [ ] Monitor failed job dashboard in Horizon/Filament

### Best Practices

1. **Use exponential backoff:** Prevents overwhelming external services
2. **Set `retryUntil()`:** Prevents jobs stuck in retry loop indefinitely
3. **Idempotent operations:** Retries should be safe to repeat
4. **Graceful degradation:** Catch expected exceptions, let genuine errors bubble up

---

## Pattern 3: Batch Processing

**Purpose:** Process large datasets in chunks, tracking progress and handling partial failures.

### Batch Job Structure

```php
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class ProcessBatchDataAction
{
    public function execute(array $items): void
    {
        $jobs = collect($items)
            ->chunk(100) // Process 100 items per job
            ->map(fn($chunk) => new ProcessChunkAction($chunk->toArray()))
            ->toArray();

        $batch = Bus::batch($jobs)
            ->then(function (Batch $batch) {
                // Success: all jobs completed
                \Log::info("Batch {$batch->id} completed");
            })
            ->catch(function (Batch $batch, Throwable $e) {
                // Failure: at least one job failed
                \Log::error("Batch {$batch->id} failed: {$e->getMessage()}");
            })
            ->finally(function (Batch $batch) {
                // Cleanup: always runs
                \Log::info("Batch {$batch->id} cleanup");
            })
            ->dispatch();

        return $batch->id;
    }
}
```

### Implementation Checklist

- [ ] Split large datasets into chunks (~100-500 items per job)
- [ ] Create individual job classes for chunk processing
- [ ] Use `Bus::batch()` to group jobs
- [ ] Implement `->then()` for success callback
- [ ] Implement `->catch()` for failure handling
- [ ] Implement `->finally()` for cleanup
- [ ] Track batch progress in database
- [ ] Add progress indicator to UI

### Best Practices

1. **Chunk size:** Balance between DB queries and queue load (100-500 items typical)
2. **Progress tracking:** Store batch status in database for UI display
3. **Partial failures:** Use `catch()` to handle some jobs failing; don't fail entire batch
4. **Idempotency:** Chunk jobs must be safe to retry (use `firstOrCreate()` patterns)

---

## Pattern 4: Job Monitoring

**Purpose:** Track job execution status, performance metrics, and provide visibility via Filament UI.

### Monitoring Database Model

```php
namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Model;

class JobMonitor extends Model
{
    protected $fillable = ['job_id', 'class_name', 'status', 'attempts', 'started_at', 'completed_at'];

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
            default => 'Unknown'
        };
    }

    public function getDurationAttribute(): ?int
    {
        if (!$this->started_at || !$this->completed_at) return null;
        return $this->completed_at->diffInSeconds($this->started_at);
    }
}
```

### Filament Resource

```php
namespace Modules\Job\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobMonitorResource extends Resource
{
    protected static ?string $model = JobMonitor::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job_id')->sortable(),
                Tables\Columns\TextColumn::make('class_name')->sortable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('attempts'),
                Tables\Columns\TextColumn::make('duration')->label('Duration (s)'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'completed' => 'Completed', 'failed' => 'Failed']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
```

### Implementation Checklist

- [ ] Create `JobMonitor` model for tracking
- [ ] Log job start: record `job_id`, `class_name`, `started_at`
- [ ] Log job completion: update `status`, `completed_at`
- [ ] Log failures: increment `attempts`, record error message
- [ ] Create Filament Resource for dashboard visibility
- [ ] Add filters for status, date range, class name
- [ ] Implement bulk actions (retry, cancel)
- [ ] Add alerts for failed jobs

### Best Practices

1. **Automatic logging:** Hook into job lifecycle events (started, completed, failed)
2. **Dashboard visibility:** Make job status queryable and filterable
3. **Retention policy:** Archive old job records after 30-90 days
4. **Performance:** Index `status`, `class_name`, `created_at` columns

---

## Pattern 5: Failure Handling

**Purpose:** Implement comprehensive error handling with context, notifications, and recovery options.

### Failure Handler Action

```php
namespace Modules\Job\Actions;

use Exception;
use Illuminate\Queue\Events\JobFailed;

class HandleJobFailureAction
{
    public function handle(JobFailed $event): void
    {
        $job = $event->job;
        $payload = $job->payload();

        // 1. Log with full context
        \Log::error('Job failed', [
            'job_id' => $job->getJobId(),
            'queue' => $job->getQueue(),
            'attempt' => $job->attempts(),
            'exception' => $event->exception->getMessage(),
        ]);

        // 2. Update monitoring status
        JobMonitor::where('job_id', $job->getJobId())
            ->update(['status' => 'failed', 'error_message' => $event->exception->getMessage()]);

        // 3. Send notification if critical
        if ($this->isCritical($payload['displayName'])) {
            Notification::send(User::admins(), new JobFailedNotification($job, $event->exception));
        }

        // 4. Trigger recovery action
        if ($this->isRetryable($event->exception)) {
            $this->scheduleRetry($job);
        }
    }

    private function isRetryable(Exception $exception): bool
    {
        return !$exception instanceof UnretryableException;
    }

    private function scheduleRetry($job): void
    {
        // Implement custom retry logic
    }
}
```

### Implementation Checklist

- [ ] Implement `failed()` method in job class
- [ ] Log full context: job ID, queue, attempts, exception
- [ ] Update job monitoring with error state
- [ ] Send admin notifications for critical failures
- [ ] Implement retry decision logic (retryable vs. permanent failure)
- [ ] Store error messages for investigation
- [ ] Create recovery/manual retry workflows
- [ ] Test failure scenarios in test suite

### Best Practices

1. **Log comprehensively:** Include exception stack trace, input data, system state
2. **Distinguish failure types:** Transient (retry) vs. permanent (alert)
3. **Notify strategically:** Not every failure needs a notification; set severity levels
4. **Provide recovery options:** Allow manual retry from UI with new parameters if needed
5. **Clean up gracefully:** Finalize partial state even on failure (rollback, cleanup)

---

## Anti-Patterns to Avoid

### Anti-Pattern 1: Passing Large Objects to Queued Jobs

**WRONG:**
```php
// DON'T: Serializing entire user object
ProcessUserDataAction::dispatch(Auth::user()); 

// DO: Pass only the ID
ProcessUserDataAction::dispatch(Auth::id());
```

**Why:** Large object serialization wastes queue storage and deserialization is slow. IDs are cheap; reload from database.

---

### Anti-Pattern 2: No Timeout Configuration

**WRONG:**
```php
class LongRunningAction implements ShouldQueue
{
    // No $timeout set — job may timeout unpredictably
}
```

**DO:**
```php
class LongRunningAction implements ShouldQueue
{
    public $timeout = 3600; // 1 hour explicit timeout
}
```

**Why:** Without explicit timeout, jobs depend on queue worker configuration; explicit values prevent surprises.

---

### Anti-Pattern 3: Ignoring Idempotency

**WRONG:**
```php
class SendInvoiceEmailAction implements ShouldQueue
{
    public $tries = 3;

    public function handle(Invoice $invoice): void
    {
        // If retried, sends duplicate emails!
        Mail::send(new InvoiceEmail($invoice));
    }
}
```

**DO:**
```php
public function handle(Invoice $invoice): void
{
    // Only send if not already sent
    if ($invoice->email_sent_at) return;

    Mail::send(new InvoiceEmail($invoice));
    $invoice->update(['email_sent_at' => now()]);
}
```

**Why:** Retries can execute the same side effect multiple times. Use idempotency keys or state flags.

---

## Summary

| Pattern | Use When | Key Benefit |
|---------|----------|------------|
| **QueueableAction** | Any async task | Fast request-response |
| **Retry Strategy** | API calls, external services | Handles transient failures |
| **Batch Processing** | Large datasets (100+ items) | Prevents memory overload |
| **Job Monitoring** | Need operational visibility | Dashboard, debugging, SLA tracking |
| **Failure Handling** | Errors are expected | Robust recovery, alerting |

---

## References

- [Laravel Queues Documentation](https://laravel.com/docs/queues)
- [Queue Best Practices](./best-practices.md)
- [Troubleshooting Guide](./job-module-troubleshooting-guide.md)
- [Job Monitor Filament Resource](./COMPONENTS.md#filament-resources)

---

**Document:** PATTERNS.md  
**Version:** 1.0  
**Status:** Active (2026-07-28)
