# Laravel Helper Tools per MCP

## Introduzione

Questo tutorial esplora l'implementazione di strumenti di supporto per Laravel utilizzando il Model Context Protocol (MCP), consentendo agli agenti AI di interagire con le funzionalità di Laravel come log, comandi Artisan e database.

## Prerequisiti

- PHP 8.0 o superiore
- Laravel 8.x o superiore
- Composer
- Conoscenza base di Laravel
- Un server MCP configurato

## Indice

1. [Panoramica degli Helper Tools](#panoramica-degli-helper-tools)
2. [Installazione e Configurazione](#installazione-e-configurazione)
3. [Strumenti per l'Analisi dei Log](#strumenti-per-lanalisi-dei-log)
4. [Strumenti per i Comandi Artisan](#strumenti-per-i-comandi-artisan)
5. [Strumenti per l'Interazione con il Database](#strumenti-per-linterazione-con-il-database)
6. [Integrazione con Agenti AI](#integrazione-con-agenti-ai)
7. [Casi d'Uso Avanzati](#casi-duso-avanzati)
8. [Sicurezza e Best Practices](#sicurezza-e-best-practices)

## Panoramica degli Helper Tools

Gli Helper Tools per Laravel sono strumenti MCP che consentono agli agenti AI di interagire con vari aspetti di un'applicazione Laravel, come:

- Analisi dei file di log
- Esecuzione di comandi Artisan
- Interazione con il database
- Gestione della cache e delle sessioni
- Monitoraggio delle performance

Questi strumenti possono essere utilizzati per automatizzare attività di sviluppo, debugging e manutenzione, migliorando la produttività degli sviluppatori e la qualità del codice.

## Installazione e Configurazione

1. Installare il pacchetto Laravel MCP:

```bash
composer require jsonallen/laravel-mcp
```

2. Pubblicare i file di configurazione:

```bash
php artisan vendor:publish --tag=laravel-mcp-config
```

3. Configurare il server MCP nel file `.env`:

```
MCP_SERVER_ENABLED=true
MCP_SERVER_PATH=/mcp
MCP_SERVER_AUTH_ENABLED=true
MCP_SERVER_AUTH_TOKEN=your_secure_token_here
LARAVEL_PATH=/var/www/html/your-laravel-project
```

## Strumenti per l'Analisi dei Log

Implementare strumenti MCP per l'analisi dei log di Laravel:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Illuminate\Support\Facades\File;

class TailLogFileTool extends Tool
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'tail_log_file';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Visualizza le ultime righe del file di log di Laravel.';
    }

    /**
     * @return array<int, ToolProperty>
     */
    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'lines',
                type: 'integer',
                description: 'Numero di righe da visualizzare',
                required: false
            ),
            new ToolProperty(
                name: 'log_file',
                type: 'string',
                description: 'Nome del file di log (es. laravel.log)',
                required: false
            ),
        ];
    }

    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function handle(array $parameters): array
    {
        $lines = (int) ($parameters['lines'] ?? 50);
        $logFile = $parameters['log_file'] ?? 'laravel.log';
        
        $logPath = storage_path('logs/' . $logFile);
        
        if (!File::exists($logPath)) {
            return [
                'error' => 'File di log non trovato',
                'path' => $logPath,
            ];
        }
        
        // Leggi le ultime N righe del file di log
        $logContent = $this->tailFile($logPath, $lines);
        
        return [
            'log_file' => $logFile,
            'lines' => $lines,
            'content' => $logContent,
        ];
    }
    
    /**
     * Legge le ultime N righe di un file.
     *
     * @param string $filePath
     * @param int $lines
     * @return string
     */
    private function tailFile(string $filePath, int $lines): string
    {
        $file = new \SplFileObject($filePath, 'r');
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key();
        
        $startLine = max(0, $totalLines - $lines);
        $content = [];
        
        $file->seek($startLine);
        
        while (!$file->eof()) {
            $content[] = $file->fgets();
        }
        
        return implode('', $content);
    }
}
```

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Illuminate\Support\Facades\File;

class SearchLogErrorsTool extends Tool
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'search_log_errors';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Cerca errori nei file di log di Laravel.';
    }

    /**
     * @return array<int, ToolProperty>
     */
    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'query',
                type: 'string',
                description: 'Termine di ricerca',
                required: true
            ),
            new ToolProperty(
                name: 'log_file',
                type: 'string',
                description: 'Nome del file di log (es. laravel.log)',
                required: false
            ),
            new ToolProperty(
                name: 'context_lines',
                type: 'integer',
                description: 'Numero di righe di contesto da visualizzare',
                required: false
            ),
        ];
    }

    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function handle(array $parameters): array
    {
        $query = $parameters['query'];
        $logFile = $parameters['log_file'] ?? 'laravel.log';
        $contextLines = (int) ($parameters['context_lines'] ?? 2);
        
        $logPath = storage_path('logs/' . $logFile);
        
        if (!File::exists($logPath)) {
            return [
                'error' => 'File di log non trovato',
                'path' => $logPath,
            ];
        }
        
        // Cerca nel file di log
        $results = $this->searchInFile($logPath, $query, $contextLines);
        
        return [
            'query' => $query,
            'log_file' => $logFile,
            'matches_count' => count($results),
            'results' => $results,
        ];
    }
    
    /**
     * Cerca un termine in un file e restituisce le corrispondenze con contesto.
     *
     * @param string $filePath
     * @param string $query
     * @param int $contextLines
     * @return array<int, array<string, mixed>>
     */
    private function searchInFile(string $filePath, string $query, int $contextLines): array
    {
        $file = new \SplFileObject($filePath, 'r');
        $lineNumber = 0;
        $results = [];
        $buffer = [];
        
        while (!$file->eof()) {
            $line = $file->fgets();
            $lineNumber++;
            
            // Mantieni un buffer delle ultime N righe
            $buffer[$lineNumber] = $line;
            
            // Rimuovi le righe più vecchie dal buffer
            if (count($buffer) > $contextLines * 2 + 1) {
                array_shift($buffer);
            }
            
            if (stripos($line, $query) !== false) {
                $context = [];
                
                // Aggiungi le righe di contesto prima della corrispondenza
                foreach ($buffer as $bufferLineNumber => $bufferLine) {
                    if ($bufferLineNumber >= $lineNumber - $contextLines && $bufferLineNumber <= $lineNumber + $contextLines) {
                        $context[$bufferLineNumber] = $bufferLine;
                    }
                }
                
                $results[] = [
                    'line_number' => $lineNumber,
                    'line' => $line,
                    'context' => $context,
                ];
            }
        }
        
        return $results;
    }
}
```

## Strumenti per i Comandi Artisan

Implementare strumenti MCP per l'esecuzione di comandi Artisan:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Illuminate\Support\Facades\Artisan;

class RunArtisanCommandTool extends Tool
{
    /**
     * @var array<string>
     */
    protected array $safeCommands = [
        'cache:clear',
        'config:clear',
        'route:list',
        'view:clear',
        'make:model',
        'make:controller',
        'make:migration',
        'db:seed',
        'migrate:status',
    ];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'run_artisan_command';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Esegue un comando Artisan sicuro.';
    }

    /**
     * @return array<int, ToolProperty>
     */
    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'command',
                type: 'string',
                description: 'Comando Artisan da eseguire',
                required: true
            ),
            new ToolProperty(
                name: 'parameters',
                type: 'object',
                description: 'Parametri del comando',
                required: false
            ),
        ];
    }

    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function handle(array $parameters): array
    {
        $command = $parameters['command'];
        $commandParams = $parameters['parameters'] ?? [];
        
        // Verifica che il comando sia nella lista dei comandi sicuri
        $baseCommand = explode(':', $command)[0] . ':' . explode(':', $command)[1];
        
        if (!in_array($baseCommand, $this->safeCommands)) {
            return [
                'error' => 'Comando non autorizzato',
                'message' => 'Solo i comandi nella whitelist possono essere eseguiti',
                'safe_commands' => $this->safeCommands,
            ];
        }
        
        // Esecuzione del comando
        $output = [];
        Artisan::call($command, $commandParams, $output);
        
        return [
            'command' => $command,
            'parameters' => $commandParams,
            'output' => $output,
        ];
    }
}
```

## Strumenti per l'Interazione con il Database

Implementare strumenti MCP per l'interazione con il database:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShowModelTool extends Tool
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'show_model';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Visualizza informazioni su un modello Eloquent.';
    }

    /**
     * @return array<int, ToolProperty>
     */
    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'model_name',
                type: 'string',
                description: 'Nome del modello (es. App\\Models\\User)',
                required: true
            ),
        ];
    }

    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function handle(array $parameters): array
    {
        $modelName = $parameters['model_name'];
        
        // Verifica che il modello esista
        if (!class_exists($modelName)) {
            return [
                'error' => 'Modello non trovato',
                'model_name' => $modelName,
            ];
        }
        
        // Crea un'istanza del modello
        $model = new $modelName();
        
        // Ottieni il nome della tabella
        $table = $model->getTable();
        
        // Ottieni la struttura della tabella
        $columns = Schema::getColumnListing($table);
        $columnDetails = [];
        
        foreach ($columns as $column) {
            $type = DB::getSchemaBuilder()->getColumnType($table, $column);
            $columnDetails[$column] = [
                'type' => $type,
                'nullable' => !Schema::hasColumn($table, $column) ?: !DB::getSchemaBuilder()->getConnection()->getDoctrineColumn($table, $column)->getNotnull(),
            ];
        }
        
        // Ottieni le relazioni
        $relations = $this->getModelRelations($model);
        
        return [
            'model_name' => $modelName,
            'table' => $table,
            'primary_key' => $model->getKeyName(),
            'columns' => $columnDetails,
            'fillable' => $model->getFillable(),
            'hidden' => $model->getHidden(),
            'timestamps' => $model->usesTimestamps(),
            'relations' => $relations,
        ];
    }
    
    /**
     * Ottiene le relazioni di un modello.
     *
     * @param mixed $model
     * @return array<string, string>
     */
    private function getModelRelations($model): array
    {
        $relations = [];
        $reflection = new \ReflectionClass($model);
        
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getNumberOfParameters() === 0 && $method->class === get_class($model)) {
                try {
                    $return = $method->invoke($model);
                    
                    if (
                        $return instanceof \Illuminate\Database\Eloquent\Relations\Relation ||
                        $return instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo ||
                        $return instanceof \Illuminate\Database\Eloquent\Relations\HasOne ||
                        $return instanceof \Illuminate\Database\Eloquent\Relations\HasMany ||
                        $return instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany
                    ) {
                        $relations[$method->getName()] = get_class($return);
                    }
                } catch (\Exception $e) {
                    // Ignora le eccezioni
                }
            }
        }
        
        return $relations;
    }
}
```

## Integrazione con Agenti AI

Implementare un servizio per l'integrazione degli Helper Tools con agenti AI:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\Services;

use NeuronAI\Agent;
use NeuronAI\MCP\MCPConnector;

class LaravelHelperAIService
{
    protected Agent $agent;
    protected MCPConnector $connector;
    
    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
        $this->connector = new MCPConnector($agent);
    }
    
    /**
     * Analizza i log di Laravel e identifica problemi.
     *
     * @param string $logFile
     * @return string
     */
    public function analyzeLogFile(string $logFile = 'laravel.log'): string
    {
        // Connessione al server MCP locale
        $this->connector->connect('localhost');
        
        // Prompt per l'agente AI
        $prompt = "Analizza il file di log {$logFile} e identifica eventuali problemi o pattern di errori. Fornisci un riepilogo dei problemi più critici e suggerisci possibili soluzioni.";
        
        // L'agente utilizzerà automaticamente gli strumenti MCP disponibili
        return $this->agent->chat($prompt);
    }
    
    /**
     * Ottimizza le query del database.
     *
     * @param string $modelName
     * @return string
     */
    public function optimizeDatabaseQueries(string $modelName): string
    {
        // Connessione al server MCP locale
        $this->connector->connect('localhost');
        
        // Prompt per l'agente AI
        $prompt = "Analizza il modello {$modelName} e le sue relazioni. Identifica potenziali problemi di performance nelle query e suggerisci ottimizzazioni, come l'eager loading o l'aggiunta di indici.";
        
        // L'agente utilizzerà automaticamente gli strumenti MCP disponibili
        return $this->agent->chat($prompt);
    }
    
    /**
     * Genera documentazione per un modello.
     *
     * @param string $modelName
     * @return string
     */
    public function generateModelDocumentation(string $modelName): string
    {
        // Connessione al server MCP locale
        $this->connector->connect('localhost');
        
        // Prompt per l'agente AI
        $prompt = "Genera documentazione completa per il modello {$modelName}, inclusi attributi, relazioni e metodi principali. Formatta la documentazione in Markdown.";
        
        // L'agente utilizzerà automaticamente gli strumenti MCP disponibili
        return $this->agent->chat($prompt);
    }
}
```

## Casi d'Uso Avanzati

### 1. Debugging Automatizzato

Utilizzare gli Helper Tools per automatizzare il debugging di errori:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Illuminate\Support\Facades\File;

class DebugErrorTool extends Tool
{
    public function getName(): string
    {
        return 'debug_error';
    }

    public function getDescription(): string
    {
        return 'Analizza un errore nei log e suggerisce possibili soluzioni.';
    }

    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'error_message',
                type: 'string',
                description: 'Messaggio di errore da analizzare',
                required: true
            ),
            new ToolProperty(
                name: 'stack_trace',
                type: 'string',
                description: 'Stack trace dell\'errore',
                required: false
            ),
        ];
    }

    public function handle(array $parameters): array
    {
        $errorMessage = $parameters['error_message'];
        $stackTrace = $parameters['stack_trace'] ?? null;
        
        // Qui si utilizzerebbe l'LLM per analizzare l'errore
        // e suggerire possibili soluzioni
        
        return [
            'error_message' => $errorMessage,
            'analysis' => $errorAnalysis,
            'possible_solutions' => $possibleSolutions,
            'recommended_actions' => $recommendedActions,
        ];
    }
}
```

### 2. Generazione di Test

Implementare uno strumento che genera test unitari per i modelli:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Illuminate\Support\Facades\File;

class GenerateModelTestTool extends Tool
{
    public function getName(): string
    {
        return 'generate_model_test';
    }

    public function getDescription(): string
    {
        return 'Genera test unitari per un modello Eloquent.';
    }

    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'model_name',
                type: 'string',
                description: 'Nome del modello (es. App\\Models\\User)',
                required: true
            ),
            new ToolProperty(
                name: 'test_type',
                type: 'string',
                description: 'Tipo di test (unit, feature)',
                required: false
            ),
        ];
    }

    public function handle(array $parameters): array
    {
        $modelName = $parameters['model_name'];
        $testType = $parameters['test_type'] ?? 'unit';
        
        // Verifica che il modello esista
        if (!class_exists($modelName)) {
            return [
                'error' => 'Modello non trovato',
                'model_name' => $modelName,
            ];
        }
        
        // Qui si utilizzerebbe l'LLM per generare i test unitari
        // basati sulla struttura del modello
        
        return [
            'model_name' => $modelName,
            'test_type' => $testType,
            'test_code' => $generatedTestCode,
            'test_file_path' => $testFilePath,
        ];
    }
}
```

### 3. Ottimizzazione delle Performance

Creare uno strumento che analizza le performance dell'applicazione:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Illuminate\Support\Facades\DB;

class AnalyzePerformanceTool extends Tool
{
    public function getName(): string
    {
        return 'analyze_performance';
    }

    public function getDescription(): string
    {
        return 'Analizza le performance dell\'applicazione e suggerisce ottimizzazioni.';
    }

    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'focus_area',
                type: 'string',
                description: 'Area di focus (database, cache, routes)',
                required: false
            ),
        ];
    }

    public function handle(array $parameters): array
    {
        $focusArea = $parameters['focus_area'] ?? 'all';
        
        $performanceData = [];
        
        if ($focusArea === 'all' || $focusArea === 'database') {
            // Analisi delle query del database
            $slowQueries = DB::select("SELECT * FROM mysql.slow_log LIMIT 10");
            $performanceData['database'] = [
                'slow_queries' => $slowQueries,
                'missing_indexes' => $this->identifyMissingIndexes(),
            ];
        }
        
        if ($focusArea === 'all' || $focusArea === 'cache') {
            // Analisi della cache
            $performanceData['cache'] = [
                'hit_rate' => $this->getCacheHitRate(),
                'recommendations' => $this->getCacheRecommendations(),
            ];
        }
        
        if ($focusArea === 'all' || $focusArea === 'routes') {
            // Analisi delle route
            $performanceData['routes'] = [
                'slow_routes' => $this->identifySlowRoutes(),
                'recommendations' => $this->getRouteRecommendations(),
            ];
        }
        
        // Qui si utilizzerebbe l'LLM per analizzare i dati di performance
        // e suggerire ottimizzazioni
        
        return [
            'focus_area' => $focusArea,
            'performance_data' => $performanceData,
            'analysis' => $performanceAnalysis,
            'recommendations' => $recommendations,
        ];
    }
    
    // Metodi di supporto per l'analisi delle performance
    // ...
}
```

## Sicurezza e Best Practices

1. **Limitazione dei Comandi**:
   - Implementare una whitelist di comandi Artisan sicuri
   - Evitare comandi che modificano il database in produzione
   - Limitare l'accesso ai file sensibili

2. **Validazione e Sanitizzazione**:
   - Validare rigorosamente tutti gli input provenienti dagli LLM
   - Sanitizzare i dati sensibili nei log prima di inviarli agli LLM
   - Implementare rate limiting per prevenire abusi

3. **Logging e Monitoraggio**:
   - Registrare tutte le interazioni con il server MCP
   - Monitorare l'utilizzo degli strumenti e le performance
   - Implementare alert per comportamenti anomali

4. **Conformità con PHPStan Livello 9**:
   - Utilizzare tipizzazione rigorosa per tutti i metodi e le proprietà
   - Documentare correttamente i tipi di ritorno e i parametri
   - Seguire le best practices per la gestione dei valori mixed

---

*Ultimo aggiornamento: Maggio 2025*
