# Sicurezza dei Server MCP

## Panoramica

Questa guida fornisce le migliori pratiche di sicurezza per l'utilizzo dei server MCP (Model Context Protocol) in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## Gestione delle Credenziali

### Utilizzo del File .env

Le credenziali e le informazioni sensibili devono essere sempre memorizzate nel file `.env` e mai hardcoded nei file di configurazione o nel codice:

```php
// Configurazione corretta
$config = [
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', 3306),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', '')
];

// Configurazione errata - NON FARE QUESTO
$config = [
    'host' => '127.0.0.1',
    'port' => 3306,
    'database' => 'my_database',
    'username' => 'admin',
    'password' => 'password123'
];
```

### Caricamento delle Variabili di Ambiente

Per i server MCP che necessitano di accedere alle variabili di ambiente, utilizzare il pacchetto `dotenv`:

```javascript
// mysql-db-connector.js
const fs = require('fs');
const path = require('path');
const dotenv = require('dotenv');

// Percorso del file .env di Laravel
const ENV_FILE = path.join(process.env.LARAVEL_DIR || '/var/www/html/laravel', '.env');

// Carica le variabili di ambiente dal file .env
if (fs.existsSync(ENV_FILE)) {
    const envConfig = dotenv.parse(fs.readFileSync(ENV_FILE));
    for (const key in envConfig) {
        process.env[key] = envConfig[key];
    }
}

// Utilizza le variabili di ambiente
const config = {
    host: process.env.DB_HOST || '127.0.0.1',
    port: parseInt(process.env.DB_PORT || '3306'),
    database: process.env.DB_DATABASE,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD
};
```

## Protezione dei Dati

### Validazione dell'Input

Validare sempre l'input prima di inviarlo ai server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\AI\Services\Contracts\MCPServiceContract;

class SequentialThinkingController extends Controller
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
     * @param Request $request
     *
     * @return JsonResponse
     */
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
}
```

### Sanitizzazione dell'Output

Sanitizzare sempre l'output restituito dai server MCP prima di utilizzarlo:

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Actions;

use Modules\Blog\Models\Post;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Blog\DataObjects\ContentAnalysisData;
use Illuminate\Support\Str;

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
        
        // Sanitizzazione dell'output
        $readabilityScore = isset($analysis['readability']['score']) ? 
            max(0, min(100, (int) $analysis['readability']['score'])) : 0;
        
        $seoScore = isset($analysis['seo']['score']) ? 
            max(0, min(100, (int) $analysis['seo']['score'])) : 0;
        
        $sentiment = isset($analysis['sentiment']['value']) ? 
            Str::lower(trim($analysis['sentiment']['value'])) : 'neutral';
        
        $keywords = isset($analysis['keywords']) && is_array($analysis['keywords']) ? 
            array_map(fn($k) => Str::lower(trim($k)), $analysis['keywords']) : [];
        
        return new ContentAnalysisData(
            readabilityScore: $readabilityScore,
            seoScore: $seoScore,
            sentiment: $sentiment,
            keywords: $keywords
        );
    }
}
```

## Autenticazione e Autorizzazione

### Protezione degli Endpoint MCP

Proteggere gli endpoint che utilizzano i server MCP con middleware di autenticazione e autorizzazione:

```php
// routes/api.php
Route::middleware(['auth:sanctum', 'can:use-mcp-services'])->prefix('api/mcp')->group(function () {
    Route::post('analyze', [SequentialThinkingController::class, 'analyze']);
    Route::post('store', [MemoryController::class, 'store']);
    Route::get('retrieve/{key}', [MemoryController::class, 'retrieve']);
    Route::delete('delete/{key}', [MemoryController::class, 'delete']);
});
```

### Definizione delle Policy

Definire policy per controllare l'accesso ai server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Policies;

use Modules\Xot\Contracts\UserContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class MCPServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determina se l'utente può utilizzare i servizi MCP.
     *
     * @param UserContract $user
     *
     * @return bool
     */
    public function useMcpServices(UserContract $user): bool
    {
        // Verifica se l'utente ha il ruolo o il permesso necessario
        return $user->hasRole('admin') || $user->hasPermission('use-mcp-services');
    }
    
    /**
     * Determina se l'utente può utilizzare il server sequential-thinking.
     *
     * @param UserContract $user
     *
     * @return bool
     */
    public function useSequentialThinking(UserContract $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('use-sequential-thinking');
    }
    
    // Altri metodi per gli altri server...
}
```

## Protezione delle Comunicazioni

### Utilizzo di HTTPS

Assicurarsi che tutte le comunicazioni con i server MCP esterni utilizzino HTTPS:

```php
// config/ai/mcp.php
return [
    'servers' => [
        'external-sequential-thinking' => [
            'url' => 'https://api.example.com/sequential-thinking',
            'api_key' => env('EXTERNAL_SEQUENTIAL_THINKING_API_KEY')
        ]
    ]
];
```

### Configurazione del Proxy

Se necessario, configurare un proxy per le comunicazioni con i server MCP esterni:

```php
// config/ai/mcp.php
return [
    'proxy' => [
        'enabled' => env('MCP_PROXY_ENABLED', false),
        'host' => env('MCP_PROXY_HOST'),
        'port' => env('MCP_PROXY_PORT'),
        'username' => env('MCP_PROXY_USERNAME'),
        'password' => env('MCP_PROXY_PASSWORD')
    ]
];

// Utilizzo nel servizio
$options = [];
if ($this->config['proxy']['enabled']) {
    $options['proxy'] = [
        'http' => "http://{$this->config['proxy']['username']}:{$this->config['proxy']['password']}@{$this->config['proxy']['host']}:{$this->config['proxy']['port']}",
        'https' => "http://{$this->config['proxy']['username']}:{$this->config['proxy']['password']}@{$this->config['proxy']['host']}:{$this->config['proxy']['port']}"
    ];
}

$response = Http::withOptions($options)->post('https://api.example.com/sequential-thinking', [
    'thought' => $thought,
    'thoughtNumber' => $thoughtNumber,
    'totalThoughts' => $totalThoughts,
    'nextThoughtNeeded' => $nextThoughtNeeded
]);
```

## Gestione dei Permessi dei File

### Permessi Corretti per i File di Log

Assicurarsi che i file di log abbiano i permessi corretti:

```bash
# Imposta i permessi corretti per la directory dei log
chmod 755 /path/to/your/project/logs
chmod 644 /path/to/your/project/logs/*.log
```

### Permessi per gli Script

Assicurarsi che gli script abbiano i permessi di esecuzione:

```bash
# Imposta i permessi di esecuzione per gli script
chmod +x /path/to/your/project/bashscripts/mcp/*.sh
```

## Monitoraggio e Logging

### Logging delle Attività

Implementare un sistema di logging per monitorare le attività dei server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\SequentialThinkingServerContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SequentialThinkingServer implements SequentialThinkingServerContract
{
    // ...
    
    /**
     * {@inheritdoc}
     */
    public function generateThought(
        string $thought,
        int $thoughtNumber,
        int $totalThoughts,
        bool $nextThoughtNeeded
    ): array {
        Log::info('Generating thought', [
            'server' => 'sequential-thinking',
            'user_id' => auth()->id(),
            'thought_number' => $thoughtNumber,
            'total_thoughts' => $totalThoughts
        ]);
        
        try {
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->post('http://localhost:3000/api/v1/sequential-thinking', [
                    'thought' => $thought,
                    'thoughtNumber' => $thoughtNumber,
                    'totalThoughts' => $totalThoughts,
                    'nextThoughtNeeded' => $nextThoughtNeeded
                ]);
            
            if ($response->successful()) {
                Log::info('Thought generated successfully', [
                    'server' => 'sequential-thinking',
                    'user_id' => auth()->id(),
                    'thought_number' => $thoughtNumber
                ]);
                
                return $response->json();
            }
            
            Log::error('Sequential Thinking Server Error', [
                'server' => 'sequential-thinking',
                'user_id' => auth()->id(),
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
                'server' => 'sequential-thinking',
                'user_id' => auth()->id(),
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
    
    // ...
}
```

### Monitoraggio delle Prestazioni

Implementare un sistema di monitoraggio delle prestazioni per i server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MCPMonitoringMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $duration = microtime(true) - $startTime;
        
        // Registra le metriche di prestazione
        Log::channel('performance')->info('MCP Request', [
            'path' => $request->path(),
            'method' => $request->method(),
            'duration' => $duration,
            'status' => $response->status(),
            'user_id' => auth()->id(),
            'server' => $request->route('server') ?? 'unknown'
        ]);
        
        return $response;
    }
}
```

## Best Practices di Sicurezza

### Limitazione delle Richieste

Implementare un sistema di rate limiting per limitare il numero di richieste ai server MCP:

```php
// routes/api.php
Route::middleware(['auth:sanctum', 'can:use-mcp-services', 'throttle:mcp-api'])->prefix('api/mcp')->group(function () {
    Route::post('analyze', [SequentialThinkingController::class, 'analyze']);
    // Altri endpoint...
});

// app/Providers/RouteServiceProvider.php
RateLimiter::for('mcp-api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()->id);
});
```

### Validazione dei Dati Sensibili

Implementare una validazione rigorosa per i dati sensibili:

```php
$validated = $request->validate([
    'text' => [
        'required',
        'string',
        'min:10',
        'max:10000',
        function ($attribute, $value, $fail) {
            // Verifica che il testo non contenga informazioni sensibili
            if (preg_match('/\b(?:\d[ -]*?){13,16}\b/', $value)) {
                $fail('Il testo non deve contenere numeri di carte di credito.');
            }
            
            if (preg_match('/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\b/', $value)) {
                $fail('Il testo non deve contenere indirizzi email.');
            }
            
            if (preg_match('/\b(?:\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}\b/', $value)) {
                $fail('Il testo non deve contenere numeri di telefono.');
            }
        }
    ],
    'aspects' => 'required|array|min:1',
    'aspects.*' => 'string|in:readability,seo,sentiment,keywords'
]);
```

### Protezione contro gli Attacchi

Implementare misure di protezione contro gli attacchi comuni:

```php
// config/app.php
return [
    'debug' => env('APP_DEBUG', false),
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'providers' => [
        // ...
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        // ...
    ],
];

// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\HandlePrecognitiveRequests::class,
    ],
    'api' => [
        \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];

protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
    'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
    'signed' => \App\Http\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
];
```

## Conclusione

Questa guida ha fornito le migliori pratiche di sicurezza per l'utilizzo dei server MCP in progetti Laravel. Seguendo queste linee guida, è possibile garantire che le integrazioni con i server MCP siano sicure e conformi alle regole di sviluppo stabilite per i progetti base_predict_fila5_mono.

Per ulteriori informazioni e supporto, consultare la documentazione ufficiale dei server MCP o contattare il team di sviluppo.
