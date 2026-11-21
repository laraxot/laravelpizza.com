---
title: Job Module Philosophy
category: foundation
owner: Job
status: active
updated: 2026-09-06
---

# Job Module Philosophy

**Last updated:** 2026-09-06

---

## RELIGIONE

Why does the Job module have 19 model files (Task, Schedule, Job, JobBatch, Frequency, Parameter, Result, ScheduleHistory, FailedJob, Import, Export, FailedImportRow, TaskComment, JobManager, JobsWaiting, and others)?

### The Religion: Async Task Processing is Sacred

The Job module exists for one sacred reason: **keep the user interface fast by moving heavy work outside the request-response cycle.**

A user clicks "export 100,000 geocoded locations" or "send notifications to 50,000 residents". The request must return immediately. The work happens later, in background processes. The UI shows progress. Failures are tracked. Retries are automatic. Everything is observable.

### Model Rationale

The models exist in layers:

**Domain Layer (Task, Schedule, Frequency, Parameter, TaskComment):**
- Task: The abstract unit of work ("send emails", "generate PDF", "process geocoding")
- Schedule: When and how often Task runs (cron expression)
- Frequency: Temporal patterns (every Monday, every 5 minutes, monthly on 15th)
- Parameter: Arguments passed to tasks
- TaskComment: Collaboration on task configuration

**Execution Layer (Job, JobBatch, FailedJob, JobsWaiting):**
- Job: Single queued job (Laravel queue native)
- JobBatch: Atomic group of related jobs with progress tracking
- FailedJob: Dead letter queue—jobs that exhausted retries
- JobsWaiting: Advisory queue state for monitoring

**History & Results Layer (Result, ScheduleHistory, ScheduleHistory):**
- Result: Outcome of each Task execution (success, failure, duration)
- ScheduleHistory: Audit trail of Schedule executions
- ScheduleHistory: Step-by-step execution log

**Data Movement Layer (Import, Export, FailedImportRow):**
- Import: Bulk data ingestion with progress tracking
- Export: Filament-native export queue handling
- FailedImportRow: Rows that failed parsing (error recovery)

**Orchestration (JobManager):**
- JobManager: Manages cross-job dependencies, sequencing, and lifecycle

This is not bloat. This is **precision modeling** of async concerns.

---

## FILOSOFIA

### The Architecture: Layered Async Dispatch

```
┌─────────────────────────────────────────────────────┐
│  User Request (HTTP, Form, Admin Action)            │
└────────────────┬────────────────────────────────────┘
                 │
        Dispatch (synchronous decision)
                 │
                 ▼
        ┌─────────────────────┐
        │  Task (domain)      │  ← What to do?
        │  Schedule (timing)  │  ← When to do it?
        │  Frequency (pattern)│  ← How often?
        └────────┬────────────┘
                 │
         Enqueue (write to queue)
                 │
                 ▼
    ┌──────────────────────────┐
    │ Queue Storage            │
    │ - Database (default)     │
    │ - Redis (production)     │
    │ - SQS (enterprise)       │
    └────────┬─────────────────┘
             │
    Queue Worker (dequeue, execute)
             │
             ▼
    ┌──────────────────────────┐
    │ JobBatch Coordinator     │  ← Multiple related jobs?
    │ or Single Job            │
    └────────┬─────────────────┘
             │
             ▼
    ┌──────────────────────────┐
    │ Execute Action           │
    │ (process, notify, upload)│
    └────────┬─────────────────┘
             │
    ┌────────┴────────┐
    │ Success         │
    ├─────────────────┤
    │ Failure/Retry   │
    │ Exhausted (DLQ) │
    └─────────────────┘
             │
             ▼
    ┌──────────────────────────┐
    │ Result Record            │  ← History for audit
    │ + Notification           │  ← Slack/Email/Webhook
    └──────────────────────────┘
```

### Relationships (Simplified)

```
Task (schedulable unit of work)
  ├─ belongs to Schedule (cron timing)
  ├─ has many Frequencies (temporal patterns)
  ├─ has many Results (execution history)
  └─ has many Parameters (arguments)

Schedule (cron-based timing)
  ├─ has many ScheduleHistories (execution logs)
  └─ executes as background Job

Job/JobBatch (queued work unit)
  ├─ belongs to Task (domain context)
  ├─ may batch with other Jobs
  └─ on failure, becomes FailedJob

Result (execution outcome)
  ├─ belongs to Task
  ├─ stores duration, status, output
  └─ auto-cleanup policy (retain last N)

Import/Export (data movement)
  ├─ tracks rows processed
  ├─ stores failed rows separately
  └─ marks completion
```

---

## POLITICA

### Job Lifecycle: From Dispatch to Resolution

```
1. DISPATCH (User initiates)
   └─ Action::dispatch(params)
   └─ Stored as Job (queued)

2. RESERVED (Worker claims)
   └─ reserved_at timestamp set
   └─ Job locked to worker

3. EXECUTING (Work in progress)
   └─ handle() method runs
   └─ May retry internally
   └─ May dispatch sub-jobs (batch)

4. SUCCESS
   └─ Job removed from queue
   └─ Result record created
   └─ Notifications sent (on_success flag)
   └─ Auto-cleanup policy may delete old Results

5. FAILURE (Transient)
   └─ Exception caught
   └─ Retry logic applies (backoff: exponential)
   └─ Job re-queued with incremented attempts

6. DEAD LETTER (Permanent failure)
   └─ attempts >= $tries
   └─ Moves to failed_jobs table
   └─ Admin notified
   └─ Manual intervention available

7. ABANDONED (Timeout)
   └─ Duration > $timeout
   └─ Moved to failed_jobs
   └─ Treated as permanent failure
```

### Retry Strategy

```php
// Conservative: critical operations
public $tries = 3;
public $backoff = [10, 60, 300]; // 10s, 60s, 5m

// Aggressive: transient network calls
public $tries = 5;
public function backoff(): array {
    return [2, 4, 8, 16, 32]; // Exponential
}

// Custom: deadline-aware
public function retryUntil(): DateTime {
    return now()->addHours(2); // Give up after 2 hours
}
```

### Failure Handling Politics

1. **Distinguish failure types:**
   - Transient (network timeout, rate limit) → Retry
   - Permanent (validation error, missing resource) → Dead letter
   - Unrecoverable (code bug, memory exhausted) → Alert ops

2. **Notifications:**
   - First attempt: silent
   - Exhausted retries: alert admin
   - Critical jobs: real-time (Slack, SMS)

3. **Recovery:**
   - Manual retry from Filament dashboard
   - Bulk retry of failed batch
   - Dead letter inspection tool

---

## SCOPO

### Purpose in FixCity

The Job module enables FixCity to scale beyond single-threaded HTTP requests.

**Use cases:**

1. **Geocoding at scale** (250+ address standardization)
   - Dispatch batch of addresses
   - Third-party API calls (async, rate-limited)
   - Result callback updates locations
   - UI shows progress in real-time

2. **Notifications** (100K+ resident alerts)
   - Dispatch per-user notification job
   - Group into batches (prevent queue saturation)
   - Retry on delivery failure
   - Track delivery metrics

3. **Reporting** (aggregate 1M+ records)
   - Chunk-based processing (1000 records per job)
   - Parallel execution across multiple workers
   - Progress tracked in database
   - Download link sent on completion

4. **Data import** (CSV with validation)
   - Validate rows asynchronously
   - Track successful vs. failed rows
   - Allow retry of failed subset
   - Audit trail in database

5. **Scheduled maintenance** (nightly cleanup)
   - Delete old logs
   - Archive cold data
   - Recalculate metrics
   - Runs off-hours via cron

---

## ZEN

### The Core Essence

- **Dispatch synchronously, execute asynchronously.** User gets response immediately.
- **Batch for scale.** Process 10K items in 10 jobs, not 10K jobs.
- **Retry with intelligence.** Exponential backoff, deadline awareness.
- **Idempotency is non-negotiable.** Every job must be safe to retry.
- **Observe everything.** Results, history, metrics. No silent failures.
- **Fail fast in app code, retry smart in jobs.** Validation early, retries late.

---

## LIBRERIE DA INSTALLARE

### Queue Backend (Choose One)

**Development (Default):**
```bash
# Database driver — no external service
php artisan queue:table
php artisan migrate
# Jobs stored in jobs table
```

**Production (Redis):**
```bash
# High throughput, atomic operations, pub/sub
composer require predis/predis
# Config: QUEUE_CONNECTION=redis
# Requires Redis 5.0+
```

**Async (No Worker):**
```bash
# For testing or simple apps
# Set QUEUE_CONNECTION=sync
# Jobs execute immediately (no background)
```

### Monitoring (Optional)

**Laravel Horizon** (Dashboard for queues):
```bash
composer require laravel/horizon
php artisan horizon:install
# Web UI at /horizon
# Real-time job monitoring, metrics, alerts
```

**Laravel Pulse** (Application metrics):
```bash
composer require laravel/pulse
php artisan pulse:install
# Low-overhead observability
# Includes queue slowdown detection
```

**Custom Filament Integration** (This module):
```bash
# Built-in: Filament resources for Job, Task, Result
# No extra install needed — configure in Job module
```

### Supporting Services

- **Spatie Activity Log** — Audit trail for Task changes
- **Filament Notifications** — Real-time alerts in admin
- **Laravel Sanctum** — Rate limiting on API endpoints
- **Laravel Pulse** (optional) — Queue depth metrics

---

## FUTURE IMPLEMENTAZIONI

### Near-term (Q4 2026)

1. **WebSocket Progress Updates**
   - Replace polling with Soketi/Pusher
   - Real-time batch progress bar
   - See `/docs/wiki/how-to/Job-websocket-soketi.md`

2. **Webhook Callbacks**
   - Job completion triggers external POST
   - third-party integrations (Zapier, IFTTT)
   - Stored in job_webhooks table

3. **Dead Letter Analysis**
   - Dashboard showing failure patterns
   - Suggest fixes (missing config, quota exceeded)
   - Auto-escalate critical failures

4. **Job Dependencies**
   - Task A must finish before Task B starts
   - DAG (directed acyclic graph) support
   - `dependsOn()` method

### Medium-term (2027)

1. **Distributed Workers**
   - Kubernetes pod coordination
   - Sticky sessions for stateful jobs
   - Worker health checks via K8s probes

2. **Cost Optimization**
   - Auto-scaling workers based on queue depth
   - AWS SQS integration
   - Spot instance support

3. **Advanced Scheduling**
   - Timezone-aware cron (user's timezone, not server)
   - Holiday/blackout dates
   - Business hours only (M-F 9-5)

### Long-term (2028+)

1. **ML-powered Retry Strategy**
   - Learn optimal backoff per job type
   - Predict failure likelihood
   - Suggest resource increases

2. **Cost Attribution**
   - Track CPU/memory per job
   - Charge back departments
   - Show ROI of optimization

---

## COMPETITORS & INSPIRATIONS

### Laravel Ecosystem

| Feature | Job Module | Laravel Horizon | Laravel Pulse | Laravel Queue |
|---------|-----------|-----------------|---------------|---------------|
| Queue management | Yes | Yes | No | Foundation |
| Task scheduling | Yes (cron) | No | No | Basic |
| Monitoring UI | Filament | Web | Minimal | CLI only |
| Batch support | Yes | Yes | No | Yes |
| Database backend | Yes | Yes | Yes | Yes |
| Redis backend | Yes | Yes | No | Yes |
| Failure handling | Rich | Basic | No | Basic |
| Historical audit | Yes | Limited | No | No |
| Cost tracking | No | No | No | No |

**Inspiration from Horizon:** Batch progress tracking, failure insights, real-time metrics.

**Better than Pulse:** Pulse is observability; this module is orchestration. We complement.

### External World

- **Bull.js** (Node.js job queue) — Rate limiting, prioritized queues
- **Celery** (Python) — Chains, chords, workflows
- **Apache Kafka** — Event streaming (different use case)
- **AWS SQS/Lambda** — Serverless execution

**Philosophy difference:** We focus on *reliability* and *observability* over raw throughput. Celery-style workflows planned.

---

## BEST PRACTICES

### 1. Serialize Light, Reload Heavy

```php
// WRONG: Serialize entire model
ProcessAction::dispatch(Auth::user());

// RIGHT: Serialize ID, reload in handle()
ProcessAction::dispatch(Auth::id());
// In handle(): $user = User::find($this->userId);
```

**Why:** Serialized data bloats queue storage. IDs are cheap; database reload is fast.

---

### 2. Set Explicit Timeouts

```php
class GeocodeAction implements ShouldQueue {
    public $timeout = 300; // 5 minutes for geocoding
    // External API: expect slowdown under load
}
```

**Why:** Without explicit timeout, default (60s) may be exceeded unpredictably.

---

### 3. Make Every Job Idempotent

```php
// WRONG: Sends duplicate email on retry
public function handle(Invoice $invoice) {
    Mail::send(new InvoiceEmail($invoice));
}

// RIGHT: Only send if not already sent
public function handle(Invoice $invoice) {
    if ($invoice->email_sent_at) return;
    Mail::send(new InvoiceEmail($invoice));
    $invoice->update(['email_sent_at' => now()]);
}
```

**Why:** Retries re-execute the entire job. Idempotency prevents duplicate side effects.

---

### 4. Batch Large Datasets

```php
// WRONG: 1000 individual jobs
foreach ($locations as $location) {
    ProcessLocation::dispatch($location->id);
}

// RIGHT: Batch into chunks
Bus::batch(
    collect($locations)
        ->chunk(100)
        ->map(fn($chunk) => new ProcessChunkAction($chunk->pluck('id')->toArray()))
        ->toArray()
)->dispatch();
```

**Why:** 1000 jobs = 1000 queue operations + deserialization overhead. 10 batch jobs = 10x faster.

---

### 5. Use Exponential Backoff

```php
public function backoff(): array {
    // 2s, 4s, 8s, 16s, 32s — reduces API strain
    return array_map(fn($i) => 2 ** $i, range(1, $this->tries));
}
```

**Why:** Prevents hammering external APIs during outages. Self-heals faster.

---

### 6. Log with Context

```php
public function failed(Throwable $exception): void {
    Log::error('Job failed', [
        'job_id' => $this->job->uuid(),
        'queue' => $this->job->getQueue(),
        'attempt' => $this->job->attempts(),
        'payload' => $this->payload, // Helps debug
        'exception' => $exception->getMessage(),
    ]);
}
```

**Why:** Empty error logs are useless. Context is everything.

---

### 7. Separate Concerns

```php
// WRONG: Validation + Processing in one job
public function handle() {
    validate($data); // Might fail
    process($data);  // Might fail
}

// RIGHT: Validate in request, process in job
// In controller:
if ($validator->fails()) return error();
ProcessAction::dispatch($data->id); // Data already validated
```

**Why:** Validation failures are permanent (code issue). Processing failures are transient (rate limit). Different retry logic.

---

### 8. Monitor Progress

```php
// In controller:
$batch = Bus::batch([...])->dispatch();
// Return batch ID to frontend

// In frontend (polling or WebSocket):
GET /api/batches/{id}
// Returns: { total: 1000, pending: 300, failed: 5, progress: 70 }
```

**Why:** Users want visibility. Progress bars beat silent waiting.

---

## BAD PRACTICES

### 1. Fire and Forget Without Monitoring

```php
// WRONG: No way to know if it completed
ProcessAction::dispatch($id);
return response()->json(['ok' => true]);
```

**Why:** If the job fails, the user never knows. Data might be stale. User frustration.

---

### 2. No Timeout Configuration

```php
// WRONG: Uses default (60s), external API takes 90s
public function handle() {
    $response = Http::get('https://slow-api.example.com/data');
}
```

**Why:** Timeout exceptions are silent failures. User thinks it worked.

---

### 3. Retry Forever

```php
// WRONG: Infinite retry loop
public $tries = -1; // Or missing $tries

// WRONG: Retry until heat death of universe
public function retryUntil() {
    return now()->addYears(100);
}
```

**Why:** Failed jobs poison queue. Memory leaks. Queue never drains.

---

### 4. Ignore Idempotency

```php
// WRONG: Can decrement balance multiple times
public function handle(Account $account) {
    $account->decrement('balance', 100);
    // If retried: balance decremented again!
}
```

**Why:** Corrupts data. Financial disaster.

---

### 5. Serialize Everything

```php
// WRONG: Serialize 10MB model with relationships
public function __construct(public Post $post) {
    // $post includes: user, comments, likes, attachments...
}
```

**Why:** Bloats queue table. Slow deserialization. Memory spikes on workers.

---

### 6. No Error Handling

```php
// WRONG: Unhandled exception crashes job
public function handle() {
    $api->call(); // May throw
    $this->process(); // May throw
}
```

**Why:** No `failed()` method to cleanup. Orphaned data. Cascading failures.

---

### 7. Block on External Services

```php
// WRONG: Waits synchronously
public function handle() {
    $result = Http::timeout(30)->get($url); // 30s blocking
    $this->process($result);
}
```

**Why:** Ties up queue worker. Other jobs starved. Bottleneck.

---

### 8. Assume Execution Order

```php
// WRONG: Job B depends on Job A
ProcessJobA::dispatch();
ProcessJobB::dispatch(); // May run before A!
```

**Why:** Queue order is not guaranteed. Use explicit dependencies or chains.

---

## FALSE FRIENDS

### 1. Job Timing Is Not Guaranteed

```php
ProcessAction::dispatch()->delay(minutes: 5);
// Executed "approximately" after 5 minutes
// Could be 5m01s or 5m30s depending on queue load
```

**Risk:** Don't use for "send email exactly at 3pm". Use Schedule model instead.

---

### 2. Idempotency Key Must Be Unique

```php
// WRONG: Same key for different data
$key = 'send_notification';
$this->idempotent($key, fn() => ..);

// RIGHT: Include relevant context
$key = "send_notification_{$user->id}_{$event->id}";
```

**Risk:** Accidentally deduplicate different work.

---

### 3. Memory Leaks in Loop

```php
// WRONG: Loop processes 100K items
foreach ($items as $item) {
    $model = Model::find($item->id);
    $model->process(); // Accumulates in memory
    // Never unloaded
}

// RIGHT: Chunk and clear
$items->chunk(100)->each(function($chunk) {
    foreach ($chunk as $item) {
        $model = Model::find($item->id);
        $model->process();
    }
    Model::whereNull('processed_at')->update(['processed_at' => now()]);
});
```

**Risk:** Worker crashes with OutOfMemory. Orphaned processing.

---

### 4. Assumption: Job Runs Once

```php
// WRONG: No idempotent check
$user->increment('notification_count');

// Runs twice due to retry: count = 2 (wrong!)
```

**Risk:** Metrics, reporting, financial transactions corrupted.

---

### 5. Exception Type Matters for Retry

```php
// WRONG: All exceptions retry
try {
    $this->process();
} catch (Throwable $e) {
    throw $e; // Retry even validation errors
}

// RIGHT: Distinguish
try {
    $this->process();
} catch (ValidationException) {
    // Log and fail permanently
    Log::warning('Invalid data: ' . $e->getMessage());
    return;
} catch (TimeoutException) {
    // Let it retry
    throw $e;
}
```

**Risk:** Retry permanent failures forever. Waste resources.

---

### 6. Backoff Isn't Magic

```php
// WRONG: Assumes exponential backoff solves everything
public $backoff = [10, 60, 300]; // 10s, 60s, 5m
// But API is down for 30 minutes

// RIGHT: Add retryUntil() deadline
public function retryUntil(): DateTime {
    return now()->addHours(1); // Stop trying after 1 hour
}
```

**Risk:** Hammer failing service for hours. Increase severity of outage.

---

### 7. Job Batch != Database Transaction

```php
// WRONG: Assumes atomic all-or-nothing
Bus::batch([job1, job2, job3])->dispatch();
// Job 1 succeeds, Job 2 fails, Job 3 succeeds
// Partial state: not transactional!
```

**Risk:** Inconsistent data. Use `->catch()` to handle failures.

---

### 8. Monitor ≠ Fix

```php
// WRONG: Dashboard shows 1000 failed jobs; does nothing
// Assumes someone notices and manually retries

// RIGHT: Automated recovery or escalation
if (Job::where('status', 'failed')->count() > 100) {
    Notification::send(admins(), new JobQueueAlert());
}
```

**Risk:** Silent accumulation. System degrades invisibly.

---

## COME USARLO

### Dispatching Jobs

**Simple:**
```php
ProcessAction::dispatch($id);
// Queued immediately, executed ASAP by worker
```

**With Delay:**
```php
ProcessAction::dispatch($id)->delay(minutes: 5);
// Executed ~5 minutes from now
```

**On Specific Queue:**
```php
ProcessAction::dispatch($id)->onQueue('critical');
// Processes by 'critical' queue workers (higher priority)
```

**With Batch:**
```php
use Illuminate\Bus\Batch;

$batch = Bus::batch([
    new ProcessAction(1),
    new ProcessAction(2),
    new ProcessAction(3),
])->then(function(Batch $batch) {
    Log::info("Batch {$batch->id} completed");
})->catch(function(Batch $batch, Throwable $e) {
    Log::error("Batch {$batch->id} failed: {$e->getMessage()}");
})->finally(function(Batch $batch) {
    Log::info("Batch {$batch->id} cleanup");
})->dispatch();

// Return $batch->id to track progress
```

### Monitoring

**Filament Admin:**
- Navigate to `/admin/jobs/jobs`
- Filter by status (waiting, running, failed)
- View job details, exception traces
- Manual retry of failed jobs

**CLI:**
```bash
# Start worker
php artisan queue:work

# Monitor live
php artisan queue:monitor redis:default --max=1000

# Inspect failed jobs
php artisan queue:failed
php artisan queue:retry

# Flush queue
php artisan queue:flush
```

**Programmatically:**
```php
// Check job status
$job = Job::where('id', $jobId)->first();
echo $job->status; // 'waiting' or 'running'
echo $job->attempts;

// Get results
$results = Result::where('task_id', $taskId)
    ->orderBy('ran_at', 'desc')
    ->limit(10)
    ->get();

// Batch progress
$batch = JobBatch::find($batchId);
echo $batch->progress(); // 0-100
echo $batch->hasPendingJobs(); // bool
```

---

## COME INSTALLARLO

### 1. Publish Migrations

```bash
php artisan vendor:publish --tag=job-migrations
php artisan migrate
```

Creates tables: jobs, job_batches, failed_jobs, tasks, results, schedules, schedule_histories, etc.

### 2. Set Queue Connection

**Development (Database):**
```env
QUEUE_CONNECTION=database
```

**Production (Redis):**
```env
QUEUE_CONNECTION=redis
REDIS_HOST=localhost
REDIS_PORT=6379
REDIS_DB=1 # Use separate DB for queues
```

### 3. Register Service Provider

Usually automatic via module discovery, but verify in `config/app.php`:
```php
'providers' => [
    // ...
    Modules\Job\Providers\JobServiceProvider::class,
],
```

### 4. Start Queue Worker

```bash
php artisan queue:work --sleep=3 --tries=3
```

Options:
- `--sleep=3` — Check queue every 3 seconds (prevent CPU spinning)
- `--tries=3` — Max 3 attempts before moving to failed_jobs
- `--timeout=120` — Kill job if exceeds 120s
- `--max-jobs=1000` — Restart worker after 1000 jobs (memory leak prevention)
- `--max-time=3600` — Restart worker after 1 hour (memory leak prevention)

### 5. (Optional) Redis Setup

```bash
# macOS
brew install redis
brew services start redis

# Linux
sudo apt-get install redis-server
systemctl start redis-server

# Docker
docker run -d -p 6379:6379 redis:7-alpine
```

### 6. (Optional) Horizon Setup

```bash
composer require laravel/horizon
php artisan horizon:install
php artisan migrate # Creates horizon_* tables
```

Start Horizon:
```bash
php artisan horizon
# Web UI at http://localhost/horizon
```

### 7. (Optional) Pulse Setup

```bash
composer require laravel/pulse
php artisan pulse:install
```

### 8. Configure Schedule (Cron)

For scheduled tasks (via Schedule model), add to `routes/console.php`:
```php
use Modules\Job\Models\Schedule;

$this->call('schedule:work'); // Or: Kernel->schedule()
```

In crontab:
```bash
* * * * * cd /app && php artisan schedule:run >> /dev/null 2>&1
```

### 9. Verify Installation

```bash
# Check database tables
php artisan tinker
>>> DB::table('jobs')->count();
>>> DB::table('tasks')->count();

# Check module is loaded
>>> Module::find('Job')
```

---

## COVERAGE ANALYSIS

### Current State (2026-09-06)

**Models:** 19 files
- BaseModel, Task, Schedule, Job, JobBatch, FailedJob, Result, ScheduleHistory, Frequency, Parameter, Import, Export, FailedImportRow, TaskComment, JobManager, JobsWaiting, etc.

**Relationships:** Well-defined
- Task → Frequencies → Parameters
- Task → Results (execution history)
- Schedule → ScheduleHistory (audit trail)
- Job/JobBatch → FailedJob (DLQ)

**Tests:** 38 passing, 26 failing (2026-07-14)
- Issues: EventSourcing binding, config resolution in tests
- Need: More feature tests (batch progress, retry logic, failure handlers)

### Coverage Gaps

1. **Batch workflows:**
   - progress() calculation
   - partial failure handling
   - progress callbacks/WebSocket

2. **Failure scenarios:**
   - Timeout handling
   - Idempotency enforcement
   - Cascading job dependencies

3. **Import/Export:**
   - Row-by-row validation
   - Failed row recovery
   - Streaming large datasets

4. **Monitoring:**
   - Result auto-cleanup policy
   - Dead letter inspection
   - Performance metrics

### Future Test Plan

- [ ] Integration tests for batch processing (100+ jobs)
- [ ] Failure recovery workflows (retry, manual fix, resume)
- [ ] Import validation and error handling
- [ ] Schedule execution history accuracy
- [ ] Worker lifecycle (startup, shutdown, graceful)
- [ ] Memory/resource limits under load
- [ ] WebSocket progress updates
- [ ] Cost attribution per job type

---

## LAST WORDS

The Job module is not a generic queue abstraction. It is an **opinionated system for reliable, observable async work in FixCity.**

Its religion: **Move work off the request, bring results back home.**
Its philosophy: **Reliable > fast; observable > hidden; simple > magical.**
Its politics: **Fail gracefully; retry intelligently; monitor everything.**

Use it when you need: background processing, scheduling, batch operations, progress tracking, failure recovery.

Do not use it for: real-time messaging (use WebSocket), event streaming (use Kafka), simple logging (use Log facade).

---

**Document:** PHILOSOPHY.md  
**Version:** 1.0  
**Status:** Active (2026-09-06)  
**Owner:** Job Module  
**Visionary Intent:** Async mastery for sustainable scale
