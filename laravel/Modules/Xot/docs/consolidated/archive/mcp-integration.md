# Integrazione dei Server MCP con il Modulo Xot

## Panoramica

Questo documento fornisce linee guida per l'integrazione dei server MCP (Model Context Protocol) con il modulo Xot, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila3_mono.

## Server MCP Consigliati

Per il modulo Xot, che funge da modulo base per molti altri moduli, si consigliano i seguenti server MCP:

### 1. MySQL

**Scopo**: Interazione avanzata con il database MySQL per operazioni complesse e ottimizzazioni.

**Casi d'uso**:
- Ottimizzazione delle query database
- Analisi della struttura del database
- Migrazione e gestione dei dati
- Query complesse per report e dashboard

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Xot\DataObjects\QueryAnalysisData;
use Illuminate\Support\Facades\Log;

class OptimizeDatabaseQueryAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Analizza e ottimizza una query SQL.
     *
     * @param string $query La query da analizzare
     * @param array<mixed> $params I parametri della query
     *
     * @return QueryAnalysisData I dati dell'analisi
     */
    public function execute(string $query, array $params = []): QueryAnalysisData
    {
        try {
            // Esegue EXPLAIN sulla query
            $explainQuery = 'EXPLAIN ' . $query;
            $explainResults = $this->mcpService->mysql()->executeQuery($explainQuery, $params);
            
            // Analizza i risultati di EXPLAIN
            $estimatedRows = 0;
            $usesIndexes = false;
            $tableScans = [];
            
            foreach ($explainResults as $result) {
                if (isset($result['rows'])) {
                    $estimatedRows += (int) $result['rows'];
                }
                
                if (isset($result['key']) && $result['key'] !== null) {
                    $usesIndexes = true;
                }
                
                if (isset($result['type']) && $result['type'] === 'ALL') {
                    $tableScans[] = $result['table'] ?? 'unknown';
                }
            }
            
            // Genera suggerimenti di ottimizzazione
            $recommendations = [];
            $optimizedQuery = $query;
            
            if (!$usesIndexes) {
                $recommendations[] = 'La query non utilizza indici. Considera l\'aggiunta di indici appropriati.';
            }
            
            if (!empty($tableScans)) {
                $recommendations[] = 'La query esegue table scan su: ' . implode(', ', $tableScans) . '. Considera l\'aggiunta di indici o la riscrittura della query.';
            }
            
            if ($estimatedRows > 1000) {
                $recommendations[] = 'La query potrebbe restituire un numero elevato di righe (' . $estimatedRows . '). Considera l\'aggiunta di limiti o filtri.';
                
                // Aggiunge LIMIT se non presente
                if (stripos($query, 'LIMIT') === false) {
                    $optimizedQuery .= ' LIMIT 1000';
                    $recommendations[] = 'Aggiunto LIMIT 1000 per limitare il numero di risultati.';
                }
            }
            
            // Verifica se ci sono JOIN senza condizioni
            if (stripos($query, 'JOIN') !== false && stripos($query, 'ON') === false) {
                $recommendations[] = 'La query contiene JOIN senza condizioni ON. Verifica che tutti i JOIN abbiano condizioni appropriate.';
            }
            
            return new QueryAnalysisData(
                originalQuery: $query,
                optimizedQuery: $optimizedQuery,
                estimatedRows: $estimatedRows,
                usesIndexes: $usesIndexes,
                tableScans: $tableScans,
                recommendations: $recommendations
            );
        } catch (\Exception $e) {
            Log::error('Query optimization failed', [
                'query' => $query,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return new QueryAnalysisData(
                originalQuery: $query,
                optimizedQuery: $query,
                estimatedRows: 0,
                usesIndexes: false,
                tableScans: [],
                recommendations: ['Analisi fallita: ' . $e->getMessage()]
            );
        }
    }
}
```

### 2. Redis

**Scopo**: Gestione avanzata della cache e delle code per ottimizzare le prestazioni dell'applicazione.

**Casi d'uso**:
- Caching di dati frequentemente utilizzati
- Gestione delle code per operazioni asincrone
- Memorizzazione di sessioni e dati temporanei
- Implementazione di rate limiting e throttling

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;

class CacheService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Memorizza un valore in cache.
     *
     * @param string $key La chiave
     * @param mixed $value Il valore
     * @param int $ttl Tempo di vita in secondi
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        try {
            return $this->mcpService->redis()->set($key, $value, $ttl);
        } catch (\Exception $e) {
            Log::error('Cache set failed', [
                'key' => $key,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Recupera un valore dalla cache.
     *
     * @param string $key La chiave
     * @param mixed $default Valore di default se la chiave non esiste
     *
     * @return mixed Il valore memorizzato o il valore di default
     */
    public function get(string $key, mixed $default = null): mixed
    {
        try {
            $value = $this->mcpService->redis()->get($key);
            
            return $value !== null ? $value : $default;
        } catch (\Exception $e) {
            Log::error('Cache get failed', [
                'key' => $key,
                'message' => $e->getMessage()
            ]);
            
            return $default;
        }
    }

    /**
     * Elimina un valore dalla cache.
     *
     * @param string $key La chiave
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function delete(string $key): bool
    {
        try {
            return $this->mcpService->redis()->delete($key);
        } catch (\Exception $e) {
            Log::error('Cache delete failed', [
                'key' => $key,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Verifica se una chiave esiste in cache.
     *
     * @param string $key La chiave
     *
     * @return bool True se la chiave esiste, false altrimenti
     */
    public function has(string $key): bool
    {
        try {
            return $this->mcpService->redis()->exists($key);
        } catch (\Exception $e) {
            Log::error('Cache exists check failed', [
                'key' => $key,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Incrementa un valore numerico in cache.
     *
     * @param string $key La chiave
     * @param int $amount Quantità da incrementare
     *
     * @return int|false Il nuovo valore o false in caso di errore
     */
    public function increment(string $key, int $amount = 1): int|false
    {
        try {
            return $this->mcpService->redis()->increment($key, $amount);
        } catch (\Exception $e) {
            Log::error('Cache increment failed', [
                'key' => $key,
                'amount' => $amount,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Decrementa un valore numerico in cache.
     *
     * @param string $key La chiave
     * @param int $amount Quantità da decrementare
     *
     * @return int|false Il nuovo valore o false in caso di errore
     */
    public function decrement(string $key, int $amount = 1): int|false
    {
        try {
            return $this->mcpService->redis()->decrement($key, $amount);
        } catch (\Exception $e) {
            Log::error('Cache decrement failed', [
                'key' => $key,
                'amount' => $amount,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}
```

### 3. Filesystem

**Scopo**: Gestione avanzata dei file e delle directory per operazioni di I/O.

**Casi d'uso**:
- Gestione di file di configurazione
- Backup e ripristino di dati
- Generazione di report e file di esportazione
- Gestione dei file temporanei

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;

class FileService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Legge il contenuto di un file.
     *
     * @param string $path Percorso del file
     *
     * @return string|null Contenuto del file o null in caso di errore
     */
    public function read(string $path): ?string
    {
        try {
            $content = $this->mcpService->filesystem()->readFile($path);
            
            return $content !== false ? $content : null;
        } catch (\Exception $e) {
            Log::error('File read failed', [
                'path' => $path,
                'message' => $e->getMessage()
            ]);
            
            return null;
        }
    }

    /**
     * Scrive contenuto in un file.
     *
     * @param string $path Percorso del file
     * @param string $content Contenuto da scrivere
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function write(string $path, string $content): bool
    {
        try {
            // Assicurati che la directory esista
            $directory = dirname($path);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            return $this->mcpService->filesystem()->writeFile($path, $content);
        } catch (\Exception $e) {
            Log::error('File write failed', [
                'path' => $path,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Elimina un file.
     *
     * @param string $path Percorso del file
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function delete(string $path): bool
    {
        try {
            return $this->mcpService->filesystem()->deleteFile($path);
        } catch (\Exception $e) {
            Log::error('File delete failed', [
                'path' => $path,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Elenca i file in una directory.
     *
     * @param string $directory Percorso della directory
     *
     * @return array<int, array<string, mixed>> Lista dei file
     */
    public function list(string $directory): array
    {
        try {
            return $this->mcpService->filesystem()->listDirectory($directory);
        } catch (\Exception $e) {
            Log::error('Directory list failed', [
                'directory' => $directory,
                'message' => $e->getMessage()
            ]);
            
            return [];
        }
    }

    /**
     * Copia un file.
     *
     * @param string $source Percorso del file di origine
     * @param string $destination Percorso del file di destinazione
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function copy(string $source, string $destination): bool
    {
        try {
            $content = $this->read($source);
            
            if ($content === null) {
                return false;
            }
            
            return $this->write($destination, $content);
        } catch (\Exception $e) {
            Log::error('File copy failed', [
                'source' => $source,
                'destination' => $destination,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Verifica se un file esiste.
     *
     * @param string $path Percorso del file
     *
     * @return bool True se il file esiste, false altrimenti
     */
    public function exists(string $path): bool
    {
        try {
            return $this->mcpService->filesystem()->fileExists($path);
        } catch (\Exception $e) {
            Log::error('File exists check failed', [
                'path' => $path,
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}
```

### 4. Sequential Thinking

**Scopo**: Analisi e ottimizzazione di codice e configurazioni.

**Casi d'uso**:
- Analisi della qualità del codice
- Generazione di suggerimenti di ottimizzazione
- Debugging di problemi complessi
- Documentazione automatica del codice

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Xot\DataObjects\CodeAnalysisData;
use Illuminate\Support\Facades\Log;

class AnalyzeCodeAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Analizza un frammento di codice.
     *
     * @param string $code Il codice da analizzare
     * @param string $language Il linguaggio del codice (php, javascript, etc.)
     *
     * @return CodeAnalysisData I dati dell'analisi
     */
    public function execute(string $code, string $language = 'php'): CodeAnalysisData
    {
        try {
            $analysis = $this->mcpService->sequentialThinking()->analyze(
                $code,
                ['code_quality', 'performance', 'security', 'best_practices']
            );
            
            $qualityScore = $analysis['code_quality']['score'] ?? 0;
            $issues = [];
            $suggestions = [];
            
            // Raccoglie i problemi
            foreach (['code_quality', 'performance', 'security', 'best_practices'] as $aspect) {
                if (isset($analysis[$aspect]['issues']) && is_array($analysis[$aspect]['issues'])) {
                    foreach ($analysis[$aspect]['issues'] as $issue) {
                        $issues[] = [
                            'aspect' => $aspect,
                            'description' => $issue['description'] ?? $issue,
                            'severity' => $issue['severity'] ?? 'medium',
                            'line' => $issue['line'] ?? null
                        ];
                    }
                }
                
                if (isset($analysis[$aspect]['suggestions']) && is_array($analysis[$aspect]['suggestions'])) {
                    foreach ($analysis[$aspect]['suggestions'] as $suggestion) {
                        $suggestions[] = [
                            'aspect' => $aspect,
                            'description' => $suggestion['description'] ?? $suggestion,
                            'priority' => $suggestion['priority'] ?? 'medium',
                            'line' => $suggestion['line'] ?? null
                        ];
                    }
                }
            }
            
            return new CodeAnalysisData(
                language: $language,
                qualityScore: $qualityScore,
                issues: $issues,
                suggestions: $suggestions
            );
        } catch (\Exception $e) {
            Log::error('Code analysis failed', [
                'language' => $language,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return new CodeAnalysisData(
                language: $language,
                qualityScore: 0,
                issues: [
                    [
                        'aspect' => 'error',
                        'description' => 'Analisi fallita: ' . $e->getMessage(),
                        'severity' => 'high',
                        'line' => null
                    ]
                ],
                suggestions: []
            );
        }
    }
}
```

### 5. Postgres

**Scopo**: Interazione avanzata con database PostgreSQL per moduli che utilizzano questo DBMS.

**Casi d'uso**:
- Query complesse su database PostgreSQL
- Analisi e ottimizzazione di query PostgreSQL
- Gestione di dati geografici con PostGIS
- Operazioni avanzate su JSON e JSONB

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;

class PostgresService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Esegue una query SQL su PostgreSQL.
     *
     * @param string $query La query SQL
     * @param array<mixed> $params I parametri della query
     *
     * @return array<int, array<string, mixed>> I risultati della query
     */
    public function executeQuery(string $query, array $params = []): array
    {
        try {
            return $this->mcpService->postgres()->executeQuery($query, $params);
        } catch (\Exception $e) {
            Log::error('PostgreSQL query execution failed', [
                'query' => $query,
                'params' => $params,
                'message' => $e->getMessage()
            ]);
            
            return [];
        }
    }

    /**
     * Analizza una query SQL PostgreSQL.
     *
     * @param string $query La query SQL
     * @param array<mixed> $params I parametri della query
     *
     * @return array<string, mixed> I risultati dell'analisi
     */
    public function analyzeQuery(string $query, array $params = []): array
    {
        try {
            return $this->mcpService->postgres()->analyzeQuery($query, $params);
        } catch (\Exception $e) {
            Log::error('PostgreSQL query analysis failed', [
                'query' => $query,
                'params' => $params,
                'message' => $e->getMessage()
            ]);
            
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Ottiene la struttura di una tabella PostgreSQL.
     *
     * @param string $table Il nome della tabella
     *
     * @return array<string, mixed> La struttura della tabella
     */
    public function getTableStructure(string $table): array
    {
        try {
            $query = "
                SELECT column_name, data_type, is_nullable, column_default
                FROM information_schema.columns
                WHERE table_name = $1
                ORDER BY ordinal_position
            ";
            
            return $this->executeQuery($query, [$table]);
        } catch (\Exception $e) {
            Log::error('PostgreSQL get table structure failed', [
                'table' => $table,
                'message' => $e->getMessage()
            ]);
            
            return [];
        }
    }

    /**
     * Ottiene le tabelle del database PostgreSQL.
     *
     * @return array<int, string> Le tabelle del database
     */
    public function getTables(): array
    {
        try {
            $query = "
                SELECT table_name
                FROM information_schema.tables
                WHERE table_schema = 'public'
                ORDER BY table_name
            ";
            
            $results = $this->executeQuery($query);
            
            return array_column($results, 'table_name');
        } catch (\Exception $e) {
            Log::error('PostgreSQL get tables failed', [
                'message' => $e->getMessage()
            ]);
            
            return [];
        }
    }
}
```

## Integrazione con i Contratti

Il modulo Xot definisce molti contratti che vengono utilizzati in tutto il progetto. È importante integrare i server MCP con questi contratti per mantenere la coerenza e il disaccoppiamento del codice.

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

interface CacheServiceContract
{
    /**
     * Memorizza un valore in cache.
     *
     * @param string $key La chiave
     * @param mixed $value Il valore
     * @param int $ttl Tempo di vita in secondi
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function set(string $key, mixed $value, int $ttl = 3600): bool;

    /**
     * Recupera un valore dalla cache.
     *
     * @param string $key La chiave
     * @param mixed $default Valore di default se la chiave non esiste
     *
     * @return mixed Il valore memorizzato o il valore di default
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Elimina un valore dalla cache.
     *
     * @param string $key La chiave
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function delete(string $key): bool;

    /**
     * Verifica se una chiave esiste in cache.
     *
     * @param string $key La chiave
     *
     * @return bool True se la chiave esiste, false altrimenti
     */
    public function has(string $key): bool;
}
```

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Xot\Contracts\CacheServiceContract;
use Modules\Xot\Services\CacheService;
use Modules\AI\Services\Contracts\MCPServiceContract;

class XotServiceProvider extends XotBaseServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(CacheServiceContract::class, function ($app) {
            return new CacheService(
                $app->make(MCPServiceContract::class)
            );
        });
        
        // Altre registrazioni...
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurazione, pubblicazione, ecc.
    }
}
```

## Integrazione con i Data Objects

Il modulo Xot utilizza Spatie Data Objects per strutture dati complesse. Ecco alcuni esempi di Data Objects per l'integrazione con i server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\DataObjects;

use Spatie\LaravelData\Data;

class QueryAnalysisData extends Data
{
    /**
     * @param string $originalQuery Query originale
     * @param string $optimizedQuery Query ottimizzata
     * @param int $estimatedRows Numero stimato di righe
     * @param bool $usesIndexes Se la query utilizza indici
     * @param array<string> $tableScans Tabelle con table scan
     * @param array<string> $recommendations Suggerimenti di ottimizzazione
     */
    public function __construct(
        public readonly string $originalQuery,
        public readonly string $optimizedQuery,
        public readonly int $estimatedRows,
        public readonly bool $usesIndexes,
        public readonly array $tableScans,
        public readonly array $recommendations
    ) {
    }
}
```

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\DataObjects;

use Spatie\LaravelData\Data;

class CodeAnalysisData extends Data
{
    /**
     * @param string $language Linguaggio del codice
     * @param int $qualityScore Punteggio di qualità
     * @param array<int, array<string, mixed>> $issues Problemi rilevati
     * @param array<int, array<string, mixed>> $suggestions Suggerimenti
     */
    public function __construct(
        public readonly string $language,
        public readonly int $qualityScore,
        public readonly array $issues,
        public readonly array $suggestions
    ) {
    }
}
```

## Conclusione

L'integrazione dei server MCP con il modulo Xot consente di migliorare significativamente le funzionalità di base del progetto, fornendo interazione avanzata con database, gestione efficiente della cache, operazioni avanzate sui file e analisi del codice. Seguendo le linee guida e gli esempi forniti in questo documento, è possibile implementare queste funzionalità in modo conforme alle regole di sviluppo stabilite per i progetti base_predict_fila3_mono.
