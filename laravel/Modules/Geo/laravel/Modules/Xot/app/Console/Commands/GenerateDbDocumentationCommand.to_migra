<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Symfony\Component\Console\Helper\TableSeparator;

class GenerateDbDocumentationCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'xot:generate-db-documentation {schema_file : Percorso del file schema JSON} {output_dir? : Directory di output per i file markdown}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Genera documentazione in formato Markdown per lo schema del database';

    /**
     * Esegui il comando console.
     */
    public function handle(): int
    {
        $schemaFilePath = $this->argument('schema_file');
        $outputDir = $this->argument('output_dir') ?? base_path('docs/database');

        if (!File::exists($schemaFilePath)) {
            $this->error("Il file schema {$schemaFilePath} non esiste!");
            return 1;
        }

        $schemaContent = File::get($schemaFilePath);
        try {
            $schema = \Safe\json_decode($schemaContent, true);
        } catch (\Exception $e) {
            $this->error("Errore nella decodifica del file JSON: " . $e->getMessage());
            return 1;
        }

        // Crea directory se non esiste
        if (!File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }

        // Genera il file README.md principale con l'indice
        $this->generateMainReadme($schema, $outputDir);

        // Genera file per ogni tabella
        $progressBar = $this->output->createProgressBar(count($schema['tables']));
        $progressBar->start();

        foreach ($schema['tables'] as $tableName => $tableInfo) {
            if (!is_array($tableInfo) || !is_array($schema['relationships'] ?? [])) {
                $this->error("Errore: dati non validi per la tabella {$tableName}");
                continue;
            }
            $this->generateTableDoc($tableName, $tableInfo, $schema['relationships'], $outputDir);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Documentazione generata con successo in: {$outputDir}");

        return 0;
    }

    /**
     * Genera il file README.md principale con l'indice.
     */
    protected function generateMainReadme(array $schema, string $outputDir): void
    {
        $database = $schema['database'];
        $tableCount = count($schema['tables']);
        
        $content = <<<MARKDOWN
# Documentazione Database: {$database}

## Panoramica
Questo documento fornisce una documentazione completa per il database **{$database}**.

- **Database**: {$database}
- **Connessione**: {$schema['connection']}
- **Tabelle**: {$tableCount}

## Indice delle Tabelle

| Nome Tabella | Descrizione | Numero Record |
|--------------|-------------|---------------|

MARKDOWN;

        foreach ($schema['tables'] as $tableName => $tableInfo) {
            $recordCount = $tableInfo['record_count'];
            $fileName = $tableName . '.md';
            $content .= "| [{$tableName}]({$fileName}) | | {$recordCount} |\n";
        }

        $content .= "\n\n## Diagramma ER\n\n";
        $content .= "```mermaid\nerDiagram\n";

        // Aggiungi gli ER per le relazioni
        $processedRelationships = [];
        foreach ($schema['relationships'] as $relationship) {
            if ($relationship['type'] === 'belongs_to') {
                $from = $relationship['from_table'];
                $to = $relationship['to_table'];
                $key = "{$from}_{$to}";

                if (!in_array($key, $processedRelationships)) {
                    $content .= "    {$from} ||--o{ {$to} : \"\"\n";
                    $processedRelationships[] = $key;
                }
            }
        }

        $content .= "```\n";

        File::put($outputDir . '/README.md', $content);
    }

    /**
     * Genera documentazione per una singola tabella.
     */
    protected function generateTableDoc(string $tableName, array $tableInfo, array $relationships, string $outputDir): void
    {
        $columns = $tableInfo['columns'];
        $primaryKey = $tableInfo['primary_key'];
        $indexes = $tableInfo['indexes'];
        $foreignKeys = $tableInfo['foreign_keys'];
        $recordCount = $tableInfo['record_count'];

        $primaryKeyColumns = $primaryKey ? implode(', ', $primaryKey['columns']) : 'Nessuna';

        $content = <<<MARKDOWN
# Tabella: {$tableName}

## Descrizione
Tabella `{$tableName}` nel database.

- **Numero di record**: {$recordCount}
- **Chiave primaria**: {$primaryKeyColumns}

## Struttura

| Colonna | Tipo | Nullable | Default | Extra | Commento |
|---------|------|----------|---------|-------|----------|

MARKDOWN;

        foreach ($columns as $columnName => $column) {
            $type = '';
            if (isset($column['type']) && (is_string($column['type']) || is_numeric($column['type']))) {
                $type = is_string($column) ? $column : (string) $column['type'];
            }

            $nullable = isset($column['nullable']) && $column['nullable'] ? 'Sì' : 'No';

            $default = 'NULL';
            if (isset($column['default']) && (is_string($column['default']) || is_numeric($column['default']))) {
                $default = is_string($column) ? $column : (string) $column['default'];
            }

            $extra = '';
            if (isset($column['extra']) && (is_string($column['extra']) || is_numeric($column['extra']))) {
                $extra = is_string($column) ? $column : (string) $column['extra'];
            }

            $comment = '';
            if (isset($column['comment']) && (is_string($column['comment']) || is_numeric($column['comment']))) {
                $comment = is_string($column) ? $column : (string) $column['comment'];
            }
            
            $columnNameSafe = is_string($columnName) ? $columnName : '';
            $content .= "| {$columnNameSafe} | {$type} | {$nullable} | {$default} | {$extra} | {$comment} |\n";
        }

        if (is_array($indexes) && !empty($indexes)) {
            $content .= "\n## Indici\n\n";
            $content .= "| Nome | Colonne | Unico |\n";
            $content .= "|------|---------|-------|\n";

            foreach ($indexes as $indexName => $index) {
                if (!is_array($index)) {
                    continue;
                }
                if ($indexName === 'PRIMARY') {
                    continue;
                }
                
                $columnsArray = isset($index['columns']) && is_array($index['columns']) ? $index['columns'] : [];
                $columns = implode(', ', $columnsArray);
                $unique = isset($index['unique']) && $index['unique'] ? 'Sì' : 'No';
                $indexNameSafe = is_string($indexName) ? $indexName : '';
                
                $content .= "| {$indexNameSafe} | {$columns} | {$unique} |\n";
            }
        }

        if (!empty($foreignKeys) && count($foreignKeys) > 0) {
            $content .= "\n## Chiavi Esterne\n\n";
            $content .= "| Nome | Colonne | Tabella Riferimento | Colonne Riferimento |\n";
            $content .= "|------|---------|---------------------|--------------------|\n";

            foreach ($foreignKeys as $foreignKeyName => $foreignKey) {
                // Verifica che gli array necessari esistano e usa array vuoti se non esistono
                $localColumns = $foreignKey['local_columns'] ?? $foreignKey['columns'] ?? [];
                $refTable = $foreignKey['foreign_table'] ?? $foreignKey['references_table'] ?? 'unknown_table';
                $refColumns = $foreignKey['foreign_columns'] ?? $foreignKey['references_columns'] ?? [];
                
                $columns = implode(', ', $localColumns);
                $refColumnsStr = implode(', ', $refColumns);
                
                $content .= "| {$foreignKeyName} | {$columns} | {$refTable} | {$refColumnsStr} |\n";
            }
        }

        // Relazioni
        $tableRelationships = $this->getTableRelationships($tableName, $relationships);
        
        if (!empty($tableRelationships)) {
            $content .= "\n## Relazioni\n\n";
            
            if (!empty($tableRelationships['belongs_to'])) {
                $content .= "### Belongs To\n\n";
                $content .= "| Tabella | Chiave Esterna | Chiave Riferimento |\n";
                $content .= "|---------|---------------|-------------------|\n";
                
                foreach ($tableRelationships['belongs_to'] as $relation) {
                    $targetTable = $relation['to_table'];
                    $foreignKey = implode(', ', $relation['from_columns']);
                    $targetKey = implode(', ', $relation['to_columns']);
                    
                    $content .= "| [{$targetTable}]({$targetTable}.md) | {$foreignKey} | {$targetKey} |\n";
                }
            }
            
            if (!empty($tableRelationships['has_many'])) {
                $content .= "\n### Has Many\n\n";
                $content .= "| Tabella | Chiave Esterna | Chiave Locale |\n";
                $content .= "|---------|---------------|-------------|\n";
                
                foreach ($tableRelationships['has_many'] as $relation) {
                    $targetTable = $relation['to_table'];
                    $foreignKey = implode(', ', $relation['to_columns']);
                    $localKey = implode(', ', $relation['from_columns']);
                    
                    $content .= "| [{$targetTable}]({$targetTable}.md) | {$foreignKey} | {$localKey} |\n";
                }
            }
        }

        // Dati di esempio
        if (!empty($tableInfo['sample_data'])) {
            $content .= "\n## Dati di Esempio\n\n";
            $content .= "```json\n";
            try {
                $content .= \Safe\json_encode($tableInfo['sample_data'], JSON_PRETTY_PRINT);
            } catch (\Exception $e) {
                $content .= "Errore nella formattazione dei dati di esempio: " . $e->getMessage();
            }
            $content .= "\n```\n";
        }

        File::put($outputDir . '/' . $tableName . '.md', $content);
    }

    /**
     * Ottiene le relazioni per una tabella specifica.
     */
    protected function getTableRelationships(string $tableName, array $relationships): array
    {
        $tableRelationships = [
            'belongs_to' => [],
            'has_many' => [],
        ];
        
        foreach ($relationships as $relationship) {
            // Verifica che tutti i campi necessari esistano
            if (!isset($relationship['from_table']) || !isset($relationship['to_table']) || 
                !isset($relationship['type']) || 
                !isset($relationship['from_columns']) || !isset($relationship['to_columns']) ||
                empty($relationship['from_columns']) || empty($relationship['to_columns'])) {
                continue;
            }
            
            if ($relationship['from_table'] === $tableName && $relationship['type'] === 'belongs_to') {
                $tableRelationships['belongs_to'][] = $relationship;
            } elseif ($relationship['from_table'] === $tableName && $relationship['type'] === 'has_many') {
                $tableRelationships['has_many'][] = $relationship;
            }
        }
        
        return $tableRelationships;
    }
} 