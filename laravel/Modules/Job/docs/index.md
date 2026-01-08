# Job Module Documentation

## Overview
The Job module provides comprehensive job queue management and background processing capabilities for the Laraxot system. It extends Laravel's queue system with enhanced features for job monitoring, scheduling, and distributed processing.

## Key Features
- **Job Management**: Create, schedule, and monitor background jobs
- **Queue Monitoring**: Real-time queue status and performance metrics
- **Job Scheduling**: Advanced job scheduling with cron-like expressions
- **Distributed Processing**: Scale job processing across multiple servers
- **Failure Handling**: Automatic retry mechanisms and failure notifications
- **Priority Queues**: Job prioritization and resource allocation

## Architecture
The module follows the Laraxot architecture principles:
- Extends Xot base classes
- Uses Filament for admin interface
- Implements proper service providers
- Follows DRY/KISS principles

## Core Components

### Models
- `Job` - Job queue representation
- `JobBatch` - Batch job processing
- `FailedJob` - Failed job tracking and management
- `JobSchedule` - Scheduled job definitions

### Resources
- `JobResource` - Job management interface
- `FailedJobResource` - Failed job management resource
- `JobBatchResource` - Batch job management
- `JobScheduleResource` - Scheduled job management

### Services
- `JobService` - Core job management operations
- `JobScheduler` - Job scheduling functionality
- `JobMonitor` - Job monitoring and metrics
- `JobDispatcher` - Job dispatching and routing
- `FailureHandler` - Job failure handling and recovery

## Implementation Guide

### Creating Jobs
```php
// Create a basic job
class ProcessUserData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        // Process user data
        $user = User::find($this->userId);
        // Perform operations
    }
}

// Dispatch the job
ProcessUserData::dispatch($userId);

// Dispatch with delay
ProcessUserData::dispatch($userId)->delay(now()->addMinutes(10));

// Dispatch on specific queue
ProcessUserData::dispatch($userId)->onQueue('processing');
```

### Job Batching
```php
// Create a batch job
$batch = Bus::batch([
    new ImportCsv(1),
    new ImportCsv(2),
    new ImportCsv(3),
])->then(function (Batch $batch) {
    // All jobs completed successfully
    event(new ImportCompleted($batch));
})->catch(function (Batch $batch, Throwable $e) {
    // First batch job failure detected
    event(new ImportFailed($batch, $e));
})->finally(function (Batch $batch) {
    // The batch has finished executing
    event(new ImportFinished($batch));
})->dispatch();

// Add jobs to existing batch
$batch->add([
    new ImportCsv(4),
    new ImportCsv(5),
]);
```

### Job Scheduling
```php
// Schedule jobs using cron expressions
$scheduler = app(JobScheduler::class);

// Schedule daily at midnight
$scheduler->schedule('App\Jobs\DailyReport', '0 0 * * *');

// Schedule weekly on Mondays at 2 AM
$scheduler->schedule('App\Jobs\WeeklyCleanup', '0 2 * * 1');

// Schedule with parameters
$scheduler->schedule('App\Jobs\ProcessData', '0 */6 * * *', [
    'priority' => 'high',
    'timeout' => 3600
]);
```

## Queue Management

### Queue Configuration
```php
// config/queue.php
return [
    'default' => env('QUEUE_CONNECTION', 'redis'),
    
    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],
        
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
        ],
        
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],
    ],
    
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
```

### Queue Monitoring
```php
// Monitor queue status
$jobMonitor = app(JobMonitor::class);

// Get queue statistics
$stats = $jobMonitor->getQueueStats();

// Get failed jobs count
$failedCount = $jobMonitor->getFailedJobsCount();

// Get pending jobs count
$pendingCount = $jobMonitor->getPendingJobsCount();

// Get average processing time
$avgTime = $jobMonitor->getAverageProcessingTime();
```

## Advanced Features

### Job Prioritization
1. **Queue Priority**: Different queues for different priorities
2. **Job Weight**: Assign weights to jobs for processing order
3. **Resource Allocation**: Allocate resources based on job priority
4. **Deadline Management**: Jobs with deadlines get priority

### Failure Handling
- **Automatic Retry**: Configurable retry attempts with exponential backoff
- **Failure Notifications**: Alert administrators of job failures
- **Dead Letter Queues**: Move repeatedly failing jobs to separate queues
- **Root Cause Analysis**: Analyze failure patterns and causes

### Distributed Processing
- **Horizontal Scaling**: Scale job workers across multiple servers
- **Load Balancing**: Distribute jobs evenly across workers
- **Worker Health Monitoring**: Monitor worker status and performance
- **Graceful Shutdown**: Handle worker shutdown gracefully

## Performance Optimization
1. **Batch Processing**: Process multiple items in single jobs
2. **Memory Management**: Efficient memory usage in long-running jobs
3. **Database Connections**: Manage database connections properly
4. **Caching**: Cache frequently accessed data
5. **Concurrency Control**: Control concurrent job execution

## Best Practices
1. **Job Size**: Keep jobs small and focused
2. **Idempotency**: Make jobs idempotent when possible
3. **Error Handling**: Implement proper error handling and logging
4. **Timeout Management**: Set appropriate timeout values
5. **Resource Cleanup**: Clean up resources after job completion
6. **Monitoring**: Monitor job performance and failure rates

## Related Modules
- [Xot Module](../Xot/docs/index.md) - Core base classes
- [Activity Module](../Activity/docs/index.md) - Activity logging
- [Notify Module](../Notify/docs/index.md) - Notification system
- [User Module](../User/docs/README.md) - User authentication and management

## Troubleshooting
Common issues and solutions:
- Jobs stuck in queue
- Memory exhaustion in long-running jobs
- Database connection issues
- Retry loop problems
- Worker process crashes