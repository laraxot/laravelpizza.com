# Analisi Dettagliata dei Colli di Bottiglia - Modulo Job

## Panoramica
Il modulo Job gestisce le code e i processi asincroni dell'applicazione. L'analisi ha identificato diverse aree critiche che impattano le performance.

## 1. Gestione Code
**Problema**: Gestione inefficiente delle code di lavoro
- Impatto: Latenza nell'elaborazione dei job
- Causa: Mancanza di prioritizzazione e code sovraccariche

**Soluzione Proposta**:
```php
declare(strict_types=1);

namespace Modules\Job\Services;

use Illuminate\Support\Facades\Queue;
use Spatie\QueueableAction\QueueableAction;

final class QueueManagerService
{
    use QueueableAction;

    private const QUEUE_PRIORITIES = [
        'high' => 100,
        'default' => 50,
        'low' => 10
    ];

    public function dispatch($job, string $priority = 'default'): void
    {
        $queue = $this->determineQueue($priority);
        
        Queue::pushOn(
            $queue,
            $job->onQueue($queue)
                ->delay($this->calculateDelay($priority))
        );
    }

    private function determineQueue(string $priority): string
    {
        return match ($priority) {
            'high' => 'jobs-high',
            'low' => 'jobs-low',
            default => 'jobs-default'
        };
    }

    private function calculateDelay(string $priority): int
    {
        return match ($priority) {
            'high' => 0,
            'low' => 300, // 5 minuti
            default => 60 // 1 minuto
        };
    }
}
```

## 2. Monitoraggio Job
**Problema**: Monitoraggio insufficiente dei job
- Impatto: Difficoltà nel debugging e ottimizzazione
- Causa: Mancanza di metriche e logging dettagliato

**Soluzione Proposta**:
```php
declare(strict_types=1);

namespace Modules\Job\Services;

use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;

final class JobMonitoringService
{
    use QueueableAction;

    public function trackJob($job, string $status): void
    {
        $metrics = $this->collectMetrics($job);
        
        // Logging dettagliato
        Log::channel('jobs')
            ->info("Job {$status}", [
                'job_id' => $job->job_id,
                'type' => get_class($job),
                'queue' => $job->queue,
                'attempt' => $job->attempts(),
                'metrics' => $metrics
            ]);
            
        // Metriche per monitoring
        $this->updateMetrics($metrics);
    }

    private function collectMetrics($job): array
    {
        return [
            'memory_usage' => memory_get_usage(true),
            'peak_memory' => memory_get_peak_usage(true),
            'processing_time' => microtime(true) - $job->start_time,
            'queue_wait_time' => $job->start_time - $job->created_at->timestamp
        ];
    }

    private function updateMetrics(array $metrics): void
    {
        foreach ($metrics as $key => $value) {
            app('prometheus')->getOrRegisterGauge('jobs', $key)
                ->set($value);
        }
    }
}
```

## 3. Ottimizzazione Storage
**Problema**: Gestione inefficiente dello storage media
- Impatto: Spazio disco non ottimizzato
- Causa: Mancanza di politiche di gestione storage

**Soluzione Proposta**:
```php
declare(strict_types=1);

namespace Modules\Media\Services;

use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

final class MediaStorageService
{
    use QueueableAction;

    public function optimizeStorage(): void
    {
        // Pulizia file temporanei
        $this->cleanupTempFiles();
        
        // Ottimizzazione storage
        $this->optimizeMediaFiles();
        
        // Deduplicazione
        $this->deduplicateFiles();
    }

    private function cleanupTempFiles(): void
    {
        $tempFiles = Storage::files('temp');
        
        collect($tempFiles)
            ->filter(fn($file) => 
                Storage::lastModified($file) < now()->subDay()->timestamp
            )
            ->each(fn($file) => Storage::delete($file));
    }

    private function optimizeMediaFiles(): void
    {
        $mediaFiles = Storage::allFiles('media');
        
        collect($mediaFiles)
            ->filter(fn($file) => $this->shouldOptimize($file))
            ->each(fn($file) => $this->optimizeFile($file));
    }

    private function shouldOptimize(string $file): bool
    {
        $size = Storage::size($file);
        $type = Storage::mimeType($file);
        
        return $size > 1024 * 1024 && // > 1MB
               str_starts_with($type, 'image/');
    }
}
```

## Metriche di Performance

### Obiettivi
- Tempo in coda: < 30s per job prioritari
- Memoria per job: < 64MB
- Tasso di successo: > 99%
- Retry efficaci: > 80%

### Monitoraggio
```php
// In: Providers/JobServiceProvider.php
private function setupPerformanceMonitoring(): void
{
    // Monitoring code
    Queue::looping(function () {
        $stats = Queue::getRedis()->info();
        
        if ($stats['used_memory'] > 1024 * 1024 * 512) { // 512MB
            Log::channel('job_performance')
                ->warning('Alto utilizzo memoria Redis', [
                    'memory' => $stats['used_memory'],
                    'peak' => $stats['used_memory_peak']
                ]);
        }
    });

    // Monitoring job
    Queue::before(function ($job) {
        $job->start_time = microtime(true);
    });

    Queue::after(function ($job) {
        $duration = microtime(true) - $job->start_time;
        
        if ($duration > 30) { // 30 secondi
            Log::channel('job_performance')
                ->warning('Job lento rilevato', [
                    'job' => get_class($job),
                    'duration' => $duration
                ]);
        }
    });
}
```

## Piano di Implementazione

### Fase 1 (Immediata)
- Implementare code prioritarie
- Migliorare monitoraggio
- Ottimizzare gestione errori

### Fase 2 (Medio Termine)
- Implementare retry intelligente
- Ottimizzare uso memoria
- Migliorare logging

### Fase 3 (Lungo Termine)
- Implementare scaling automatico
- Ottimizzare distribuzione job
- Migliorare resilienza

## Note Tecniche Aggiuntive

### 1. Configurazione Code
```php
// In: config/queue.php
return [
    'default' => env('QUEUE_CONNECTION', 'redis'),
    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'queue',
            'queue' => [
                'jobs-high',
                'jobs-default',
                'jobs-low'
            ],
            'retry_after' => 90,
            'block_for' => 5
        ]
    ],
    'batching' => [
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'job_batches'
    ],
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs'
    ]
];
```

### 2. Ottimizzazione Immagini
```php
// In: Services/ImageOptimizer.php
declare(strict_types=1);

namespace Modules\Media\Services;

use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\QueueableAction\QueueableAction;

final class ImageOptimizer
{
    use QueueableAction;

    public function optimize(string $path): void
    {
        $optimizerChain = OptimizerChainFactory::create();
        
        $optimizerChain
            ->setTimeout(60)
            ->useLogger(Log::channel('media_optimization'))
            ->optimize($path);
    }

    public function optimizeMultiple(array $paths): void
    {
        collect($paths)
            ->chunk(10)
            ->each(fn($chunk) => 
                dispatch(new OptimizeImagesJob($chunk))
                    ->onQueue('media-optimization')
            );
    }
}
```

### 2. Ottimizzazione Redis
```php
// In: config/database.php
'redis' => [
    'queue' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_QUEUE_DB', '1'),
        'read_write_timeout' => 60,
        'persistent' => true,
        'options' => [
            'serializer' => Redis::SERIALIZER_IGBINARY,
            'compression' => Redis::COMPRESSION_LZ4
        ]
    ]
]
```

### 3. Gestione Memoria
```php
// In: Jobs/BaseJob.php
declare(strict_types=1);

namespace Modules\Job\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class BaseJob
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected function optimizeMemory(): void
    {
        // Impostare limite memoria per job
        ini_set('memory_limit', '64M');
        
        // Garbage collection
        if (gc_enabled()) {
            gc_collect_cycles();
        }
        
        // Clear static properties
        $reflection = new \ReflectionClass(static::class);
        foreach ($reflection->getProperties() as $property) {
            if ($property->isStatic()) {
                $property->setValue(null);
            }
        }
    }
}
``` 