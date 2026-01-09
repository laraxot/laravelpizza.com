# ⚡ Job Module - Advanced Queue & Job Management System

## 📋 Overview
Modulo avanzato per la gestione di code, job schedulati e processi batch in Laravel con integrazione Filament 4.x e supporto HTML2PDF per report.
**Namespace:** `Modules\Job`
**Filament:** v4.2.0 (Full Integration)
**Queue System:** Laravel Queue + Redis
**PHPStan:** Level 10 Compliant
**HTML2PDF:** Report Job Analytics
---
## 🎯 Core Features
### 1. Multi-Queue System
- ✅ Support for 10+ simultaneous queues
- ✅ Priority-based job processing
- ✅ Real-time monitoring dashboard
- ✅ Failed job handling and retry logic
- ✅ Queue worker management
### 2. Advanced Scheduling
- ✅ Complex cron expressions
- ✅ Timezone-aware scheduling
- ✅ Overlap prevention
- ✅ Single server execution
- ✅ Schedule history tracking
### 3. Batch Processing
- ✅ Job batch management
- ✅ Progress tracking
- ✅ Failure handling
- ✅ Batch notifications
- ✅ Rollback capabilities
### 4. Real-Time Monitoring
- ✅ Dashboard with live statistics
- ✅ Performance metrics
- ✅ Alert system
- ✅ Execution history
- ✅ Queue health monitoring
## 🏗️ Architecture
### Directory Structure
```
Modules/Job/
├── app/
│   ├── Models/
│   │   ├── Job.php                    # Job model
│   │   ├── Task.php                   # Scheduled tasks
│   │   ├── Schedule.php               # Schedule management
│   │   ├── JobBatch.php               # Batch jobs
│   │   ├── Result.php                 # Task results
│   │   ├── Frequency.php              # Execution frequencies
│   │   ├── Parameter.php              # Job parameters
│   │   ├── Export.php                 # Export jobs
│   │   ├── Import.php                 # Import jobs
│   │   └── FailedJob.php              # Failed jobs
│   ├── Services/
│   │   ├── JobManagerService.php      # Job orchestration
│   │   ├── QueueMonitorService.php    # Queue monitoring
│   │   ├── ScheduleService.php        # Schedule management
│   │   ├── BatchService.php           # Batch processing
│   │   └── JobReportService.php       # PDF reports
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── JobResource/
│   │   │   ├── TaskResource/
│   │   │   ├── ScheduleResource/
│   │   │   └── JobBatchResource/
│   │   ├── Pages/
│   │   │   ├── ManageQueues.php
│   │   │   ├── JobMonitor.php
│   │   │   └── ScheduleCalendar.php
│   │   └── Widgets/
│   │       ├── QueueStatsWidget.php
│   │       └── JobHistoryWidget.php
│   ├── Jobs/
│   │   ├── BaseJob.php                # Base job class
│   │   ├── ProcessBatchJob.php
│   │   └── ScheduledTaskJob.php
│   └── Listeners/
│       ├── JobFailedListener.php
│       └── JobProcessedListener.php
├── database/
│   ├── migrations/
│   └── seeders/
├── tests/
│   ├── Unit/
│   │   ├── JobBusinessLogicTest.php
│   │   ├── TaskBusinessLogicTest.php
│   │   ├── ScheduleBusinessLogicTest.php
│   │   ├── JobBatchBusinessLogicTest.php
│   │   └── ResultBusinessLogicTest.php
│   └── Feature/
└── docs/
    ├── README.md                      # This file
    ├── job-reports.md                 # PDF reports guide
    └── queue-management.md            # Queue management guide
## 📊 Models & Relationships
### Job Model
```php
class Job extends XotBaseModel
{
    protected $fillable = [
        'queue_name',
        'payload',
        'attempts',
        'reserved_at',
        'available_at',
        'created_at',
    ];

    protected $casts = [
        'payload' => 'json',
        'reserved_at' => 'datetime',
        'available_at' => 'datetime',
    public function getDisplayNameAttribute(): string
    {
        $payload = $this->payload;
        return $payload['displayName'] ??
               class_basename($payload['job'] ?? 'Unknown Job');
    }
    public function batch(): BelongsTo
        return $this->belongsTo(JobBatch::class, 'id', 'job_ids');
}
### Task Model
class Task extends XotBaseModel
        'name',
        'description',
        'command',
        'parameters',
        'frequency_id',
        'is_active',
        'timezone',
        'max_instances',
        'timeout',
        'notification_email',
        'notification_slack',
        'maintenance_mode',
        'parameters' => 'json',
        'is_active' => 'boolean',
        'maintenance_mode' => 'boolean',
        'last_run_at' => 'datetime',
        'next_run_at' => 'datetime',
    public function frequency(): BelongsTo
        return $this->belongsTo(Frequency::class);
    public function results(): HasMany
        return $this->hasMany(Result::class);
    public function schedules(): HasMany
        return $this->hasMany(Schedule::class);
## 🔧 Services
### Job Manager Service
class JobManagerService
    public function createJob(string $queue, array $payload, int $delay = 0): Job
        return Job::create([
            'queue_name' => $queue,
            'payload' => json_encode($payload),
            'available_at' => now()->addSeconds($delay),
        ]);
    public function dispatchJob(Job $job): bool
        try {
            $payload = json_decode($job->payload, true);

            // Dispatch to Laravel queue
            \Queue::connection('redis')
                  ->pushRaw($job->payload, $job->queue_name);
            $job->update(['status' => 'dispatched']);
            // Log activity
            activity()
                ->performedOn($job)
                ->causedBy(auth()->user())
                ->withProperties([
                    'queue' => $job->queue_name,
                    'payload' => $payload,
                ])
                ->log('Job dispatched to queue');
            return true;
        } catch (Exception $e) {
            Log::error('Failed to dispatch job', [
                'job_id' => $job->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    public function retryFailedJob(FailedJob $failedJob): bool
            $job = $this->createJob(
                $failedJob->queue,
                json_decode($failedJob->payload, true)
            );
            $failedJob->delete();
            return $this->dispatchJob($job);
            Log::error('Failed to retry job', [
                'failed_job_id' => $failedJob->id,
### Queue Monitor Service
class QueueMonitorService
    public function getQueueStatistics(): array
        $queues = config('queue.queues', ['default']);

        return collect($queues)->map(function ($queue) {
            return [
                'name' => $queue,
                'pending' => $this->getPendingJobs($queue),
                'processing' => $this->getProcessingJobs($queue),
                'failed' => $this->getFailedJobs($queue),
                'size' => \Queue::size($queue),
                'failed_count' => \Queue::failed()->where('queue', $queue)->count(),
            ];
        })->toArray();
    public function getHealthStatus(): string
        $stats = $this->getQueueStatistics();
        $totalPending = array_sum(array_column($stats, 'pending'));
        $totalFailed = array_sum(array_column($stats, 'failed'));
        if ($totalFailed > 100) {
            return 'critical';
        if ($totalFailed > 10 || $totalPending > 1000) {
            return 'warning';
        return 'healthy';
    private function getPendingJobs(string $queue): int
        return Job::where('queue_name', $queue)
                  ->whereNull('reserved_at')
                  ->where('available_at', '<=', now())
                  ->count();
    private function getProcessingJobs(string $queue): int
                  ->whereNotNull('reserved_at')
                  ->where('reserved_at', '>', now()->subMinutes(5))
    private function getFailedJobs(string $queue): int
        return FailedJob::where('queue', $queue)->count();
## 📄 PDF Reports Integration
### Job Report Service
class JobReportService
    public function generateQueueReport(array $options = []): string
            $data = $this->prepareReportData($options);
            $html = view('job::pdf.queue-report', [
                'data' => $data,
                'options' => $options,
                'generatedAt' => now(),
            ])->render();
            $html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [15, 20, 15, 20]);
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($html);
            return $html2pdf->output('', 'S');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new JobReportException('Failed to generate queue report: ' . $e->getMessage());
    private function prepareReportData(array $options): array
        $monitor = app(QueueMonitorService::class);
        return [
            'queue_statistics' => $monitor->getQueueStatistics(),
            'health_status' => $monitor->getHealthStatus(),
            'job_history' => $this->getJobHistory($options),
            'performance_metrics' => $this->getPerformanceMetrics($options),
            'recommendations' => $this->generateRecommendations(),
        ];
### Queue Report Template
```blade
{{-- resources/views/pdf/queue-report.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="25mm" backright="25mm">
    <page_header>
        <h1 style="font-size: 16pt; text-align: center; color: #2c3e50;">
            Queue System Report
        </h1>
        <p style="text-align: center; font-size: 10pt; color: #7f8c8d;">
            Generated: {{ $generatedAt->format('d/m/Y H:i') }}
        </p>
    </page_header>
    <div style="margin: 15mm 0;">
        <!-- Health Status -->
        <div style="background-color: {{ $data['health_status'] == 'healthy' ? '#d4edda' : ($data['health_status'] == 'warning' ? '#fff3cd' : '#f8d7da') }};
                    padding: 10mm;
                    margin-bottom: 10mm;
                    border: 1px solid #dee2e6;">
            <h2 style="font-size: 14pt; margin: 0 0 5mm 0;">
                System Health: {{ ucfirst($data['health_status']) }}
            </h2>
        </div>
        <!-- Queue Statistics -->
        <h2 style="font-size: 14pt; margin-bottom: 8mm;">Queue Statistics</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #e9ecef;">
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt;">Queue</th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt;">Pending</th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt;">Processing</th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt;">Failed</th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt;">Size</th>
            </tr>
            @foreach($data['queue_statistics'] as $queue)
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ $queue['name'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $queue['pending'] }}
                    {{ $queue['processing'] }}
                    {{ $queue['failed'] }}
                    {{ $queue['size'] }}
            @endforeach
        </table>
    </div>
    <page_footer>
        <table style="width: 100%; font-size: 8pt; color: #7f8c8d;">
                <td style="width: 50%;">
                    Job Module Report - Generated by PTVX System
                <td style="width: 50%; text-align: right;">
                    Page [[page_cu]] of [[page_nb]]
    </page_footer>
</page>
## 🎨 Filament Integration

### Architettura Filament

**IMPORTANTE**: Tutte le pagine Filament estendono `XotBasePage`, mai direttamente `Filament\Pages\Page`.

#### Pagine del Modulo

- **JobStatus**: Estende `Modules\Xot\Filament\Pages\XotBasePage`
- **JobMonitor**: Estende `Modules\Xot\Filament\Pages\XotBasePage`
- **ManageQueues**: Estende `Modules\Xot\Filament\Pages\XotBasePage`
- **ScheduleCalendar**: Estende `Modules\Xot\Filament\Pages\XotBasePage`

#### Pattern Corretti

```php
// ✅ CORRETTO - Estende XotBasePage
use Modules\Xot\Filament\Pages\XotBasePage;

class JobStatus extends XotBasePage
{
    protected string $view = 'job::filament.pages.job-status';

    /**
     * @return array<string, mixed>
     */
    public function getHeaderWidgets(): array
    {
        return [
            'clock' => ClockWidget::make(),
        ];
    }
}

// ❌ SBAGLIATO - Mai estendere direttamente Filament
use Filament\Pages\Page;

class JobStatus extends Page // VIOLAZIONE ARCHITETTURALE
{
}
```

### Queue Management Resource

```php
class QueueManagementResource extends XotBaseResource
{
    protected static ?string $model = Job::class;

    /**
     * @return array<string, mixed>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQueues::route('/'),
            'monitor' => Pages\JobMonitor::route('/monitor'),
            'schedule' => Pages\ScheduleCalendar::route('/schedule'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function getWidgets(): array
    {
        return [
            'queue_stats' => QueueStatsWidget::class,
            'job_history' => JobHistoryWidget::class,
        ];
    }
}
```

### Queue Stats Widget

```php
class QueueStatsWidget extends XotBaseWidget
{
    protected static string $view = 'job::filament.widgets.queue-stats';

    /**
     * @return array<string, mixed>
     */
    public function getViewData(): array
    {
        $monitor = app(QueueMonitorService::class);

        return [
            'statistics' => $monitor->getQueueStatistics(),
            'total_jobs' => Job::count(),
            'failed_jobs' => FailedJob::count(),
            'active_tasks' => Task::where('is_active', true)->count(),
        ];
    }
}
## 🧪 Testing Status
### ✅ Completed Tests (85% Coverage)
#### Business Logic Tests
- **JobBusinessLogicTest** - Complete job management
- **TaskBusinessLogicTest** - Scheduled task handling
- **ScheduleBusinessLogicTest** - Schedule management
- **JobBatchBusinessLogicTest** - Batch processing
- **ResultBusinessLogicTest** - Result handling
### ❌ Pending Tests
#### Base Model Tests
- **BaseModel** - Base model functionality
- **BaseMorphPivot** - Morph relationships
- **BasePivot** - Standard relationships
#### Integration Tests
- Multi-model scenarios
- Performance tests
- Scalability tests
## 📊 Quality Metrics
| Metric | Current | Target | Status |
|--------|---------|--------|--------|
| Test Coverage | 85% | 95% | 🔄 In Progress |
| PHPStan Level | 10 | 10 | ✅ Pass |
| Factory Coverage | 100% | 100% | ✅ Complete |
| Seeder Coverage | 100% | 100% | ✅ Complete |
| Models Tested | 5/8 | 8/8 | 🔄 In Progress |

### 🔍 Strumenti di qualità (da lanciare da `laravel/`)

- **PHPStan**: `./vendor/bin/phpstan analyse Modules/Job --level=10`
- **PHPMD (phar)**: `php phpmd.phar Modules/Job text codesize`
- **PHP Insights**: `./vendor/bin/phpinsights analyse Modules/Job`

## 🚀 Installation & Setup
### 1. Module Installation
```bash
# Enable the module
php artisan module:enable Job
# Run migrations
php artisan migrate
# Publish assets
php artisan vendor:publish --tag=job-assets
# Setup queue tables
php artisan queue:table
php artisan queue:failed-table
### 2. Queue Configuration
// config/queue.php
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => env('REDIS_QUEUE', 'default'),
        'retry_after' => 90,
        'block_for' => null,
    ],
],
'failed' => [
    'driver' => 'database',
    'database' => 'mysql',
    'table' => 'failed_jobs',
### 3. Worker Configuration
# Start queue workers
php artisan queue:work --queue=default,high,low --sleep=3 --tries=3
# Monitor queues
php artisan queue:monitor
## 🎯 Best Practices
### 1. Job Design
// ✅ GOOD: Structured job with proper error handling
class ProcessDataJob extends BaseJob
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(private Data $data) {}
    public function handle(): void
            $this->processData();
                ->performedOn($this->data)
                ->log('Data processed successfully');

            Log::error('Data processing failed', [
                'data_id' => $this->data->id,
            $this->fail($e);
### 2. Queue Prioritization
// ✅ GOOD: Proper queue prioritization
HighPriorityJob::dispatch()->onQueue('high');
DefaultJob::dispatch()->onQueue('default');
LowPriorityJob::dispatch()->onQueue('low');
// ✅ GOOD: Batch processing with progress tracking
$batch = Bus::batch([
    new ProcessItemJob($item1),
    new ProcessItemJob($item2),
    new ProcessItemJob($item3),
])->then(function (Batch $batch) {
    // All jobs completed successfully
})->catch(function (Batch $batch, Throwable $e) {
    // First batch job failure detected
})->finally(function (Batch $batch) {
    // The batch has finished executing
})->dispatch();
## 📚 Documentation Links
### Internal Documentation
- [Job Reports Guide](./job-reports.md)
- [Queue Management Guide](./queue-management.md)
- [HTML2PDF Best Practices](../Xot/docs/html2pdf-best-practices.md)
### Related Modules
- [Activity Module](../Activity/docs/README.md) - Activity logging
- [Notify Module](../Notify/docs/README.md) - Notifications
- [Xot Module](../Xot/docs/README.md) - Base framework
### External Resources
- [Laravel Queue Documentation](https://laravel.com/docs/queues)
- [Filament Documentation](https://filamentphp.com/docs)
- [Redis Queue Configuration](https://laravel.com/docs/redis#queues)
## 🔗 Quick Links
- **Module Overview**: [Modules/Job](../Job)
- **Queue Management**: [Queue Management](./queue-management.md)
- **PDF Reports**: [Job Reports](./job-reports.md)
- **Testing Guide**: [Testing Guide](./testing.md)
- **API Documentation**: [API Docs](./api.md)
**Last Updated:** 2025-12-09
**Version:** 2.1.0
**Status:** ✅ Production Ready
**PHPStan Level:** 10 ✅
**Test Coverage:** 85% 🔄
**HTML2PDF Integration:** ✅
