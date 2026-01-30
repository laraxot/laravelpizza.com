<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Safe\Exceptions\JsonException;

use function Safe\json_decode;

/**
 * Class GenerateDbDocumentationCommand.
 */
class GenerateDbDocumentationCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'db:docs:generate {--schema=database/schema.json} {--output=docs/database.md}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Generate database documentation from schema file';

    /**
     * Execute the console command.
     *
     * @throws JsonException
     */
    public function handle(): int
    {
        $formPathOption = $this->option('schema');
        $outputPathOption = $this->option('output');

        $formPath = is_string($formPathOption) ? $formPathOption : 'database/schema.json';
        $outputPath = is_string($outputPathOption) ? $outputPathOption : 'docs/database.md';

        if (! File::exists($formPath)) {
            $this->error("Schema file not found: {$formPath}");

            return 1;
        }

        $formContent = File::get($formPath);
        $formDecoded = json_decode($formContent, true);

        if (! is_array($formDecoded)) {
            $this->error('Invalid schema file format');

            return 1;
        }

        $documentation = $this->generateDocumentation($formDecoded);

        File::put($outputPath, $documentation);
        $this->info("Documentation generated at: {$outputPath}");

        return 0;
    }

    /**
     * Generate documentation from schema.
     *
     * @param  array<mixed, mixed>  $form
     */
    protected function generateDocumentation(array $form): string
    {
        $doc = "# Database Documentation\n\n";
        $doc .= 'Generated on: '.now()->format('Y-m-d H:i:s')."\n\n";

        if (isset($form['tables']) && is_array($form['tables'])) {
            foreach ($form['tables'] as $tableName => $table) {
                if (is_string($tableName) && is_array($table)) {
                    $doc .= $this->generateTableDocumentation($tableName, $table);
                }
            }
        }

        if (isset($form['relationships']) && is_array($form['relationships'])) {
            $doc .= "\n## Relationships\n\n";
            foreach ($form['relationships'] as $relationship) {
                if (is_array($relationship)) {
                    $doc .= $this->generateRelationshipDocumentation($relationship);
                }
            }
        }

        return $doc;
    }

    /**
     * Generate documentation for a table.
     *
     * @param  array<mixed, mixed>  $table
     */
    protected function generateTableDocumentation(string $tableName, array $table): string
    {
        $doc = "## Table: `{$tableName}`\n\n";

        if (isset($table['comment']) && is_string($table['comment']) && ! empty($table['comment'])) {
            $doc .= "{$table['comment']}\n\n";
        }

        $doc .= "### Columns\n\n";
        $doc .= "| Column | Type | Nullable | Default | Comment |\n";
        $doc .= "|--------|------|----------|---------|----------|\n";

        if (isset($table['columns']) && is_array($table['columns'])) {
            foreach ($table['columns'] as $columnName => $column) {
                if (is_string($columnName) && is_array($column)) {
                    $type = isset($column['type']) && is_string($column['type']) ? $column['type'] : 'unknown';
                    $nullable = isset($column['nullable']) && $column['nullable'] ? 'Yes' : 'No';
                    $default = isset($column['default']) ? (string) $column['default'] : 'NULL';
                    $comment = isset($column['comment']) && is_string($column['comment']) ? $column['comment'] : '';

                    $doc .= sprintf(
                        "| `%s` | %s | %s | %s | %s |\n",
                        $columnName,
                        $type,
                        $nullable,
                        $default,
                        $comment
                    );
                }
            }
        }

        if (isset($table['indices']) && is_array($table['indices'])) {
            $doc .= "\n### Indices\n\n";
            $doc .= "| Name | Columns | Type | Unique |\n";
            $doc .= "|------|---------|------|--------|\n";

            foreach ($table['indices'] as $index) {
                if (is_array($index)) {
                    $columns = 'N/A';
                    if (isset($index['columns']) && is_array($index['columns'])) {
                        $columnNames = array_column($index['columns'], 'name');
                        if (! empty($columnNames)) {
                            $columns = implode(', ', $columnNames);
                        }
                    }

                    $name = isset($index['name']) && is_string($index['name']) ? $index['name'] : 'unknown';
                    $type = isset($index['type']) && is_string($index['type']) ? $index['type'] : 'unknown';
                    $unique = isset($index['unique']) && $index['unique'] ? 'Yes' : 'No';

                    $doc .= sprintf(
                        "| `%s` | %s | %s | %s |\n",
                        $name,
                        $columns,
                        $type,
                        $unique
                    );
                }
            }
        }

        if (isset($table['foreign_keys']) && is_array($table['foreign_keys'])) {
            $doc .= "\n### Foreign Keys\n\n";
            $doc .= "| Column | References |\n";
            $doc .= "|--------|------------|\n";

            foreach ($table['foreign_keys'] as $fk) {
                if (is_array($fk)) {
                    $column = isset($fk['column']) && is_string($fk['column']) ? $fk['column'] : 'unknown';
                    $refTable = isset($fk['references_table']) && is_string($fk['references_table']) ? $fk['references_table'] : 'unknown';
                    $refColumn = isset($fk['references_column']) && is_string($fk['references_column']) ? $fk['references_column'] : 'unknown';

                    $doc .= sprintf(
                        "| `%s` | `%s`.`%s` |\n",
                        $column,
                        $refTable,
                        $refColumn
                    );
                }
            }
        }

        return $doc."\n";
    }

    /**
     * Generate documentation for a relationship.
     *
     * @param  array<mixed, mixed>  $relationship
     */
    protected function generateRelationshipDocumentation(array $relationship): string
    {
        $localTable = isset($relationship['local_table']) && is_string($relationship['local_table']) ? $relationship['local_table'] : 'unknown';
        $localColumn = isset($relationship['local_column']) && is_string($relationship['local_column']) ? $relationship['local_column'] : 'unknown';
        $foreignTable = isset($relationship['foreign_table']) && is_string($relationship['foreign_table']) ? $relationship['foreign_table'] : 'unknown';
        $foreignColumn = isset($relationship['foreign_column']) && is_string($relationship['foreign_column']) ? $relationship['foreign_column'] : 'unknown';
        $constraintName = isset($relationship['constraint_name']) && is_string($relationship['constraint_name']) ? $relationship['constraint_name'] : 'unknown';
        $type = isset($relationship['type']) && is_string($relationship['type']) ? $relationship['type'] : 'unknown';

        return sprintf(
            "- `%s`.`%s` %s `%s`.`%s` (Constraint: `%s`)\n",
            $localTable,
            $localColumn,
            $this->getRelationshipArrow($type),
            $foreignTable,
            $foreignColumn,
            $constraintName
        );
    }

    /**
     * Get arrow representation for relationship type.
     */
    protected function getRelationshipArrow(string $type): string
    {
        return match ($type) {
            'belongsTo' => '→',
            'hasMany' => '←',
            'hasOne' => '⟶',
            default => '↔',
        };
    }
}
