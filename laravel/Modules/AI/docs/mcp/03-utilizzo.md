# Utilizzo dei Server MCP per Progetti Laravel

## Panoramica

Questa guida fornisce istruzioni dettagliate per l'utilizzo dei server MCP (Model Context Protocol) in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## Avvio e Gestione dei Server MCP

### Utilizzo dello Script di Gestione

Lo script `mcp-manager-v2.sh` fornisce un'interfaccia completa per la gestione dei server MCP. Ecco come utilizzarlo:

```bash
/path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh [comando] [server]
```

Comandi disponibili:
- `start` - Avvia uno o tutti i server MCP
- `stop` - Ferma uno o tutti i server MCP
- `status` - Mostra lo stato di uno o tutti i server MCP
- `restart` - Riavvia uno o tutti i server MCP
- `logs` - Mostra i log di uno o tutti i server MCP
- `install` - Installa uno o tutti i server MCP

Server disponibili:
- `sequential-thinking` - Server per il pensiero sequenziale
- `memory` - Server per la memorizzazione di informazioni
- `fetch` - Server per le richieste HTTP
- `filesystem` - Server per le operazioni sul filesystem
- `postgres` - Server per database PostgreSQL
- `redis` - Server per Redis
- `puppeteer` - Server per l'automazione del browser
- `mysql` - Server personalizzato per MySQL
- `all` - Tutti i server (default se non specificato)

Esempi:
```bash
# Avvia tutti i server MCP
/path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh start

# Avvia solo il server MySQL
/path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh start mysql

# Verifica lo stato di tutti i server MCP
/path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh status

# Ferma tutti i server MCP
/path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh stop

# Visualizza i log del server sequential-thinking
/path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh logs sequential-thinking
```

### Avvio Automatico all'Avvio del Progetto

Per avviare automaticamente i server MCP all'avvio del progetto, puoi aggiungere uno script nel file `composer.json`:

```json
{
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "/path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh start"
        ]
    }
}
```

Oppure, puoi creare un comando Artisan personalizzato:

```php
<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StartMcpServersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcp:start {server? : The server to start (all if not specified)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start MCP servers';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $server = $this->argument('server') ?? 'all';
        $scriptPath = base_path('bashscripts/mcp/mcp-manager-v2.sh');
        
        $this->info("Starting MCP server(s): {$server}");
        
        $process = new Process([$scriptPath, 'start', $server]);
        $process->setTimeout(null);
        $process->setTty(true);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });
        
        return 0;
    }
}
```

## Utilizzo dei Server MCP in Laravel

### Integrazione con Laravel

Per utilizzare i server MCP in Laravel, è necessario creare un Service Provider e un Service dedicati:

#### Service Provider

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\AI\Services\MCPService;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Xot\Providers\XotBaseServiceProvider;

class MCPServiceProvider extends XotBaseServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(MCPServiceContract::class, function ($app) {
            return new MCPService(
                config('ai.mcp.servers')
            );
        });
        
        $this->app->alias(MCPServiceContract::class, 'mcp');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../Config/mcp.php' => config_path('ai/mcp.php'),
        ], 'config');
    }
}
```

#### Service Contract

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Contracts;

interface MCPServiceContract
{
    /**
     * Ottiene l'istanza del server MCP sequential-thinking.
     *
     * @return SequentialThinkingServerContract
     */
    public function sequentialThinking(): SequentialThinkingServerContract;
    
    /**
     * Ottiene l'istanza del server MCP memory.
     *
     * @return MemoryServerContract
     */
    public function memory(): MemoryServerContract;
    
    /**
     * Ottiene l'istanza del server MCP fetch.
     *
     * @return FetchServerContract
     */
    public function fetch(): FetchServerContract;
    
    /**
     * Ottiene l'istanza del server MCP filesystem.
     *
     * @return FilesystemServerContract
     */
    public function filesystem(): FilesystemServerContract;
    
    /**
     * Ottiene l'istanza del server MCP postgres.
     *
     * @return PostgresServerContract
     */
    public function postgres(): PostgresServerContract;
    
    /**
     * Ottiene l'istanza del server MCP redis.
     *
     * @return RedisServerContract
     */
    public function redis(): RedisServerContract;
    
    /**
     * Ottiene l'istanza del server MCP puppeteer.
     *
     * @return PuppeteerServerContract
     */
    public function puppeteer(): PuppeteerServerContract;
    
    /**
     * Ottiene l'istanza del server MCP mysql.
     *
     * @return MySQLServerContract
     */
    public function mysql(): MySQLServerContract;
}
```

#### Service Implementation

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\AI\Services\Contracts\SequentialThinkingServerContract;
use Modules\AI\Services\Contracts\MemoryServerContract;
use Modules\AI\Services\Contracts\FetchServerContract;
use Modules\AI\Services\Contracts\FilesystemServerContract;
use Modules\AI\Services\Contracts\PostgresServerContract;
use Modules\AI\Services\Contracts\RedisServerContract;
use Modules\AI\Services\Contracts\PuppeteerServerContract;
use Modules\AI\Services\Contracts\MySQLServerContract;
use Modules\AI\Services\Servers\SequentialThinkingServer;
use Modules\AI\Services\Servers\MemoryServer;
use Modules\AI\Services\Servers\FetchServer;
use Modules\AI\Services\Servers\FilesystemServer;
use Modules\AI\Services\Servers\PostgresServer;
use Modules\AI\Services\Servers\RedisServer;
use Modules\AI\Services\Servers\PuppeteerServer;
use Modules\AI\Services\Servers\MySQLServer;

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
        }
        
        return $this->instances['memory'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function fetch(): FetchServerContract
    {
        if (!isset($this->instances['fetch'])) {
            $this->instances['fetch'] = new FetchServer(
                $this->config['fetch'] ?? []
            );
        }
        
        return $this->instances['fetch'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function filesystem(): FilesystemServerContract
    {
        if (!isset($this->instances['filesystem'])) {
            $this->instances['filesystem'] = new FilesystemServer(
                $this->config['filesystem'] ?? []
            );
        }
        
        return $this->instances['filesystem'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function postgres(): PostgresServerContract
    {
        if (!isset($this->instances['postgres'])) {
            $this->instances['postgres'] = new PostgresServer(
                $this->config['postgres'] ?? []
            );
        }
        
        return $this->instances['postgres'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function redis(): RedisServerContract
    {
        if (!isset($this->instances['redis'])) {
            $this->instances['redis'] = new RedisServer(
                $this->config['redis'] ?? []
            );
        }
        
        return $this->instances['redis'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function puppeteer(): PuppeteerServerContract
    {
        if (!isset($this->instances['puppeteer'])) {
            $this->instances['puppeteer'] = new PuppeteerServer(
                $this->config['puppeteer'] ?? []
            );
        }
        
        return $this->instances['puppeteer'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function mysql(): MySQLServerContract
    {
        if (!isset($this->instances['mysql'])) {
            $this->instances['mysql'] = new MySQLServer(
                $this->config['mysql'] ?? []
            );
        }
        
        return $this->instances['mysql'];
    }
}
```

### Utilizzo nei Controller

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\AI\Http\Requests\AnalyzeTextRequest;

class MCPController extends Controller
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }
    
    /**
     * Analizza un testo utilizzando il server MCP sequential-thinking.
     *
     * @param AnalyzeTextRequest $request
     *
     * @return JsonResponse
     */
    public function analyzeText(AnalyzeTextRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $analysis = $this->mcpService->sequentialThinking()->analyze(
            $validated['text'],
            $validated['aspects'] ?? ['readability', 'seo', 'sentiment']
        );
        
        return response()->json([
            'success' => true,
            'data' => $analysis,
        ]);
    }
}
```

### Utilizzo nelle Actions

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Actions;

use Modules\Blog\Models\Post;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Blog\DataObjects\ContentAnalysisData;

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
        
        return new ContentAnalysisData(
            readabilityScore: $analysis['readability']['score'],
            seoScore: $analysis['seo']['score'],
            sentiment: $analysis['sentiment']['value'],
            keywords: $analysis['keywords']
        );
    }
}
```

### Utilizzo nei Command

```php
<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\AI\Services\Contracts\MCPServiceContract;

class AnalyzeDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:analyze {table : The table to analyze}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze a database table using MCP postgres server';

    /**
     * Execute the console command.
     */
    public function handle(MCPServiceContract $mcpService): int
    {
        $table = $this->argument('table');
        
        $this->info("Analyzing table: {$table}");
        
        $analysis = $mcpService->postgres()->analyzeTable($table);
        
        $this->table(
            ['Column', 'Type', 'Nullable', 'Default', 'Index'],
            $analysis['columns']
        );
        
        $this->info("Table size: {$analysis['size']}");
        $this->info("Row count: {$analysis['rowCount']}");
        
        return 0;
    }
}
```

## Esempi di Utilizzo per Server Specifici

### Server Sequential Thinking

```php
$thought = $mcpService->sequentialThinking()->generateThought(
    'Analisi del problema di performance nel database',
    1,
    5,
    true
);
```

### Server Memory

```php
// Memorizza un'informazione
$mcpService->memory()->store(
    'user_preferences_123',
    [
        'theme' => 'dark',
        'language' => 'it',
        'notifications' => true
    ]
);

// Recupera un'informazione
$preferences = $mcpService->memory()->retrieve('user_preferences_123');
```

### Server Fetch

```php
// Effettua una richiesta GET
$response = $mcpService->fetch()->get(
    'https://api.example.com/data',
    [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ]
    ]
);

// Effettua una richiesta POST
$response = $mcpService->fetch()->post(
    'https://api.example.com/data',
    [
        'json' => [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ],
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ]
    ]
);
```

### Server Filesystem

```php
// Legge un file
$content = $mcpService->filesystem()->readFile('/path/to/file.txt');

// Scrive un file
$mcpService->filesystem()->writeFile('/path/to/file.txt', 'Hello, world!');

// Lista i file in una directory
$files = $mcpService->filesystem()->listDirectory('/path/to/directory');
```

### Server MySQL

```php
// Esegue una query SQL
$results = $mcpService->mysql()->executeQuery(
    'SELECT * FROM users WHERE id = ?',
    [1]
);

// Ottiene la struttura di una tabella
$structure = $mcpService->mysql()->getTableStructure('users');

// Ottiene l'elenco delle tabelle
$tables = $mcpService->mysql()->getTables();
```

### Server Postgres

```php
// Esegue una query SQL
$results = $mcpService->postgres()->executeQuery(
    'SELECT * FROM users WHERE id = $1',
    [1]
);

// Analizza una query SQL
$analysis = $mcpService->postgres()->analyzeQuery(
    'SELECT * FROM users WHERE email LIKE $1',
    ['%example.com']
);
```

### Server Redis

```php
// Imposta un valore
$mcpService->redis()->set('key', 'value', 3600);

// Ottiene un valore
$value = $mcpService->redis()->get('key');

// Elimina un valore
$mcpService->redis()->delete('key');
```

### Server Puppeteer

```php
// Cattura uno screenshot di una pagina web
$screenshotPath = $mcpService->puppeteer()->captureScreenshot(
    'https://example.com',
    '/path/to/screenshot.png'
);

// Estrae il contenuto di una pagina web
$content = $mcpService->puppeteer()->extractContent(
    'https://example.com',
    '.main-content'
);
```

## Risoluzione dei Problemi

### Problema: Server MCP non Disponibile

Se un server MCP non è disponibile:

```php
try {
    $result = $mcpService->sequentialThinking()->generateThought(...);
} catch (\Exception $e) {
    Log::error('Server MCP non disponibile: ' . $e->getMessage());
    
    // Fallback
    $result = [
        'thought' => 'Pensiero generato localmente',
        'thoughtNumber' => 1,
        'totalThoughts' => 1,
        'nextThoughtNeeded' => false
    ];
}
```

### Problema: Errori nelle Richieste

Se si verificano errori nelle richieste:

```php
try {
    $response = $mcpService->fetch()->get('https://api.example.com/data');
} catch (\Exception $e) {
    Log::error('Errore nella richiesta: ' . $e->getMessage());
    
    // Retry con backoff esponenziale
    $maxRetries = 3;
    $retryCount = 0;
    $delay = 1;
    
    while ($retryCount < $maxRetries) {
        try {
            sleep($delay);
            $response = $mcpService->fetch()->get('https://api.example.com/data');
            break;
        } catch (\Exception $e) {
            $retryCount++;
            $delay *= 2;
            Log::warning("Retry {$retryCount}/{$maxRetries}: " . $e->getMessage());
        }
    }
}
```

### Problema: Timeout nelle Richieste

Se si verificano timeout nelle richieste:

```php
try {
    // Imposta un timeout di 10 secondi
    $response = $mcpService->fetch()->get('https://api.example.com/data', [
        'timeout' => 10
    ]);
} catch (\Exception $e) {
    Log::error('Timeout nella richiesta: ' . $e->getMessage());
}
```

## Conclusione

Hai imparato come utilizzare i server MCP nel tuo progetto Laravel. Ora puoi procedere con l'integrazione dei server MCP con i moduli Laravel seguendo la guida nella sezione successiva.

---

Continua con la sezione [Integrazione con i Moduli](./04_INTEGRAZIONE_MODULI.md) per imparare come integrare i server MCP con i moduli Laravel.
