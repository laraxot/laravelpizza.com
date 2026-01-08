# Analisi Dettagliata dei Colli di Bottiglia - Modulo Media

## Panoramica
Il modulo Media gestisce l'elaborazione e la manipolazione dei file multimediali nell'applicazione. L'analisi ha identificato diverse aree critiche che impattano le performance.

## 1. Elaborazione Immagini
**Problema**: Processamento inefficiente delle immagini
- Impatto: Latenza durante il caricamento e la manipolazione
- Causa: Elaborazione sincrona e mancanza di ottimizzazione

**Soluzione Proposta**:
```php
declare(strict_types=1);

namespace Modules\Media\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\QueueableAction\QueueableAction;

final class ImageProcessingService
{
    use QueueableAction;

    public function processImage(string $path, array $operations): string
    {
        // Processamento asincrono per operazioni pesanti
        if ($this->isHeavyOperation($operations)) {
            return $this->processAsync($path, $operations);
        }

        return $this->processSync($path, $operations);
    }

    private function processSync(string $path, array $operations): string
    {
        $image = Image::make(Storage::path($path));
        
        foreach ($operations as $operation => $params) {
            match ($operation) {
                'resize' => $this->applyResize($image, $params),
                'optimize' => $this->applyOptimization($image, $params),
                'watermark' => $this->applyWatermark($image, $params)
            };
        }
        
        return $this->saveProcessedImage($image);
    }

    private function isHeavyOperation(array $operations): bool
    {
        return isset($operations['resize']) && 
            ($operations['resize']['width'] > 2000 || 
             $operations['resize']['height'] > 2000);
    }

    private function applyOptimization($image, array $params): void
    {
        $image->encode(null, $params['quality'] ?? 85)
              ->interlace()
              ->sharpen($params['sharpen'] ?? 10);
    }
}
```

## 2. Gestione Cache Media
**Problema**: Caching non ottimizzato delle risorse media
- Impatto: Overhead nelle richieste ripetute
- Causa: Strategia di caching inefficiente

**Soluzione Proposta**:
```php
declare(strict_types=1);

namespace Modules\Media\Services;

use Illuminate\Support\Facades\Cache;
use Spatie\QueueableAction\QueueableAction;

final class MediaCacheService
{
    use QueueableAction;

    private const CACHE_TTL = 604800; // 1 settimana

    public function getCachedMedia(string $path, array $transformations = []): ?string
    {
        $cacheKey = $this->generateCacheKey($path, $transformations);
        
        return Cache::tags(['media', $this->getPathTag($path)])
            ->remember($cacheKey, self::CACHE_TTL, function() use ($path, $transformations) {
                return $this->processAndCache($path, $transformations);
            });
    }

    private function generateCacheKey(string $path, array $transformations): string
    {
        return sprintf(
            'media_%s_%s',
            md5($path),
            empty($transformations) ? 'original' : md5(serialize($transformations))
        );
    }

    private function processAndCache(string $path, array $transformations): ?string
    {
        try {
            if (empty($transformations)) {
                return Storage::get($path);
            }

            return app(ImageProcessingService::class)
                ->processImage($path, $transformations);
        } catch (\Exception $e) {
            Log::error('Media processing failed', [
                'path' => $path,
                'transformations' => $transformations,
                'error' => $e->getMessage()
            ]);
            return null;
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
- Tempo elaborazione immagine: < 2s
- Cache hit rate: > 90%
- Spazio storage ottimizzato: -30%
- Tempo caricamento media: < 1s

### Monitoraggio
```php
// In: Providers/MediaServiceProvider.php
private function setupPerformanceMonitoring(): void
{
    // Monitoring elaborazione
    Event::listen(MediaProcessing::class, function ($event) {
        $start = microtime(true);
        
        return function () use ($start) {
            $duration = microtime(true) - $start;
            
            if ($duration > 2.0) { // 2 secondi
                Log::channel('media_performance')
                    ->warning('Elaborazione media lenta', [
                        'path' => $event->path,
                        'duration' => $duration
                    ]);
            }
            
            Metrics::timing('media.processing', $duration * 1000);
        };
    });

    // Monitoring storage
    Event::listen(MediaStored::class, function ($event) {
        $size = Storage::size($event->path);
        
        Metrics::gauge('media.storage', $size, [
            'type' => Storage::mimeType($event->path)
        ]);
    });
}
```

## Piano di Implementazione

### Fase 1 (Immediata)
- Implementare elaborazione asincrona
- Ottimizzare caching
- Migliorare gestione storage

### Fase 2 (Medio Termine)
- Implementare CDN
- Ottimizzare compressione
- Migliorare resilienza

### Fase 3 (Lungo Termine)
- Implementare sharding
- Ottimizzare distribuzione
- Migliorare scalabilità

## Note Tecniche Aggiuntive

### 1. Configurazione Media
```php
// In: config/media.php
return [
    'processing' => [
        'max_width' => env('MEDIA_MAX_WIDTH', 2000),
        'max_height' => env('MEDIA_MAX_HEIGHT', 2000),
        'quality' => env('MEDIA_QUALITY', 85),
        'formats' => ['jpg', 'png', 'webp']
    ],
    'cache' => [
        'ttl' => env('MEDIA_CACHE_TTL', 604800),
        'versions' => env('MEDIA_CACHE_VERSIONS', 3)
    ],
    'storage' => [
        'temp_ttl' => env('MEDIA_TEMP_TTL', 86400),
        'dedup_enabled' => env('MEDIA_DEDUP_ENABLED', true)
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

### 3. Gestione Versioni
```php
// In: Models/Media.php
declare(strict_types=1);

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;

final class Media extends Model
{
    protected $casts = [
        'metadata' => 'array',
        'transformations' => 'array'
    ];

    public function addVersion(array $transformations): self
    {
        $this->versions = collect($this->versions ?? [])
            ->push([
                'transformations' => $transformations,
                'path' => $this->generateVersionPath($transformations),
                'created_at' => now()
            ])
            ->sortByDesc('created_at')
            ->take(config('media.cache.versions'))
            ->values()
            ->all();

        $this->save();
        
        return $this;
    }

    private function generateVersionPath(array $transformations): string
    {
        return sprintf(
            '%s_%s.%s',
            pathinfo($this->path, PATHINFO_FILENAME),
            md5(serialize($transformations)),
            pathinfo($this->path, PATHINFO_EXTENSION)
        );
    }
}
### Versione HEAD

``` 
## Collegamenti tra versioni di bottlenecks_detailed.md
* [bottlenecks_detailed.md](../../../Xot/docs/bottlenecks_detailed.md)
* [bottlenecks_detailed.md](../../../Job/docs/bottlenecks_detailed.md)
* [bottlenecks_detailed.md](../../../Media/docs/bottlenecks_detailed.md)


### Versione Incoming

``` 

---

