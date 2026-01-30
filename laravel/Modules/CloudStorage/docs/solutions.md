# Soluzioni Tecniche - Modulo CloudStorage

## Documentazione collegata
- [README](README.md)

## Problemi Identificati e Soluzioni

### 1. Gestione Upload File (`Modules/CloudStorage/Actions/UploadFileAction.php`)
```php
// Problema: Upload file non ottimizzato
public function execute(UploadedFile $file) {
    // Upload sincrono dei file
}

// Soluzione proposta:
class UploadFileAction {
    public function execute(UploadedFile $file): void {
        $this->validateFile($file);
        
        match ($this->determineUploadStrategy($file)) {
            'direct' => $this->handleDirectUpload($file),
            'chunked' => $this->handleChunkedUpload($file),
            'multipart' => $this->handleMultipartUpload($file)
        };
    }
    
    private function handleDirectUpload(UploadedFile $file): void {
        dispatch(new ProcessDirectUpload($file))
            ->onQueue('uploads')
            ->allOnConnection('redis');
    }
    
    private function handleChunkedUpload(UploadedFile $file): void {
        $chunks = $this->splitFileIntoChunks($file);
        
        collect($chunks)->each(function($chunk) {
            dispatch(new ProcessChunkUpload($chunk))
                ->onQueue('uploads')
                ->delay(now()->addSeconds(5));
        });
    }
    
    private function handleMultipartUpload(UploadedFile $file): void {
        dispatch(new InitiateMultipartUpload($file))
            ->onQueue('uploads')
            ->chain([
                new ProcessMultipartUpload($file),
                new CompleteMultipartUpload($file)
            ]);
    }
}
```

### 2. Cache Management (`Modules/CloudStorage/Services/StorageCacheService.php`)
```php
// Problema: Gestione cache non efficiente
public function cacheFile($file) {
    // Cache base dei file
}

// Soluzione proposta:
class StorageCacheService {
    private $cache;
    private $config;
    
    public function cacheFileMetadata(File $file): void {
        $key = "file_metadata_{$file->id}";
        
        $this->cache->tags(['files', "user_{$file->user_id}"])
            ->put($key, [
                'name' => $file->name,
                'size' => $file->size,
                'mime_type' => $file->mime_type,
                'last_modified' => $file->updated_at,
                'storage_path' => $file->storage_path
            ], $this->config->get('cache.ttl.file_metadata'));
    }
    
    public function getCachedFileMetadata(string $fileId): ?array {
        return $this->cache->tags(['files'])
            ->remember("file_metadata_{$fileId}", 
                $this->config->get('cache.ttl.file_metadata'),
                fn() => $this->fetchFileMetadata($fileId)
            );
    }
    
    public function invalidateFileCache(File $file): void {
        $this->cache->tags([
            'files',
            "user_{$file->user_id}",
            "folder_{$file->folder_id}"
        ])->flush();
    }
}
```

### 3. Storage Provider Integration (`Modules/CloudStorage/Services/StorageProviderService.php`)
```php
// Problema: Integrazione provider storage non ottimizzata
public function storeFile($file, $provider) {
    // Storage base dei file
}

// Soluzione proposta:
class StorageProviderService {
    private $providers;
    private $logger;
    
    public function storeFile(File $file, string $provider): void {
        $storageProvider = $this->getProvider($provider);
        
        try {
            $result = $storageProvider->store($file, [
                'acl' => 'private',
                'encryption' => 'AES256',
                'storage_class' => $this->determineStorageClass($file)
            ]);
            
            $this->updateFileMetadata($file, $result);
            $this->logStorageSuccess($file, $provider);
            
        } catch (StorageException $e) {
            $this->handleStorageFailure($file, $e);
            throw $e;
        }
    }
    
    private function determineStorageClass(File $file): string {
        return match (true) {
            $file->size > config('storage.large_file_threshold') => 'STANDARD_IA',
            $file->is_temporary => 'ONEZONE_IA',
            default => 'STANDARD'
        };
    }
    
    private function handleStorageFailure(File $file, StorageException $e): void {
        $this->logger->error('File storage failed', [
            'file_id' => $file->id,
            'error' => $e->getMessage(),
            'provider' => $file->storage_provider
        ]);
        
        event(new FileStorageFailed($file, $e));
    }
}
```

## Ottimizzazioni Database

### 1. Indici e Struttura
```sql
-- In: database/migrations/optimize_storage_tables.php
CREATE INDEX files_user_folder_idx ON files (user_id, folder_id, created_at);
CREATE INDEX file_chunks_file_idx ON file_chunks (file_id, sequence);
CREATE INDEX storage_events_file_idx ON storage_events (file_id, event_type, created_at);
```

### 2. Query Optimization
```php
// In: Modules/CloudStorage/Models/File.php
class File extends Model {
    public function scopeUserFiles($query, $userId) {
        return $query->where('user_id', $userId)
                    ->where('status', 'active')
                    ->orderBy('updated_at', 'desc');
    }
    
    public function scopeRecentUploads($query) {
        return $query->where('created_at', '>=', now()->subDays(7))
                    ->with(['folder', 'user'])
                    ->orderBy('created_at', 'desc');
    }
}
```

## Cache Strategy

### 1. Cache Configuration
```php
// In: Modules/CloudStorage/Config/cache.php
return [
    'ttl' => [
        'file_metadata' => 3600,    // 1 hour
        'folder_list' => 1800,      // 30 minutes
        'user_quota' => 300         // 5 minutes
    ],
    'tags' => [
        'files',
        'folders',
        'quotas'
    ]
];
```

### 2. Cache Implementation
```php
// In: Modules/CloudStorage/Services/QuotaCacheService.php
class QuotaCacheService {
    public function getUserQuota(string $userId): array {
        return Cache::tags(['quotas', "user_{$userId}"])
            ->remember("quota_{$userId}", 
                config('storage.cache.ttl.user_quota'),
                fn() => $this->calculateUserQuota($userId)
            );
    }
    
    public function updateQuotaCache(string $userId): void {
        Cache::tags(['quotas', "user_{$userId}"])->flush();
    }
}
```

## Rate Limiting

### 1. Upload Rate Limits
```php
// In: Modules/CloudStorage/Services/UploadRateLimitService.php
class UploadRateLimitService {
    public function canUpload(User $user): bool {
        $key = "uploads:{$user->id}:rate";
        
        return Redis::throttle($key)
            ->allow(config('storage.limits.uploads_per_minute'))
            ->every(60)
            ->then(
                fn() => true,
                fn() => false
            );
    }
    
    public function trackUpload(User $user): void {
        Redis::incr("uploads:{$user->id}:count");
        Redis::expire("uploads:{$user->id}:count", 3600);
    }
}
```

## Monitoring

### 1. Storage Monitoring
```php
// In: Modules/CloudStorage/Monitoring/StorageMonitor.php
class StorageMonitor {
    public function trackStorageMetrics(): void {
        collect(config('storage.providers'))->each(function($provider) {
            $metrics = $this->getProviderMetrics($provider);
            
            Metrics::gauge("storage.usage", $metrics['usage'], [
                'provider' => $provider
            ]);
            
            Metrics::gauge("storage.available", $metrics['available'], [
                'provider' => $provider
            ]);
            
            if ($metrics['usage_percent'] > config('storage.thresholds.usage')) {
                Log::warning("Storage usage threshold exceeded", [
                    'provider' => $provider,
                    'usage_percent' => $metrics['usage_percent']
                ]);
            }
        });
    }
}
```

### 2. Upload Health Check
```php
// In: Modules/CloudStorage/Health/UploadHealthCheck.php
class UploadHealthCheck extends Check {
    public function run(): Result {
        $failedUploads = File::where('status', 'failed')
            ->where('created_at', '>=', now()->subHour())
            ->count();
            
        $pendingUploads = File::where('status', 'pending')
            ->where('created_at', '<=', now()->subHours(2))
            ->count();
            
        if ($failedUploads > config('storage.thresholds.failed_uploads')) {
            return Result::failed("High number of failed uploads: {$failedUploads}");
        }
        
        if ($pendingUploads > 0) {
            return Result::failed("Found {$pendingUploads} stuck uploads");
        }
        
        return Result::ok();
    }
}
```

## Testing

### 1. Upload Tests
```php
// In: Modules/CloudStorage/Tests/Unit/UploadTest.php
class UploadTest extends TestCase {
    public function test_direct_upload() {
        Storage::fake('s3');
        
        $file = UploadedFile::fake()->create('document.pdf', 100);
        
        $result = app(UploadFileAction::class)->execute($file);
        
        Storage::disk('s3')->assertExists($result->path);
    }
}
```

### 2. Quota Tests
```php
// In: Modules/CloudStorage/Tests/Feature/QuotaTest.php
class QuotaTest extends TestCase {
    public function test_quota_limit() {
        $user = User::factory()->create([
            'storage_quota' => 1000 // 1GB
        ]);
        
        $service = app(QuotaCacheService::class);
        
        // Test quota before upload
        $quotaBefore = $service->getUserQuota($user->id);
        
        // Upload file
        $file = File::factory()->create([
            'user_id' => $user->id,
            'size' => 500 // 500MB
        ]);
        
        // Test quota after upload
        $quotaAfter = $service->getUserQuota($user->id);
        
        $this->assertEquals(
            $quotaBefore['available'] - 500,
            $quotaAfter['available']
        );
    }
}
```

## Note di Implementazione

1. Priorità di Intervento:
   - Ottimizzazione upload file
   - Implementazione caching avanzato
   - Miglioramento gestione provider
   - Implementazione monitoraggio

2. Monitoraggio:
   - Tracciamento metriche storage
   - Monitoraggio upload falliti
   - Analisi performance
   - Alerting automatico

3. Manutenzione:
   - Pulizia file temporanei
   - Ottimizzazione indici
   - Review configurazioni
   - Aggiornamento provider 