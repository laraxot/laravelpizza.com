# Risoluzione dei Problemi dei Server MCP

## Panoramica

Questa guida fornisce informazioni dettagliate per la risoluzione dei problemi comuni che possono verificarsi durante l'utilizzo dei server MCP (Model Context Protocol) in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## ⚠️ ATTENZIONE: PROBLEMI DI MIGRAZIONE DATABASE

### Comandi Pericolosi

**PRIMA DI TUTTO:** Se stai riscontrando problemi con il database, **NON** utilizzare MAI i seguenti comandi in produzione o in ambienti con dati critici:

```bash
php artisan migrate:fresh       # ELIMINA TUTTE LE TABELLE E I DATI
php artisan migrate:fresh --seed # ELIMINA TUTTO E RICARICA I DATI DI PROVA
php artisan db:wipe             # ELIMINA TUTTE LE TABELLE
```

### Soluzioni Alternative

Se hai problemi con le migrazioni:

1. **Per applicare nuove migrazioni in sicurezza**:
   ```bash
   php artisan migrate
   ```

2. **Per annullare l'ultima migrazione**:
   ```bash
   php artisan migrate:rollback --step=1
   ```

3. **Se le tabelle mancano**:
   - Verifica che il database esista e che le credenziali siano corrette
   - Controlla che le migrazioni siano state create correttamente
   - Esegui solo `php artisan migrate` per applicare le migrazioni mancanti

Per ulteriori dettagli, vedi il file `AVVISO_MIGRAZIONI.mdc` nella root del progetto.

---

## Problemi Comuni e Soluzioni

### 1. Server MCP non Disponibile

#### Sintomi
- Errori di connessione quando si tenta di utilizzare un server MCP
- Timeout nelle richieste ai server MCP
- Errori del tipo "Connection refused" o "ECONNREFUSED"

#### Possibili Cause
- Il server MCP non è stato avviato
- Il server MCP è in esecuzione su una porta diversa da quella configurata
- Il server MCP è stato avviato ma è crashato

#### Soluzioni

1. **Verificare lo stato del server MCP**:
   ```bash
   /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh status [nome-server]
   ```

2. **Riavviare il server MCP**:
   ```bash
   /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh restart [nome-server]
   ```

3. **Controllare i log del server MCP**:
   ```bash
   /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh logs [nome-server]
   ```

4. **Verificare la configurazione**:
   Controllare che la configurazione nel file `mcp_config.json` sia corretta, in particolare:
   - Il percorso del comando per avviare il server
   - La porta su cui il server è in ascolto
   - Le variabili di ambiente necessarie

5. **Implementare un meccanismo di fallback**:
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

### 2. Errori nelle Richieste ai Server MCP

#### Sintomi
- Risposte con codici di errore HTTP (4xx, 5xx)
- Timeout nelle richieste
- Risposte malformate o incomplete

#### Possibili Cause
- Parametri di richiesta non validi
- Errori interni del server MCP
- Problemi di rete o latenza

#### Soluzioni

1. **Verificare i parametri della richiesta**:
   Assicurarsi che i parametri inviati al server MCP siano corretti e nel formato atteso.

2. **Controllare i log del server MCP**:
   ```bash
   /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh logs [nome-server]
   ```

3. **Implementare un meccanismo di retry**:
   ```php
   $maxRetries = 3;
   $retryCount = 0;
   $delay = 1;
   
   while ($retryCount < $maxRetries) {
       try {
           $response = $mcpService->fetch()->get('https://api.example.com/data');
           break;
       } catch (\Exception $e) {
           $retryCount++;
           $delay *= 2; // Backoff esponenziale
           Log::warning("Retry {$retryCount}/{$maxRetries}: " . $e->getMessage());
           
           if ($retryCount < $maxRetries) {
               sleep($delay);
           } else {
               throw $e; // Rilancia l'eccezione se tutti i tentativi falliscono
           }
       }
   }
   ```

4. **Impostare timeout appropriati**:
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

### 3. Problemi con il Server MySQL

#### Sintomi
- Errori di connessione al database MySQL
- Query SQL che falliscono
- Errori relativi a credenziali o permessi

#### Possibili Cause
- Configurazione errata nel file `.env`
- Il server MySQL non è in esecuzione
- Problemi di permessi o credenziali

#### Soluzioni

1. **Verificare la configurazione nel file `.env`**:
   Assicurarsi che le seguenti variabili siano configurate correttamente:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nome_database
   DB_USERNAME=utente
   DB_PASSWORD=password
   ```

2. **Verificare lo stato del server MySQL**:
   ```bash
   sudo systemctl status mysql
   ```

3. **Riavviare il server MySQL**:
   ```bash
   sudo systemctl restart mysql
   ```

4. **Verificare i permessi dell'utente MySQL**:
   ```sql
   SHOW GRANTS FOR 'utente'@'localhost';
   ```

5. **Controllare i log del server MCP MySQL**:
   ```bash
   /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh logs mysql
   ```

6. **Implementare un meccanismo di fallback**:
   ```php
   try {
       $results = $mcpService->mysql()->executeQuery('SELECT * FROM users');
   } catch (\Exception $e) {
       Log::error('Errore MySQL: ' . $e->getMessage());
       
       // Fallback: utilizza Eloquent
       $results = \App\Models\User::all()->toArray();
   }
   ```

### 4. Problemi con il Server Puppeteer

#### Sintomi
- Errori durante la cattura di screenshot
- Timeout nelle operazioni di browser automation
- Errori relativi a Chrome o Chromium

#### Possibili Cause
- Chrome o Chromium non è installato
- Problemi di permessi
- Risorse insufficienti (memoria, CPU)

#### Soluzioni

1. **Verificare l'installazione di Chrome/Chromium**:
   ```bash
   which chromium-browser
   which google-chrome
   ```

2. **Installare Chrome/Chromium se necessario**:
   ```bash
   sudo apt-get update
   sudo apt-get install -y chromium-browser
   ```

3. **Aumentare i timeout per le operazioni Puppeteer**:
   ```php
   try {
       $response = Http::timeout(120) // Timeout di 2 minuti
           ->post('http://localhost:3006/api/v1/screenshot', [
               'url' => $url,
               'outputPath' => $outputPath
           ]);
   } catch (\Exception $e) {
       Log::error('Puppeteer Server Exception: ' . $e->getMessage());
   }
   ```

4. **Controllare i log del server Puppeteer**:
   ```bash
   /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh logs puppeteer
   ```

5. **Utilizzare opzioni aggiuntive per Puppeteer**:
   ```php
   try {
       $response = Http::post('http://localhost:3006/api/v1/screenshot', [
           'url' => $url,
           'outputPath' => $outputPath,
           'options' => [
               'headless' => true,
               'args' => [
                   '--no-sandbox',
                   '--disable-setuid-sandbox',
                   '--disable-dev-shm-usage',
                   '--disable-accelerated-2d-canvas',
                   '--no-first-run',
                   '--no-zygote',
                   '--disable-gpu'
               ]
           ]
       ]);
   } catch (\Exception $e) {
       Log::error('Puppeteer Server Exception: ' . $e->getMessage());
   }
   ```

### 5. Problemi di Memoria o Prestazioni

#### Sintomi
- Server MCP che crashano o si bloccano
- Utilizzo elevato di memoria o CPU
- Prestazioni degradate nel tempo

#### Possibili Cause
- Memory leak nei server MCP
- Troppe richieste simultanee
- Risorse del sistema insufficienti

#### Soluzioni

1. **Monitorare l'utilizzo delle risorse**:
   ```bash
   top -p $(pgrep -f "node.*mcp")
   ```

2. **Riavviare periodicamente i server MCP**:
   Configurare un cron job per riavviare i server MCP a intervalli regolari:
   ```
   0 4 * * * /path/to/your/project/bashscripts/mcp/mcp-manager-v2.sh restart all
   ```

3. **Implementare un meccanismo di throttling**:
   ```php
   use Illuminate\Cache\RateLimiter;

   class MCPRateLimiter
   {
       private RateLimiter $limiter;
       
       public function __construct(RateLimiter $limiter)
       {
           $this->limiter = $limiter;
       }
       
       public function attempt(string $key, int $maxAttempts, \Closure $callback, int $decaySeconds = 60)
       {
           if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
               $seconds = $this->limiter->availableIn($key);
               throw new \Exception("Troppe richieste. Riprova tra {$seconds} secondi.");
           }
           
           $result = $callback();
           
           $this->limiter->hit($key, $decaySeconds);
           
           return $result;
       }
   }
   
   // Utilizzo
   $rateLimiter = app(MCPRateLimiter::class);
   
   try {
       $result = $rateLimiter->attempt(
           'mcp_sequential_thinking',
           10, // massimo 10 richieste
           function () use ($mcpService, $thought) {
               return $mcpService->sequentialThinking()->generateThought(
                   $thought,
                   1,
                   5,
                   true
               );
           },
           60 // decay di 60 secondi
       );
   } catch (\Exception $e) {
       Log::warning('Rate limit exceeded: ' . $e->getMessage());
       // Gestione dell'errore
   }
   ```

4. **Ottimizzare la configurazione Node.js**:
   Aggiungere opzioni di ottimizzazione al comando di avvio del server MCP:
   ```json
   {
       "command": "node --max-old-space-size=4096 /path/to/server.js"
   }
   ```

## Logging e Monitoraggio

### Configurazione del Logging

Per una migliore diagnostica dei problemi, è consigliabile configurare un logging appropriato:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\SequentialThinkingServerContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

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
        Log::debug('Generating thought', [
            'thought' => $thought,
            'thoughtNumber' => $thoughtNumber,
            'totalThoughts' => $totalThoughts,
            'nextThoughtNeeded' => $nextThoughtNeeded
        ]);
        
        try {
            $startTime = microtime(true);
            
            $response = Http::timeout($this->config['timeout'] ?? 30)
                ->post('http://localhost:3000/api/v1/sequential-thinking', [
                    'thought' => $thought,
                    'thoughtNumber' => $thoughtNumber,
                    'totalThoughts' => $totalThoughts,
                    'nextThoughtNeeded' => $nextThoughtNeeded
                ]);
            
            $duration = microtime(true) - $startTime;
            
            Log::debug('Thought generated', [
                'duration' => $duration,
                'status' => $response->status()
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Sequential Thinking Server Error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'duration' => $duration
            ]);
            
            return [
                'thought' => $thought,
                'thoughtNumber' => $thoughtNumber,
                'totalThoughts' => $totalThoughts,
                'nextThoughtNeeded' => $nextThoughtNeeded,
                'error' => 'Failed to generate thought'
            ];
        } catch (RequestException $e) {
            Log::error('Sequential Thinking Server Request Exception', [
                'message' => $e->getMessage(),
                'response' => $e->response?->body(),
                'status' => $e->response?->status()
            ]);
            
            return [
                'thought' => $thought,
                'thoughtNumber' => $thoughtNumber,
                'totalThoughts' => $totalThoughts,
                'nextThoughtNeeded' => $nextThoughtNeeded,
                'error' => $e->getMessage()
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
    
    // ...
}
```

### Monitoraggio delle Prestazioni

Per monitorare le prestazioni dei server MCP, è possibile implementare un middleware di telemetria:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MCPTelemetryMiddleware
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
        
        // Registra la telemetria solo per le richieste MCP
        if (strpos($request->path(), 'api/mcp') === 0) {
            Log::channel('telemetry')->info('MCP Request', [
                'path' => $request->path(),
                'method' => $request->method(),
                'duration' => $duration,
                'status' => $response->status(),
                'server' => $request->route('server') ?? 'unknown'
            ]);
        }
        
        return $response;
    }
}
```

## Verifica dello Stato dei Server MCP

### Implementazione di un Endpoint di Health Check

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Http;

class MCPHealthController extends Controller
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }
    
    /**
     * Verifica lo stato di tutti i server MCP.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        $servers = [
            'sequential-thinking' => 'http://localhost:3000/api/v1/health',
            'memory' => 'http://localhost:3001/api/v1/health',
            'fetch' => 'http://localhost:3002/api/v1/health',
            'filesystem' => 'http://localhost:3003/api/v1/health',
            'redis' => 'http://localhost:3004/api/v1/health',
            'postgres' => 'http://localhost:3005/api/v1/health',
            'puppeteer' => 'http://localhost:3006/api/v1/health',
            'mysql' => 'http://localhost:3007/api/v1/health'
        ];
        
        $results = [];
        
        foreach ($servers as $name => $url) {
            try {
                $response = Http::timeout(5)->get($url);
                
                $results[$name] = [
                    'status' => $response->successful() ? 'up' : 'down',
                    'code' => $response->status(),
                    'message' => $response->successful() ? 'OK' : $response->body()
                ];
            } catch (\Exception $e) {
                $results[$name] = [
                    'status' => 'down',
                    'code' => 500,
                    'message' => $e->getMessage()
                ];
            }
        }
        
        $allUp = count(array_filter($results, fn($r) => $r['status'] === 'up')) === count($servers);
        
        return response()->json([
            'status' => $allUp ? 'healthy' : 'degraded',
            'timestamp' => now()->toIso8601String(),
            'servers' => $results
        ]);
    }
}
```

### Implementazione di un Command per il Check dello Stato

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckMCPServersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcp:check {--detailed : Show detailed information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of all MCP servers';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $servers = [
            'sequential-thinking' => 'http://localhost:3000/api/v1/health',
            'memory' => 'http://localhost:3001/api/v1/health',
            'fetch' => 'http://localhost:3002/api/v1/health',
            'filesystem' => 'http://localhost:3003/api/v1/health',
            'redis' => 'http://localhost:3004/api/v1/health',
            'postgres' => 'http://localhost:3005/api/v1/health',
            'puppeteer' => 'http://localhost:3006/api/v1/health',
            'mysql' => 'http://localhost:3007/api/v1/health'
        ];
        
        $results = [];
        $hasErrors = false;
        
        foreach ($servers as $name => $url) {
            $this->output->write("Checking {$name}... ");
            
            try {
                $response = Http::timeout(5)->get($url);
                
                if ($response->successful()) {
                    $this->output->writeln('<info>OK</info>');
                    
                    $results[$name] = [
                        'status' => 'up',
                        'code' => $response->status(),
                        'message' => 'OK'
                    ];
                    
                    if ($this->option('detailed')) {
                        $this->output->writeln("  Response: " . $response->body());
                    }
                } else {
                    $this->output->writeln('<error>FAIL</error>');
                    $hasErrors = true;
                    
                    $results[$name] = [
                        'status' => 'down',
                        'code' => $response->status(),
                        'message' => $response->body()
                    ];
                    
                    if ($this->option('detailed')) {
                        $this->output->writeln("  Error: " . $response->body());
                    }
                }
            } catch (\Exception $e) {
                $this->output->writeln('<error>ERROR</error>');
                $hasErrors = true;
                
                $results[$name] = [
                    'status' => 'down',
                    'code' => 500,
                    'message' => $e->getMessage()
                ];
                
                if ($this->option('detailed')) {
                    $this->output->writeln("  Exception: " . $e->getMessage());
                }
            }
        }
        
        $this->newLine();
        
        $tableData = [];
        foreach ($results as $name => $result) {
            $tableData[] = [
                $name,
                $result['status'] === 'up' ? '<info>UP</info>' : '<error>DOWN</error>',
                $result['code'],
                $result['message']
            ];
        }
        
        $this->table(['Server', 'Status', 'Code', 'Message'], $tableData);
        
        return $hasErrors ? 1 : 0;
    }
}
```

## Conclusione

Questa guida ha fornito informazioni dettagliate per la risoluzione dei problemi comuni che possono verificarsi durante l'utilizzo dei server MCP in progetti Laravel. Seguendo queste linee guida, è possibile diagnosticare e risolvere rapidamente i problemi, garantendo un'esperienza di sviluppo fluida e un'applicazione robusta.

Per ulteriori informazioni e supporto, consultare la documentazione ufficiale dei server MCP o contattare il team di sviluppo.
