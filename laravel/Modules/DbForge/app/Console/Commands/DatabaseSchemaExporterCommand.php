<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function Safe\json_encode;

class DatabaseSchemaExporterCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'xot:export-db-schema {connection? : Nome della connessione database}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Esporta lo schema completo di un database in formato JSON';

    /**
     * Esegui il comando console.
     */
    public function handle(): int
    {
        $connectionArg = $this->argument('connection');
        $defaultConnection = config('database.default');
        $connection = is_string($connectionArg) ? $connectionArg : (is_string($defaultConnection) ? $defaultConnection : 'mysql');

        $this->info("Esportazione dello schema del database dalla connessione: {$connection}");

        // Ottieni il nome del database dalla configurazione
        $databaseNameConfig = config("database.connections.{$connection}.database");
        $databaseName = is_string($databaseNameConfig) ? $databaseNameConfig : '';

        if (empty($databaseName)) {
            $this->error("Impossibile trovare il database per la connessione {$connection}");

            return 1;
        }

        $this->info("Database: {$databaseName}");

        // Ottieni la lista di tutte le tabelle
        $tables = $this->getTables($connection);

        if (empty($tables)) {
            $this->error("Nessuna tabella trovata nel database {$databaseName}");

            return 1;
        }

        $this->info('Trovate '.count($tables).' tabelle.');

        // Inizializza l'array che conterrà tutte le informazioni
        $databaseSchema = [
            'database' => $databaseName,
            'connection' => $connection,
            'tables' => [],
        ];

        $progressBar = $this->output->createProgressBar(count($tables));
        $progressBar->start();

        foreach ($tables as $table) {
            $databaseSchema['tables'][$table] = $this->getTableInfo($connection, $table);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        // Aggiungi informazioni sulle relazioni tra tabelle
        $databaseSchema['relationships'] = $this->getRelationships($connection, $tables);

        // Crea directory se non esiste
        $outputDir = base_path('docs');
        if (! File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }

        // Salva i dati in un file JSON
        $filename = "{$outputDir}/{$databaseName}_schema.json";
        File::put($filename, json_encode($databaseSchema, JSON_PRETTY_PRINT));

        $this->info("Schema del database esportato con successo in: {$filename}");

        return 0;
    }

    /**
     * Ottieni la lista di tutte le tabelle nel database.
     *
     * @return list<string>
     */
    private function getTables(string $connection): array
    {
        // Versione più moderna e compatibile per ottenere l'elenco delle tabelle
        $databaseName = DB::connection($connection)->getDatabaseName();
        $tables = DB::connection($connection)
            ->select("SELECT table_name FROM information_schema.tables WHERE table_schema = ? AND table_type = 'BASE TABLE'", [$databaseName]);

        return array_values(array_filter(array_map(function ($table): ?string {
            // ✅ isset() invece di property_exists per oggetti stdClass (più sicuro)
            if (! is_object($table) || ! isset($table->table_name)) {
                return null;
            }

            $tableName = $table->table_name;

            return is_string($tableName) ? $tableName : null;
        }, $tables)));
    }

    /**
     * Ottieni informazioni dettagliate su una tabella.
     */
    private function getTableInfo(string $connection, string $table): array
    {
        $columns = $this->getTableColumns($connection, $table);
        $indexes = $this->getTableIndexes($connection, $table);
        $primaryKey = $this->getTablePrimaryKey($connection, $table);
        $foreignKeys = $this->getTableForeignKeys($connection, $table);
        $recordCount = $this->getTableRecordCount($connection, $table);
        $sampleData = $this->getTableSampleData($connection, $table);

        return [
            'name' => $table,
            'columns' => $columns,
            'indexes' => $indexes,
            'primary_key' => $primaryKey,
            'foreign_keys' => $foreignKeys,
            'record_count' => $recordCount,
            'sample_data' => $sampleData,
        ];
    }

    /**
     * Ottieni informazioni su tutte le colonne di una tabella.
     *
     * @return array<string, array<string, mixed>>
     */
    private function getTableColumns(string $connection, string $table): array
    {
        $columns = [];
        $columnInfo = DB::connection($connection)->select("SHOW FULL COLUMNS FROM `{$table}`");

        foreach ($columnInfo as $column) {
            if (! is_object($column)) {
                continue;
            }

            // ✅ isset() invece di property_exists per oggetti stdClass (più sicuro)
            $field = isset($column->Field) ? $column->Field : null;
            if (! is_string($field)) {
                continue;
            }

            $columns[$field] = [
                'type' => isset($column->Type) ? $column->Type : '',
                'nullable' => isset($column->Null) && $column->Null === 'YES',
                'default' => isset($column->Default) ? $column->Default : null,
                'comment' => isset($column->Comment) ? ($column->Comment ?? '') : '',
                'extra' => isset($column->Extra) ? ($column->Extra ?? '') : '',
            ];
        }

        return $columns;
    }

    /**
     * Ottieni gli indici di una tabella.
     *
     * @return array<string, array<string, mixed>>
     */
    private function getTableIndexes(string $connection, string $table): array
    {
        $indexes = [];
        $indexInfo = DB::connection($connection)->select("SHOW INDEX FROM `{$table}`");

        foreach ($indexInfo as $index) {
            if (! is_object($index)) {
                continue;
            }

            // ✅ isset() invece di property_exists per oggetti stdClass (più sicuro)
            $keyName = isset($index->Key_name) ? $index->Key_name : null;
            if (! is_string($keyName)) {
                continue;
            }

            if (! isset($indexes[$keyName])) {
                $nonUnique = isset($index->Non_unique) ? $index->Non_unique : 1;
                $indexes[$keyName] = [
                    'columns' => [],
                    'unique' => ! $nonUnique,
                ];
            }

            // ✅ isset() invece di property_exists per oggetti stdClass (più sicuro)
            $columnName = isset($index->Column_name) ? $index->Column_name : null;
            if (is_string($columnName)) {
                $indexes[$keyName]['columns'][] = $columnName;
            }
        }

        return $indexes;
    }

    /**
     * Ottieni la chiave primaria di una tabella.
     *
     * @return array{name: string, columns: list<string>}|null
     */
    private function getTablePrimaryKey(string $connection, string $table): ?array
    {
        $indexInfo = DB::connection($connection)->select("SHOW INDEX FROM `{$table}` WHERE Key_name = 'PRIMARY'");

        if (empty($indexInfo)) {
            return null;
        }

        $primaryKey = [
            'name' => 'PRIMARY',
            'columns' => [],
        ];

        foreach ($indexInfo as $index) {
            if (! is_object($index)) {
                continue;
            }

            // ✅ isset() invece di property_exists per oggetti stdClass (più sicuro)
            $columnName = isset($index->Column_name) ? $index->Column_name : null;
            if (is_string($columnName)) {
                $primaryKey['columns'][] = $columnName;
            }
        }

        return $primaryKey;
    }

    /**
     * Ottieni le chiavi esterne di una tabella.
     *
     * @return array<string, array<string, mixed>>
     */
    private function getTableForeignKeys(string $connection, string $table): array
    {
        $foreignKeys = [];
        $databaseName = DB::connection($connection)->getDatabaseName();

        // Utilizziamo query SQL dirette per ottenere le chiavi esterne
        $fkResults = DB::connection($connection)->select('
            SELECT
                k.CONSTRAINT_NAME as constraint_name,
                k.COLUMN_NAME as column_name,
                k.REFERENCED_TABLE_NAME as referenced_table,
                k.REFERENCED_COLUMN_NAME as referenced_column
            FROM information_schema.KEY_COLUMN_USAGE k
            WHERE
                k.TABLE_SCHEMA = ? AND
                k.TABLE_NAME = ? AND
                k.REFERENCED_TABLE_NAME IS NOT NULL
            ORDER BY constraint_name
        ', [$databaseName, $table]);

        // Raggruppiamo le chiavi esterne per nome del vincolo
        foreach ($fkResults as $fk) {
            if (! is_object($fk)) {
                continue;
            }

            // ✅ isset() invece di property_exists per oggetti stdClass (più sicuro)
            $constraintName = isset($fk->constraint_name) ? $fk->constraint_name : null;
            if (! is_string($constraintName)) {
                continue;
            }

            if (! isset($foreignKeys[$constraintName])) {
                $referencedTable = isset($fk->referenced_table) ? $fk->referenced_table : '';
                $foreignKeys[$constraintName] = [
                    'name' => $constraintName,
                    'local_columns' => [],
                    'foreign_table' => $referencedTable,
                    'foreign_columns' => [],
                ];
            }

            // ✅ isset() invece di property_exists per oggetti stdClass (più sicuro)
            $columnName = isset($fk->column_name) ? $fk->column_name : null;
            $referencedColumn = isset($fk->referenced_column) ? $fk->referenced_column : null;

            if (is_string($columnName)) {
                $foreignKeys[$constraintName]['local_columns'][] = $columnName;
            }

            if (is_string($referencedColumn)) {
                $foreignKeys[$constraintName]['foreign_columns'][] = $referencedColumn;
            }
        }

        return $foreignKeys;
    }

    /**
     * Ottieni il numero di record in una tabella.
     */
    private function getTableRecordCount(string $connection, string $table): int
    {
        return DB::connection($connection)->table($table)->count();
    }

    /**
     * Ottieni un campione di dati dalla tabella.
     */
    private function getTableSampleData(string $connection, string $table, int $limit = 5): array
    {
        try {
            return DB::connection($connection)->table($table)->limit($limit)->get()->toArray();
        } catch (Exception $e) {
            $this->warn("Impossibile ottenere dati di esempio per la tabella {$table}: ".$e->getMessage());

            return [];
        }
    }

    /**
     * Analizza le relazioni tra le tabelle.
     *
     * @param  list<string>  $tables
     * @return list<array<string, mixed>>
     */
    private function getRelationships(string $connection, array $tables): array
    {
        $relationships = [];

        foreach ($tables as $table) {
            if (! is_string($table)) {
                continue;
            }

            $foreignKeys = $this->getTableForeignKeys($connection, $table);

            foreach ($foreignKeys as $name => $foreignKey) {
                if (! is_array($foreignKey)) {
                    continue;
                }

                $relationships[] = [
                    'type' => 'belongs_to',
                    'from_table' => $table,
                    'from_columns' => $foreignKey['local_columns'] ?? [],
                    'to_table' => $foreignKey['foreign_table'] ?? '',
                    'to_columns' => $foreignKey['foreign_columns'] ?? [],
                ];

                // Aggiungi anche la relazione inversa (has_many)
                $relationships[] = [
                    'type' => 'has_many',
                    'from_table' => $foreignKey['foreign_table'] ?? '',
                    'from_columns' => $foreignKey['foreign_columns'] ?? [],
                    'to_table' => $table,
                    'to_columns' => $foreignKey['local_columns'] ?? [],
                ];
            }
        }

        return $relationships;
    }
}
