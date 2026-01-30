# Analisi Dettagliata dei Colli di Bottiglia - Modulo CloudStorage

## Panoramica
Il modulo CloudStorage gestisce lo storage distribuito dell'applicazione. L'analisi ha identificato diverse aree critiche che impattano le performance.

## 1. Upload File
**Problema**: Upload inefficiente di file di grandi dimensioni
- Impatto: Timeout durante upload di file grandi
- Causa: Upload sincrono e mancanza di chunking

**Soluzione Proposta**:
```php
declare(strict_types=1);

namespace Modules\CloudStorage\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

final class ChunkedUploadService
{
    use QueueableAction;

    private const CHUNK_SIZE = 5 * 1024 * 1024; // 5MB

    public function handleUpload(UploadedFile $file): string
    {
        $totalChunks = ceil($file->getSize() / self::CHUNK_SIZE);
        $uploadId = $this->initializeMultipartUpload($file);
        
        collect(range(1, $totalChunks))
            ->each(fn($chunkNumber) => 
                $this->processChunk($file, $uploadId, $chunkNumber)
            );
            
        return $this->completeMultipartUpload($uploadId);
    }

    private function initializeMultipartUpload(UploadedFile $file): string
    {
        return Storage::cloud()->getAdapter()->getClient()
            ->createMultipartUpload([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $this->generateKey($file),
                'ContentType' => $file->getMimeType()
            ])['UploadId'];
    }

    private function processChunk(UploadedFile $file, string $uploadId, int $chunkNumber): void
    {
        $chunk = $this->readChunk($file, $chunkNumber);
        
        Storage::cloud()->getAdapter()->getClient()
            ->uploadPart([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $this->generateKey($file),
                'UploadId' => $uploadId,
                'PartNumber' => $chunkNumber,
                'Body' => $chunk
            ]);
    }
}
```

## 2. Ottimizzazione Cache
**Problema**: Caching inefficiente dei file frequenti
- Impatto: Latenza nell'accesso ai file
- Causa: Strategia di caching non ottimizzata

**Soluzione Proposta**:
```php
declare(strict_types=1);

namespace Modules\CloudStorage\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

final class StorageCacheService
{
    use QueueableAction;

    public function getFile(string $path): ?string
    {
        return Cache::tags(['storage', $this->getPathTag($path)])
            ->remember(
                "file_{$path}",
                $this->determineTTL($path),
                fn() => $this->fetchFile($path)
            );
    }

    private function determineTTL(string $path): int
    {
        return match (true) {
            str_contains($path, 'static/') => now()->addWeek()->diffInSeconds(),
            str_contains($path, 'temp/') => now()->addHour()->diffInSeconds(),
            default => now()->addDay()->diffInSeconds()
        };
    }

    private function fetchFile(string $path): ?string
    {
        try {
            return Storage::cloud()->get($path);
        } catch (\Exception $e) {
            Log::error('File fetch failed', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}
```

## 3. Gestione Concorrenza
**Problema**: Conflitti durante operazioni concorrenti
- Impatto: Race conditions e file corrotti
- Causa: Mancanza di locking e versioning

**Soluzione Proposta**:
```php
declare(strict_types=1);

namespace Modules\CloudStorage\Services;

use Illuminate\Support\Facades\Redis;
use Spatie\QueueableAction\QueueableAction;

final class StorageLockService
{
    use QueueableAction;

    private const LOCK_TTL = 30; // secondi

    public function withLock(string $path, callable $callback): mixed
    {
        $lock = Redis::lock("storage_lock_{$path}", self::LOCK_TTL);
        
        try {
            $lock->block(5); // attende massimo 5 secondi
            return $callback();
        } finally {
            optional($lock)->release();
        }
    }

    public function optimisticLock(string $path, callable $callback): mixed
    {
        $version = $this->getCurrentVersion($path);
        
        $result = $callback($version);
        
        if (!$this->checkVersion($path, $version)) {
            throw new ConcurrencyException('Version mismatch');
        }
        
        return $result;
    }

    private function getCurrentVersion(string $path): string
    {
        return Cache::tags(['storage_versions'])
            ->remember("version_{$path}", now()->addDay(), fn() => 
                Storage::cloud()->getMetadata($path)['VersionId'] ?? uniqid()
            );
    }
}
```

## Metriche di Performance

### Obiettivi
- Tempo upload (5MB): < 10s
- Tempo download (5MB): < 5s
- Cache hit rate: > 85%
- Concorrenza: 50 op/s

### Monitoraggio
```php
// In: Providers/CloudStorageServiceProvider.php
private function setupPerformanceMonitoring(): void
{
    // Monitoring storage
    Storage::cloud()->buildMiddleware(function($handler) {
        return function($command, $request) use ($handler) {
            $start = microtime(true);
            
            $result = $handler($command, $request);
            
            $duration = microtime(true) - $start;
            
            if ($duration > 5) { // 5 secondi
                Log::channel('storage_performance')
                    ->warning('Operazione storage lenta', [
                        'operation' => $command->getName(),
                        'path' => $request->get('Key'),
                        'duration' => $duration
                    ]);
            }
            
            return $result;
        };
    });

    // Monitoring cache
    Event::listen(CacheHit::class, function($event) {
        Metrics::increment('storage_cache_hits');
    });

    Event::listen(CacheMissed::class, function($event) {
        Metrics::increment('storage_cache_misses');
    });
}
```

## Piano di Implementazione

### Fase 1 (Immediata)
- Implementare upload chunked
- Ottimizzare caching
- Migliorare concorrenza

### Fase 2 (Medio Termine)
- Implementare CDN
- Ottimizzare compressione
- Migliorare resilienza

### Fase 3 (Lungo Termine)
- Implementare sharding
- Ottimizzare distribuzione
- Migliorare scalabilità

## Note Tecniche Aggiuntive

### 1. Configurazione Storage
```php
// In: config/filesystems.php
return [
    'disks' => [
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => true,
            'options' => [
                'CacheControl' => 'max-age=31536000'
            ]
        ]
    ],
    'cloud' => [
        'chunk_size' => env('CLOUD_CHUNK_SIZE', 5 * 1024 * 1024),
        'timeout' => env('CLOUD_TIMEOUT', 300),
        'retries' => env('CLOUD_RETRIES', 3)
    ]
];
```

### 2. Ottimizzazione Compressione
```php
// In: Services/CompressionService.php
declare(strict_types=1);

namespace Modules\CloudStorage\Services;

use Spatie\QueueableAction\QueueableAction;

final class CompressionService
{
    use QueueableAction;

    public function compressFile(string $path): string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        return match ($extension) {
            'jpg', 'jpeg' => $this->compressImage($path),
            'pdf' => $this->compressPdf($path),
            default => $this->compressGeneric($path)
        };
    }

    private function compressImage(string $path): string
    {
        return Image::make($path)
            ->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(null, 85);
    }
}
```

### 3. Gestione Versioning
```php
// In: Models/StorageFile.php
declare(strict_types=1);

namespace Modules\CloudStorage\Models;

use Illuminate\Database\Eloquent\Model;

final class StorageFile extends Model
{
    protected $casts = [
        'metadata' => 'array',
        'versions' => 'array'
    ];

    public function addVersion(string $path, array $metadata): void
    {
        $this->versions = array_merge($this->versions ?? [], [
            [
                'path' => $path,
                'metadata' => $metadata,
                'created_at' => now()
            ]
        ]);

        $this->save();
    }

    public function getLatestVersion(): ?array
    {
        return collect($this->versions)
            ->sortByDesc('created_at')
            ->first();
    }
}
``` 