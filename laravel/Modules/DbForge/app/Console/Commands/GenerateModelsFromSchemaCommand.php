<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Safe\Exceptions\DatetimeException;
use Safe\Exceptions\JsonException;
use Safe\Exceptions\PcreException;
use Webmozart\Assert\Assert;

use function Safe\date;
use function Safe\json_decode;
use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Class GenerateModelsFromSchemaCommand.
 */
class GenerateModelsFromSchemaCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'db:models:generate {--schema=database/schema.json} {--output=app/Models} {--namespace=App\\Models}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Generate Eloquent models from database schema';

    /**
     * Tipi di dati SQL e loro corrispondenze in PHP/Laravel.
     *
     * @var array<string, string>
     */
    protected $typeMappings = [
        'int' => 'integer',
        'tinyint' => 'boolean',
        'smallint' => 'integer',
        'mediumint' => 'integer',
        'bigint' => 'integer',
        'float' => 'float',
        'double' => 'double',
        'decimal' => 'decimal',
        'char' => 'string',
        'varchar' => 'string',
        'tinytext' => 'string',
        'text' => 'string',
        'mediumtext' => 'string',
        'longtext' => 'string',
        'json' => 'json',
        'binary' => 'binary',
        'varbinary' => 'binary',
        'blob' => 'binary',
        'tinyblob' => 'binary',
        'mediumblob' => 'binary',
        'longblob' => 'binary',
        'date' => 'date',
        'datetime' => 'datetime',
        'timestamp' => 'timestamp',
        'time' => 'time',
        'year' => 'integer',
        'enum' => 'string',
        'set' => 'string',
        'bit' => 'boolean',
    ];

    /**
     * Esegui il comando console.
     *
     * @throws JsonException
     * @throws PcreException
     * @throws DatetimeException
     */
    public function handle(): int
    {
        $formPathOption = $this->option('schema');
        $outputPathOption = $this->option('output');
        $namespaceOption = $this->option('namespace');

        $formPath = is_string($formPathOption) ? $formPathOption : 'database/schema.json';
        $outputPath = is_string($outputPathOption) ? $outputPathOption : 'app/Models';
        $namespace = is_string($namespaceOption) ? $namespaceOption : 'App\\Models';

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

        if (! File::exists($outputPath)) {
            File::makeDirectory($outputPath, 0755, true);
        }

        if (isset($formDecoded['tables']) && is_array($formDecoded['tables'])) {
            foreach ($formDecoded['tables'] as $tableName => $table) {
                if (is_string($tableName) && is_array($table)) {
                    /** @var array<string, mixed> $table */
                    $this->generateModel($tableName, $table, $outputPath, $namespace);
                }
            }
        }

        $this->info('Models generated successfully!');

        return 0;
    }

    /**
     * Generate a model class from table schema.
     *
     * @param  array<string, mixed>  $table
     *
     * @throws PcreException
     * @throws DatetimeException
     */
    protected function generateModel(string $tableName, array $table, string $outputPath, string $namespace): void
    {
        $modelName = $this->getModelName($tableName);

        /** @var array<string, array<string, mixed>> $columns */
        $columns = isset($table['columns']) && is_array($table['columns']) ? $table['columns'] : [];
        /** @var array<string, array<string, mixed>> $foreignKeys */
        $foreignKeys = isset($table['foreign_keys']) && is_array($table['foreign_keys']) ? $table['foreign_keys'] : [];

        $fillable = $this->getFillableFields($columns);
        $casts = $this->getCasts($columns);
        $relations = $this->getRelations($foreignKeys);

        $template = $this->getModelTemplate(
            $modelName,
            $namespace,
            $tableName,
            $fillable,
            $casts,
            $relations
        );

        $filePath = $outputPath.'/'.$modelName.'.php';
        File::put($filePath, $template);

        $this->info("Generated model: {$modelName}");
    }

    /**
     * Get the model class name from table name.
     */
    protected function getModelName(string $tableName): string
    {
        return Str::studly(Str::singular($tableName));
    }

    /**
     * Get fillable fields from columns.
     *
     * @param  array<string, array<string, mixed>>  $columns
     * @return array<int, string>
     */
    protected function getFillableFields(array $columns): array
    {
        $fillable = [];
        foreach ($columns as $name => $column) {
            if (is_string($name) && is_array($column) && ! in_array($name, ['id', 'created_at', 'updated_at', 'deleted_at'], true)) {
                $fillable[] = $name;
            }
        }

        return $fillable;
    }

    /**
     * Get casts from columns.
     *
     * @param  array<string, array<string, mixed>>  $columns
     * @return array<string, string>
     */
    protected function getCasts(array $columns): array
    {
        $casts = [];
        foreach ($columns as $name => $column) {
            if (is_string($name) && is_array($column) && isset($column['type']) && is_string($column['type'])) {
                $type = $column['type'];
                $cast = match ($type) {
                    'integer', 'bigint', 'smallint' => 'integer',
                    'decimal', 'float' => 'float',
                    'boolean' => 'boolean',
                    'date' => 'date',
                    'datetime', 'timestamp' => 'datetime',
                    'json' => 'array',
                    default => null,
                };

                if ($cast !== null) {
                    $casts[$name] = $cast;
                }
            }
        }

        return $casts;
    }

    /**
     * Get relations from foreign keys.
     *
     * @param  array<string, array<string, mixed>>  $foreignKeys
     * @return array<string, array{type: string, model: string, key: string, foreignKey: string}>
     */
    protected function getRelations(array $foreignKeys): array
    {
        $relations = [];
        foreach ($foreignKeys as $name => $fk) {
            if (is_string($name) && is_array($fk) &&
                isset($fk['references_table']) && is_string($fk['references_table']) &&
                isset($fk['column']) && is_string($fk['column']) &&
                isset($fk['references_column']) && is_string($fk['references_column'])) {
                $relatedTable = $fk['references_table'];
                $relatedModel = $this->getModelName((string) $relatedTable);
                $methodName = Str::camel((string) $relatedTable);

                if (preg_match('/^(.+)_id$/', $fk['column'], $matches) === 1) {
                    $methodName = Str::camel($matches[1]);
                }

                $relations[$methodName] = [
                    'type' => 'belongsTo',
                    'model' => $relatedModel,
                    'key' => (string) $fk['column'],
                    'foreignKey' => (string) $fk['references_column'],
                ];
            }
        }

        return $relations;
    }

    /**
     * Get the model class template.
     *
     * @param  array<int, string>  $fillable
     * @param  array<string, string>  $casts
     * @param  array<string, array{type: string, model: string, key: string, foreignKey: string}>  $relations
     *
     * @throws DatetimeException
     */
    protected function getModelTemplate(
        string $modelName,
        string $namespace,
        string $tableName,
        array $fillable,
        array $casts,
        array $relations
    ): string {
        // var_export con return=true ritorna sempre string
        /** @var string $fillableExport */
        $fillableExport = var_export($fillable, true);
        $fillableStrRaw = preg_replace('/^/m', '        ', $fillableExport);
        Assert::string($fillableStrRaw, 'Failed to format fillable array');
        /** @var string $fillableStr */
        $fillableStr = $fillableStrRaw;

        // var_export con return=true ritorna sempre string
        /** @var string $castsExport */
        $castsExport = var_export($casts, true);
        $castsStrRaw = preg_replace('/^/m', '        ', $castsExport);
        Assert::string($castsStrRaw, 'Failed to format casts array');
        /** @var string $castsStr */
        $castsStr = $castsStrRaw;

        $relationsStr = '';
        foreach ($relations as $methodName => $relation) {
            $relationsStr .= $this->getRelationMethod($methodName, $relation);
        }

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class {$modelName}
 * @package {$namespace}
 *
 * @property-read int \$id
 * @property \Carbon\Carbon \$created_at
 * @property \Carbon\Carbon \$updated_at
 * Generated on: {$this->getCurrentDate()}
 */
class {$modelName} extends Model
{
    protected \$table = '{$tableName}';

    protected \$fillable = {$fillableStr};

    protected \$casts = {$castsStr};
{$relationsStr}
}

PHP;
    }

    /**
     * Get the relation method template.
     *
     * @param  array{type: string, model: string, key: string, foreignKey: string}  $relation
     */
    protected function getRelationMethod(string $methodName, array $relation): string
    {
        return <<<PHP

    public function {$methodName}(): BelongsTo
    {
        return \$this->belongsTo({$relation['model']}::class, '{$relation['key']}', '{$relation['foreignKey']}');
    }
PHP;
    }

    /**
     * Get the current date formatted.
     *
     * @throws DatetimeException
     */
    protected function getCurrentDate(): string
    {
        return date('Y-m-d H:i:s');
    }
}
