# Best Practices per l'Utilizzo dei Server MCP

## Panoramica

Questa guida fornisce le migliori pratiche per l'utilizzo dei server MCP (Model Context Protocol) in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## ⚠️ SICUREZZA DEL DATABASE

### Comandi Pericolosi da Evitare

**MAI** eseguire i seguenti comandi in produzione o in ambienti con dati critici:

```bash
php artisan migrate:fresh       # ELIMINA TUTTE LE TABELLE E I DATI
php artisan migrate:fresh --seed # ELIMINA TUTTO E RICARICA I DATI DI PROVA
php artisan db:wipe             # ELIMINA TUTTE LE TABELLE
```

### Best Practice per le Migrazioni

1. **Sempre** eseguire il backup del database prima di applicare migrazioni
2. Utilizzare `php artisan migrate` per applicare nuove migrazioni in modo sicuro
3. In sviluppo, verificare sempre l'ambiente prima di eseguire comandi distruttivi
4. Utilizzare transazioni per migrazioni complesse
5. Testare sempre le migrazioni in un ambiente di staging prima della produzione

### In Caso di Errore

Se hai eseguito accidentalmente un comando di migrazione pericoloso:
1. **NON CHIUDERE** il terminale
2. Contatta immediatamente il team di sviluppo
3. Se disponibile, ripristina l'ultimo backup

Per ulteriori dettagli, vedi il file `AVVISO_MIGRAZIONI.mdc` nella root del progetto.

---

## Principi Generali

### 1. Struttura Modulare

Seguire la struttura modulare Laravel con separazione chiara delle responsabilità:

- Posizionare ogni integrazione MCP all'interno del modulo appropriato
- Utilizzare i namespace corretti per ogni modulo (`Modules\NomeModulo\...`)
- Seguire le convenzioni di Laravel per la struttura delle cartelle

```
/path/to/your/project/laravel/Modules/AI/
├── Config/
│   └── mcp.php
├── Contracts/
│   └── MCPServiceContract.php
├── Providers/
│   └── MCPServiceProvider.php
├── Services/
│   ├── Contracts/
│   │   ├── SequentialThinkingServerContract.php
│   │   ├── MemoryServerContract.php
│   │   └── ...
│   ├── MCPService.php
│   └── Servers/
│       ├── SequentialThinkingServer.php
│       ├── MemoryServer.php
│       └── ...
└── ...
```

### 2. Standard di Codifica

- Utilizzare `strict_types=1` in tutti i file PHP
- Fornire tipizzazione completa per tutti i metodi e le proprietà
- Documentare le classi e i metodi con DocBlocks completi
- Seguire PSR-1, PSR-2 e PSR-12 per lo stile del codice
- Utilizzare typed properties in PHP 8.0+
- Preferire named arguments per i metodi con molti parametri
- Utilizzare Spatie Data Objects per strutture dati complesse

### 3. Best Practices Architetturali

- NON riferirsi direttamente a `\Modules\User\Models\User`, usare `Modules\Xot\Contracts\UserContract`
- Estendere `XotBaseServiceProvider` per i Service Provider dei moduli
- Utilizzare Actions per la logica di business invece di Service Classes
- Applicare il principio SOLID in tutto il codice
- Preferire l'iniezione delle dipendenze alla creazione diretta di oggetti
- Utilizzare contratti/interfacce per il disaccoppiamento

## Best Practices Specifiche per MCP

### 1. Gestione delle Dipendenze

- Utilizzare l'iniezione delle dipendenze per i servizi MCP
- Configurare i servizi MCP come singleton nel Service Provider
- Utilizzare interfacce per ogni server MCP per facilitare il testing e il mock

```php
// Configurazione nel Service Provider
$this->app->singleton(MCPServiceContract::class, function ($app) {
    return new MCPService(
        config('ai.mcp.servers')
    );
});

// Utilizzo nei controller o nelle actions
public function __construct(
    private readonly MCPServiceContract $mcpService
) {
}
```

### 2. Gestione degli Errori

- Implementare un sistema di gestione degli errori robusto
- Utilizzare try/catch per gestire le eccezioni dei server MCP
- Registrare gli errori nei log con informazioni dettagliate
- Implementare meccanismi di fallback per gestire i server non disponibili

```php
try {
    $result = $mcpService->sequentialThinking()->generateThought(...);
} catch (\Exception $e) {
    Log::error('Server MCP non disponibile', [
        'server' => 'sequential-thinking',
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    // Fallback
    $result = $this->generateLocalThought(...);
}
```

### 3. Caching e Performance

- Implementare meccanismi di cache per ridurre le chiamate ai server MCP
- Utilizzare il server Redis MCP per la gestione della cache
- Impostare timeout appropriati per le richieste ai server MCP
- Utilizzare code per le operazioni asincrone

```php
// Utilizzo della cache
$cacheKey = 'mcp_analysis_' . md5($text);
$cachedResult = Cache::get($cacheKey);

if ($cachedResult !== null) {
    return $cachedResult;
}

$result = $mcpService->sequentialThinking()->analyze($text, $aspects);
Cache::put($cacheKey, $result, now()->addHours(24));

return $result;
```

### 4. Testing

- Scrivere test unitari per ogni integrazione MCP
- Utilizzare mock per i server MCP durante i test
- Testare i meccanismi di fallback e gestione degli errori
- Implementare test di integrazione per verificare la comunicazione con i server MCP

```php
// Test unitario con mock
public function test_analyze_post_content_action()
{
    // Mock del servizio MCP
    $mcpService = $this->mock(MCPServiceContract::class);
    $sequentialThinkingServer = $this->mock(SequentialThinkingServerContract::class);
    $memoryServer = $this->mock(MemoryServerContract::class);
    
    // Configurazione dei mock
    $mcpService->shouldReceive('sequentialThinking')
        ->once()
        ->andReturn($sequentialThinkingServer);
    
    $mcpService->shouldReceive('memory')
        ->once()
        ->andReturn($memoryServer);
    
    $sequentialThinkingServer->shouldReceive('analyze')
        ->once()
        ->with('Test content', ['readability', 'seo', 'sentiment', 'keywords'])
        ->andReturn([
            'readability' => ['score' => 85],
            'seo' => ['score' => 78],
            'sentiment' => ['value' => 'positive'],
            'keywords' => ['test', 'content']
        ]);
    
    $memoryServer->shouldReceive('store')
        ->once()
        ->andReturn(true);
    
    // Creazione del post di test
    $post = Post::factory()->create([
        'content' => 'Test content'
    ]);
    
    // Esecuzione dell'action
    $action = new AnalyzePostContentAction($mcpService);
    $result = $action->execute($post);
    
    // Asserzioni
    $this->assertEquals(85, $result->readabilityScore);
    $this->assertEquals(78, $result->seoScore);
    $this->assertEquals('positive', $result->sentiment);
    $this->assertEquals(['test', 'content'], $result->keywords);
}
```

### 5. Sicurezza

- Non esporre direttamente i server MCP all'esterno
- Implementare meccanismi di autenticazione e autorizzazione
- Validare tutti i dati di input prima di inviarli ai server MCP
- Utilizzare HTTPS per le comunicazioni con i server MCP esterni

```php
// Validazione dell'input
public function analyze(Request $request): JsonResponse
{
    $validated = $request->validate([
        'text' => 'required|string|min:10|max:10000',
        'aspects' => 'required|array|min:1',
        'aspects.*' => 'string|in:readability,seo,sentiment,keywords'
    ]);
    
    $result = $this->mcpService->sequentialThinking()->analyze(
        $validated['text'],
        $validated['aspects']
    );
    
    return response()->json([
        'success' => true,
        'data' => $result
    ]);
}
```

### 6. Logging e Monitoraggio

- Implementare un sistema di logging dettagliato per le interazioni con i server MCP
- Monitorare le prestazioni e la disponibilità dei server MCP
- Configurare alert per errori critici
- Utilizzare strumenti di APM (Application Performance Monitoring)

```php
// Logging dettagliato
Log::debug('MCP Request', [
    'server' => 'sequential-thinking',
    'method' => 'analyze',
    'params' => [
        'text' => substr($text, 0, 100) . '...',
        'aspects' => $aspects
    ],
    'timestamp' => now()->toIso8601String()
]);

$startTime = microtime(true);
$result = $mcpService->sequentialThinking()->analyze($text, $aspects);
$duration = microtime(true) - $startTime;

Log::debug('MCP Response', [
    'server' => 'sequential-thinking',
    'method' => 'analyze',
    'duration' => $duration,
    'status' => 'success',
    'timestamp' => now()->toIso8601String()
]);
```

### 7. Configurazione

- Utilizzare file di configurazione dedicati per i server MCP
- Configurare i timeout e altri parametri in base alle esigenze
- Utilizzare variabili di ambiente per le configurazioni sensibili
- Documentare tutte le opzioni di configurazione

```php
// config/ai/mcp.php
return [
    'servers' => [
        'sequential-thinking' => [
            'enabled' => env('MCP_SEQUENTIAL_THINKING_ENABLED', true),
            'timeout' => env('MCP_SEQUENTIAL_THINKING_TIMEOUT', 30),
            'url' => env('MCP_SEQUENTIAL_THINKING_URL', 'http://localhost:3000/api/v1')
        ],
        'memory' => [
            'enabled' => env('MCP_MEMORY_ENABLED', true),
            'timeout' => env('MCP_MEMORY_TIMEOUT', 30),
            'url' => env('MCP_MEMORY_URL', 'http://localhost:3001/api/v1')
        ],
        // Altri server...
    ]
];
```

### 8. Documentazione

- Documentare tutte le integrazioni MCP
- Fornire esempi di utilizzo per ogni server MCP
- Documentare le API e i parametri
- Mantenere aggiornata la documentazione

```php
/**
 * Analizza un testo utilizzando il server MCP sequential-thinking.
 *
 * @param string $text Il testo da analizzare
 * @param array<string> $aspects Gli aspetti da analizzare (readability, seo, sentiment, keywords)
 *
 * @return array<string, mixed> I risultati dell'analisi
 *
 * @throws \Exception Se il server MCP non è disponibile o restituisce un errore
 *
 * @example
 * ```php
 * $analysis = $mcpService->sequentialThinking()->analyze(
 *     'Questo è un testo di esempio',
 *     ['readability', 'seo']
 * );
 * ```
 */
public function analyze(string $text, array $aspects): array
{
    // Implementazione...
}
```

## Esempi di Best Practices

### Esempio 1: Implementazione di un Service MCP

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\AI\Services\Contracts\SequentialThinkingServerContract;
use Modules\AI\Services\Contracts\MemoryServerContract;
use Modules\AI\Services\Servers\SequentialThinkingServer;
use Modules\AI\Services\Servers\MemoryServer;
use Illuminate\Support\Facades\Log;

class MCPService implements MCPServiceContract
{
    /**
     * @var array<string, mixed>
     */
    private array $config;
    
    /**
     * @var array<string, object>
     */
    private array $instances = [];
    
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        Log::debug('MCPService initialized', ['servers' => array_keys($config)]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function sequentialThinking(): SequentialThinkingServerContract
    {
        if (!isset($this->instances['sequential-thinking'])) {
            $this->instances['sequential-thinking'] = new SequentialThinkingServer(
                $this->config['sequential-thinking'] ?? []
            );
            Log::debug('SequentialThinkingServer initialized');
        }
        
        return $this->instances['sequential-thinking'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function memory(): MemoryServerContract
    {
        if (!isset($this->instances['memory'])) {
            $this->instances['memory'] = new MemoryServer(
                $this->config['memory'] ?? []
            );
            Log::debug('MemoryServer initialized');
        }
        
        return $this->instances['memory'];
    }
    
    // Altri metodi per gli altri server...
}
```

### Esempio 2: Utilizzo di Data Objects

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\DataObjects;

use Spatie\LaravelData\Data;

class ContentAnalysisData extends Data
{
    /**
     * @param int $readabilityScore Punteggio di leggibilità (0-100)
     * @param int $seoScore Punteggio SEO (0-100)
     * @param string $sentiment Sentimento del testo (positive, negative, neutral)
     * @param array<string> $keywords Parole chiave estratte dal testo
     */
    public function __construct(
        public readonly int $readabilityScore,
        public readonly int $seoScore,
        public readonly string $sentiment,
        public readonly array $keywords
    ) {
    }
    
    /**
     * Crea un'istanza da un array di analisi.
     *
     * @param array<string, mixed> $analysis
     *
     * @return self
     */
    public static function fromAnalysis(array $analysis): self
    {
        return new self(
            readabilityScore: $analysis['readability']['score'] ?? 0,
            seoScore: $analysis['seo']['score'] ?? 0,
            sentiment: $analysis['sentiment']['value'] ?? 'neutral',
            keywords: $analysis['keywords'] ?? []
        );
    }
}
```

### Esempio 3: Utilizzo di Actions

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Actions;

use Modules\Blog\Models\Post;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Blog\DataObjects\ContentAnalysisData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AnalyzePostContentAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Analizza il contenuto di un post utilizzando sequential-thinking.
     *
     * @param Post $post Il post da analizzare
     *
     * @return ContentAnalysisData I dati dell'analisi
     */
    public function execute(Post $post): ContentAnalysisData
    {
        $cacheKey = "post_analysis_{$post->id}";
        
        // Verifica se l'analisi è già in cache
        $cachedAnalysis = Cache::get($cacheKey);
        if ($cachedAnalysis !== null) {
            Log::info('Using cached analysis', ['post_id' => $post->id]);
            return ContentAnalysisData::from($cachedAnalysis);
        }
        
        try {
            Log::info('Analyzing post content', [
                'post_id' => $post->id,
                'title' => $post->title,
                'content_length' => strlen($post->content)
            ]);
            
            $analysis = $this->mcpService->sequentialThinking()->analyze(
                $post->content,
                [
                    'readability',
                    'seo',
                    'sentiment',
                    'keywords'
                ]
            );
            
            // Memorizza l'analisi per riferimento futuro
            $this->mcpService->memory()->store(
                "post_analysis_{$post->id}",
                $analysis
            );
            
            // Memorizza l'analisi in cache
            Cache::put($cacheKey, $analysis, now()->addDay());
            
            Log::info('Post analysis completed', [
                'post_id' => $post->id,
                'readability_score' => $analysis['readability']['score'] ?? 0,
                'seo_score' => $analysis['seo']['score'] ?? 0
            ]);
            
            return ContentAnalysisData::fromAnalysis($analysis);
        } catch (\Exception $e) {
            Log::error('Error analyzing post content', [
                'post_id' => $post->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback: analisi locale semplice
            return new ContentAnalysisData(
                readabilityScore: $this->calculateReadabilityScore($post->content),
                seoScore: $this->calculateSeoScore($post->content, $post->title),
                sentiment: $this->analyzeSentiment($post->content),
                keywords: $this->extractKeywords($post->content)
            );
        }
    }
    
    /**
     * Calcola un punteggio di leggibilità semplice.
     *
     * @param string $text
     *
     * @return int
     */
    private function calculateReadabilityScore(string $text): int
    {
        // Implementazione semplice...
        return 70;
    }
    
    /**
     * Calcola un punteggio SEO semplice.
     *
     * @param string $content
     * @param string $title
     *
     * @return int
     */
    private function calculateSeoScore(string $content, string $title): int
    {
        // Implementazione semplice...
        return 65;
    }
    
    /**
     * Analizza il sentimento del testo.
     *
     * @param string $text
     *
     * @return string
     */
    private function analyzeSentiment(string $text): string
    {
        // Implementazione semplice...
        return 'neutral';
    }
    
    /**
     * Estrae le parole chiave dal testo.
     *
     * @param string $text
     *
     * @return array<string>
     */
    private function extractKeywords(string $text): array
    {
        // Implementazione semplice...
        return ['content', 'blog'];
    }
}
```

## Conclusione

Seguendo queste best practices, è possibile creare integrazioni robuste e manutenibili con i server MCP nei progetti Laravel. Queste pratiche garantiscono che il codice sia tipizzato, testabile e conforme alle regole di sviluppo stabilite per i progetti base_predict_fila5_mono.

Per ulteriori informazioni e supporto, consultare la documentazione ufficiale dei server MCP o contattare il team di sviluppo.
