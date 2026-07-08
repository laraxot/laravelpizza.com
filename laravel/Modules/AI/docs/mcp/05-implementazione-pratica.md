# Implementazione Pratica dei Server MCP

## Panoramica

Questa guida fornisce esempi pratici di implementazione dei server MCP (Model Context Protocol) in progetti Laravel, con particolare attenzione all'integrazione con i moduli esistenti e alle best practices di sviluppo.

## Caso d'Uso 1: Analisi del Contenuto con Sequential Thinking

### Implementazione del Service

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\SequentialThinkingServerContract;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SequentialThinkingServer implements SequentialThinkingServerContract
{
    /**
     * @var array<string, mixed>
     */
    private array $config;
    
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * {@inheritdoc}
     */
    public function generateThought(
        string $thought,
        int $thoughtNumber,
        int $totalThoughts,
        bool $nextThoughtNeeded
    ): array {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->post('http://localhost:3000/api/v1/sequential-thinking', [
                    'thought' => $thought,
                    'thoughtNumber' => $thoughtNumber,
                    'totalThoughts' => $totalThoughts,
                    'nextThoughtNeeded' => $nextThoughtNeeded
                ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Sequential Thinking Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [
                'thought' => $thought,
                'thoughtNumber' => $thoughtNumber,
                'totalThoughts' => $totalThoughts,
                'nextThoughtNeeded' => $nextThoughtNeeded,
                'error' => 'Failed to generate thought'
            ];
        } catch (\Exception $e) {
            Log::error('Sequential Thinking Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'thought' => $thought,
                'thoughtNumber' => $thoughtNumber,
                'totalThoughts' => $totalThoughts,
                'nextThoughtNeeded' => $nextThoughtNeeded,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function analyze(string $text, array $aspects): array {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->post('http://localhost:3000/api/v1/analyze', [
                    'text' => $text,
                    'aspects' => $aspects
                ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Sequential Thinking Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [
                'error' => 'Failed to analyze text'
            ];
        } catch (\Exception $e) {
            Log::error('Sequential Thinking Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
```

### Utilizzo nel Controller

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Blog\Models\Post;
use Modules\Blog\Actions\AnalyzePostContentAction;

class PostAnalysisController extends Controller
{
    /**
     * @param MCPServiceContract $mcpService
     * @param AnalyzePostContentAction $analyzePostContentAction
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService,
        private readonly AnalyzePostContentAction $analyzePostContentAction
    ) {
    }
    
    /**
     * Analizza il contenuto di un post.
     *
     * @param Request $request
     * @param int $postId
     *
     * @return JsonResponse
     */
    public function analyze(Request $request, int $postId): JsonResponse
    {
        $post = Post::findOrFail($postId);
        
        $analysis = $this->analyzePostContentAction->execute($post);
        
        return response()->json([
            'success' => true,
            'data' => $analysis
        ]);
    }
}
```

## Caso d'Uso 2: Gestione della Cache con Redis

### Implementazione del Service

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\RedisServerContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RedisServer implements RedisServerContract
{
    /**
     * @var array<string, mixed>
     */
    private array $config;
    
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * {@inheritdoc}
     */
    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->post('http://localhost:3004/api/v1/set', [
                    'key' => $key,
                    'value' => $value,
                    'ttl' => $ttl
                ]);
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Redis Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function get(string $key): mixed
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->get('http://localhost:3004/api/v1/get', [
                    'key' => $key
                ]);
            
            if ($response->successful()) {
                return $response->json('value');
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Redis Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return null;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function delete(string $key): bool
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->delete('http://localhost:3004/api/v1/delete', [
                    'key' => $key
                ]);
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Redis Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }
}
```

### Utilizzo nel Middleware

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\AI\Services\Contracts\MCPServiceContract;

class CacheResponseMiddleware
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }
    
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param int $ttl
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $ttl = 3600): mixed
    {
        $cacheKey = 'response_cache_' . md5($request->fullUrl());
        
        // Verifica se la risposta è già in cache
        $cachedResponse = $this->mcpService->redis()->get($cacheKey);
        
        if ($cachedResponse !== null) {
            return response()->json($cachedResponse);
        }
        
        $response = $next($request);
        
        // Memorizza la risposta in cache
        if ($response->status() === 200) {
            $responseData = $response->getData(true);
            $this->mcpService->redis()->set($cacheKey, $responseData, $ttl);
        }
        
        return $response;
    }
}
```

## Caso d'Uso 3: Interazione con Database MySQL

### Implementazione del Service

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\MySQLServerContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MySQLServer implements MySQLServerContract
{
    /**
     * @var array<string, mixed>
     */
    private array $config;
    
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * {@inheritdoc}
     */
    public function executeQuery(string $query, array $params = []): array
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->post('http://localhost:3007/api/v1/query', [
                    'query' => $query,
                    'params' => $params
                ]);
            
            if ($response->successful()) {
                return $response->json('results', []);
            }
            
            Log::error('MySQL Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [];
        } catch (\Exception $e) {
            Log::error('MySQL Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [];
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTableStructure(string $table): array
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->get('http://localhost:3007/api/v1/table-structure', [
                    'table' => $table
                ]);
            
            if ($response->successful()) {
                return $response->json('structure', []);
            }
            
            Log::error('MySQL Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [];
        } catch (\Exception $e) {
            Log::error('MySQL Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [];
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTables(): array
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->get('http://localhost:3007/api/v1/tables');
            
            if ($response->successful()) {
                return $response->json('tables', []);
            }
            
            Log::error('MySQL Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [];
        } catch (\Exception $e) {
            Log::error('MySQL Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [];
        }
    }
}
```

### Utilizzo nel Repository

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Repositories;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Blog\Models\Post;
use Modules\Blog\DataObjects\PostData;
use Illuminate\Support\Collection;

class PostRepository
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }
    
    /**
     * Ottiene tutti i post con le relative categorie.
     *
     * @return Collection<int, PostData>
     */
    public function getAllWithCategories(): Collection
    {
        $results = $this->mcpService->mysql()->executeQuery(
            'SELECT p.*, GROUP_CONCAT(c.name) as categories
             FROM posts p
             LEFT JOIN post_category pc ON p.id = pc.post_id
             LEFT JOIN categories c ON pc.category_id = c.id
             GROUP BY p.id'
        );
        
        return collect($results)->map(function (array $post) {
            return new PostData(
                id: $post['id'],
                title: $post['title'],
                content: $post['content'],
                categories: explode(',', $post['categories'] ?? ''),
                createdAt: $post['created_at'],
                updatedAt: $post['updated_at']
            );
        });
    }
    
    /**
     * Trova i post più popolari.
     *
     * @param int $limit
     *
     * @return Collection<int, PostData>
     */
    public function findMostPopular(int $limit = 10): Collection
    {
        $results = $this->mcpService->mysql()->executeQuery(
            'SELECT p.*, COUNT(v.id) as views
             FROM posts p
             LEFT JOIN post_views v ON p.id = v.post_id
             GROUP BY p.id
             ORDER BY views DESC
             LIMIT ?',
            [$limit]
        );
        
        return collect($results)->map(function (array $post) {
            return new PostData(
                id: $post['id'],
                title: $post['title'],
                content: $post['content'],
                categories: [],
                createdAt: $post['created_at'],
                updatedAt: $post['updated_at'],
                views: $post['views']
            );
        });
    }
}
```

## Caso d'Uso 4: Automazione del Browser con Puppeteer

### Implementazione del Service

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\PuppeteerServerContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PuppeteerServer implements PuppeteerServerContract
{
    /**
     * @var array<string, mixed>
     */
    private array $config;
    
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * {@inheritdoc}
     */
    public function captureScreenshot(string $url, string $outputPath): string
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 60)
                ->post('http://localhost:3006/api/v1/screenshot', [
                    'url' => $url,
                    'outputPath' => $outputPath
                ]);
            
            if ($response->successful()) {
                return $response->json('screenshotPath', '');
            }
            
            Log::error('Puppeteer Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return '';
        } catch (\Exception $e) {
            Log::error('Puppeteer Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return '';
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function extractContent(string $url, string $selector): string
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 60)
                ->post('http://localhost:3006/api/v1/extract', [
                    'url' => $url,
                    'selector' => $selector
                ]);
            
            if ($response->successful()) {
                return $response->json('content', '');
            }
            
            Log::error('Puppeteer Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return '';
        } catch (\Exception $e) {
            Log::error('Puppeteer Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return '';
        }
    }
}
```

### Utilizzo nel Command

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Console\Commands;

use Illuminate\Console\Command;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\File;

class GenerateScreenshotsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ui:screenshots {--route=* : Routes to capture}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate screenshots of UI routes';

    /**
     * Execute the console command.
     */
    public function handle(MCPServiceContract $mcpService): int
    {
        $routes = $this->option('route');
        
        if (empty($routes)) {
            $routes = ['home', 'blog.index', 'contact'];
        }
        
        $outputDir = storage_path('app/screenshots');
        
        if (!File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }
        
        $this->info("Generating screenshots for " . count($routes) . " routes...");
        
        $bar = $this->output->createProgressBar(count($routes));
        $bar->start();
        
        $results = [];
        
        foreach ($routes as $route) {
            $url = route($route);
            $outputPath = $outputDir . '/' . str_replace('.', '_', $route) . '.png';
            
            $this->info("Capturing {$url}...");
            
            $screenshotPath = $mcpService->puppeteer()->captureScreenshot($url, $outputPath);
            
            if ($screenshotPath) {
                $results[$route] = $screenshotPath;
                $this->info("Screenshot saved to {$screenshotPath}");
            } else {
                $this->error("Failed to capture screenshot for {$route}");
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("Screenshots generated:");
        $this->table(['Route', 'Path'], collect($results)->map(function ($path, $route) {
            return [$route, $path];
        })->toArray());
        
        return 0;
    }
}
```

## Caso d'Uso 5: Gestione del Filesystem

### Implementazione del Service

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\FilesystemServerContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FilesystemServer implements FilesystemServerContract
{
    /**
     * @var array<string, mixed>
     */
    private array $config;
    
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * {@inheritdoc}
     */
    public function readFile(string $path): string
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->get('http://localhost:3003/api/v1/read', [
                    'path' => $path
                ]);
            
            if ($response->successful()) {
                return $response->json('content', '');
            }
            
            Log::error('Filesystem Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return '';
        } catch (\Exception $e) {
            Log::error('Filesystem Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return '';
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function writeFile(string $path, string $content): bool
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->post('http://localhost:3003/api/v1/write', [
                    'path' => $path,
                    'content' => $content
                ]);
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Filesystem Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function listDirectory(string $path): array
    {
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->get('http://localhost:3003/api/v1/list', [
                    'path' => $path
                ]);
            
            if ($response->successful()) {
                return $response->json('files', []);
            }
            
            Log::error('Filesystem Server Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return [];
        } catch (\Exception $e) {
            Log::error('Filesystem Server Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [];
        }
    }
}
```

### Utilizzo nel Service

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Str;

class BackupService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }
    
    /**
     * Crea un backup dei post.
     *
     * @return string Il percorso del file di backup
     */
    public function createPostsBackup(): string
    {
        $posts = $this->mcpService->mysql()->executeQuery('SELECT * FROM posts');
        
        $backupContent = json_encode($posts, JSON_PRETTY_PRINT);
        
        $backupDir = storage_path('app/backups');
        $backupFile = $backupDir . '/posts_' . date('Y-m-d_H-i-s') . '.json';
        
        // Verifica se la directory esiste
        $directories = $this->mcpService->filesystem()->listDirectory(storage_path('app'));
        
        if (!in_array('backups', array_column($directories, 'name'))) {
            // Crea la directory di backup
            $this->mcpService->filesystem()->writeFile($backupDir . '/.gitkeep', '');
        }
        
        // Scrive il file di backup
        $this->mcpService->filesystem()->writeFile($backupFile, $backupContent);
        
        return $backupFile;
    }
    
    /**
     * Ripristina un backup dei post.
     *
     * @param string $backupFile Il percorso del file di backup
     *
     * @return bool True se il ripristino è riuscito, false altrimenti
     */
    public function restorePostsBackup(string $backupFile): bool
    {
        $backupContent = $this->mcpService->filesystem()->readFile($backupFile);
        
        if (empty($backupContent)) {
            return false;
        }
        
        $posts = json_decode($backupContent, true);
        
        if (!is_array($posts)) {
            return false;
        }
        
        // Elimina tutti i post esistenti
        $this->mcpService->mysql()->executeQuery('DELETE FROM posts');
        
        // Inserisce i post dal backup
        foreach ($posts as $post) {
            $columns = implode(', ', array_keys($post));
            $placeholders = implode(', ', array_fill(0, count($post), '?'));
            
            $this->mcpService->mysql()->executeQuery(
                "INSERT INTO posts ({$columns}) VALUES ({$placeholders})",
                array_values($post)
            );
        }
        
        return true;
    }
}
```

## Conclusione

Questa guida ha fornito esempi pratici di implementazione dei server MCP in progetti Laravel. Seguendo queste linee guida, è possibile integrare facilmente i server MCP nei propri progetti, estendendo le funzionalità delle applicazioni Laravel con capacità avanzate di analisi, memorizzazione e interazione con sistemi esterni.

Per ulteriori informazioni e supporto, consultare la documentazione ufficiale dei server MCP o contattare il team di sviluppo.
