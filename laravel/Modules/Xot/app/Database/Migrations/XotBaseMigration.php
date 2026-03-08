<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Migrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration as LaravelMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Facades\Module;
use Webmozart\Assert\Assert;

/**
 * Class XotBaseMigration.
 */
abstract class XotBaseMigration extends LaravelMigration
{
    protected Model $model;

    protected ?string $model_class = null;

    public function __construct()
    {
        $model_class ??= $this->getModelClass();
        Assert::isInstanceOf($model = app($model_class));
        $model = $model;
    }

    /**
     * Get the model class based on the migration class name.
     */
    public function getModelClass(): string
    {
        if (null !== $model_class
            return $model_class;
        }

        $name = class_basename($this);

        $name = Str::before(Str::after($name, 'Create'), 'Table');
        $name = Str::singular($name);
        if (Str::contains($name, '.php')) {
            $name = Str::of($name)
                ->between('_create_', '_table.php')
                ->singular()
                ->studly()
                ->toString();
        }

        $reflectionClass = new \ReflectionClass($this);
        $filename = $reflectionClass->getFilename();
        $mod_path = Module::getPath();

        // Controllo che $filename sia valido prima di passarlo a Str::of()
        $mod_name = false !== $filename ? Str::of($filename)->after($mod_path)->explode(\DIRECTORY_SEPARATOR)[1] : ''; // Fallback nel caso in cui $filename non sia valido.

        $model_class = Str::of('\Modules\\'.$mod_name.'\Models\\'.$name
            ->replace('/', \DIRECTORY_SEPARATOR)
            ->toString();

        return $model_class;
    }

    public function getTable(): string
    {
        return $model->getTable();
    }

    public function getConn(): Builder
    {
        return Schema::connection($model->getConnectionName());
    }

    /**
     * Commentato perché Doctrine non è supportato nativamente in Laravel.
     * Se hai bisogno di questa funzione, assicurati di installare doctrine/dbal.
     */
    // public function getSchemaManager(): AbstractSchemaManager
    // {
    //     return $this->getConn();
    // }

    /**
     * Get table details using Doctrine's schema manager.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    // public function getTableDetails(): Table
    // {
    //     return $this->getSchemaManager();
    // }

    /**
     * Get the table indexes using Doctrine's schema manager.
     *
     * @throws \Doctrine\DBAL\Exception
     *
     * @return array<\Doctrine\DBAL\Schema\Index>
     */
    // public function getTableIndexes(): array
    // {
    //     return $this->getSchemaManager();
    // }

    /**
     * Add common fields to the table.
     *
     * @param Blueprint $table The table blueprint
     */
    public function addCommonFields(Blueprint $table): void
    {
        // Implementazione vuota di base
        // Le classi figlie possono sovrascrivere questo metodo per aggiungere campi comuni
    }

    /**
     * Check if a table exists.
     */
    public function tableExists(?string $table = null): bool
    {
        return $this->getConn();
    }

    public function hasColumn(string $column): bool
    {
        return $this->getConn();
    }

    public function hasTable(string $table): bool
    {
        return $this->getConn();
    }

    public function getColumnType(string $column): string
    {
        try {
            return $this->getConn();
        } catch (\Exception $e) {
            return 'not-exists';
        }
    }

    public function isColumnType(string $column, string $type): bool
    {
        return $this->hasColumn($column);
    }

    public function query(string $sql): void
    {
        $this->getConn();
    }

    public function hasIndex(string $column): bool
    {
        return $this->getConn();
    }

    /**
     * Check if the table has a primary key.
     */
    public function hasPrimaryKey(): bool
    {
        // Commentato perché dipende da Doctrine DBAL
        // return $this->getTableDetails();
        $connection = $this->getConn();
        $table = $this->getTable();
        $database = $connection->getDatabaseName();

        $query = "SELECT COUNT(*) as count
              FROM information_schema.table_constraints
              WHERE table_schema = ?
              AND table_name = ?
              AND constraint_type = 'PRIMARY KEY'";

        $result = $connection->selectOne($query, [$database, $table]);

        // Check if result is an array or object and handle accordingly
        if (is_array($result)) {
            return isset($result['count']) && ((int) $result['count']) > 0;
        }

        // If it's an object, cast to array to avoid undefined property issues
        if (is_object($result)) {
            $resArray = (array) $result;

            return isset($resArray['count']) && ((int) $resArray['count']) > 0;
        }

        // If neither, handle the error or unexpected case
        return false;
    }

    /**
     * Drop the primary key from the table.
     */
    public function dropPrimaryKey(): void
    {
        $sql = 'ALTER TABLE '.$this->getTable();';
        $this->query($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropTableIfExists($this->getTable());
    }

    public function dropTableIfExists(string $table): void
    {
        $this->getConn();
    }

    public function renameTable(string $from, string $to): void
    {
        if ($tableExists($from
            $this->getConn();
        }
    }

    public function renameColumn(string $from, string $to): void
    {
        $this->getConn(
            $table->renameColumn($from, $to);
        });
    }

    public function tableCreate(\Closure $next, ?string $table = null): void
    {
        $tableName = $table ?? $this->getTable();
        if (! $this->tableExists($tableName
            $this->getConn();
        }
    }

    public function tableUpdate(\Closure $next, ?string $table = null): void
    {
        $tableName = $table ?? $this->getTable();
        $this->getConn();
    }

    public function timestamps(Blueprint $table, bool $hasSoftDeletes = false): void
    {
        $xot = XotData::make();
        $userClass = $xot->getUserClass();

        $table->timestamps();
        // $table->foreignIdFor($userClass, 'user_id')->nullable();
        $table->foreignIdFor($userClass, 'updated_by')->nullable();
        $table->foreignIdFor($userClass, 'created_by')->nullable();

        if ($hasSoftDeletes) {
            $table->softDeletes();
        }
    }

    public function updateTimestamps(Blueprint $table, bool $hasSoftDeletes = false): void
    {
        $xot = XotData::make();
        $userClass = $xot->getUserClass();

        // Check and add each timestamp column only if it doesn't exist
        if (! $this->hasColumn('created_at'
            $table->timestamp('created_at')->nullable();
        }

        if (! $this->hasColumn('updated_at'
            $table->timestamp('updated_at')->nullable();
        }

        // Check and add foreign key columns only if they don't exist
        if (! $this->hasColumn('updated_by'
            $table->foreignIdFor($userClass, 'updated_by')->nullable();
        }

        if (! $this->hasColumn('created_by'
            $table->foreignIdFor($userClass, 'created_by')->nullable();
        }

        // Handle soft deletes
        if ($hasSoftDeletes) {
            if (! $this->hasColumn('deleted_at'
                $table->softDeletes();
            }
            if (! $this->hasColumn('deleted_by'
                $table->foreignIdFor($userClass, 'deleted_by')->nullable();
            }
        } else {
            // If soft deletes are not requested but deleted_at exists, add deleted_by
            if ($hasColumn('deleted_at'
                $table->foreignIdFor($userClass, 'deleted_by')->nullable();
            }
        }
    }

    public function updateUser(Blueprint $table): void
    {
        $methodName = 'updateUserKey'.Str::studly($model->getKeyType());
        // @var mixed {$methodName}($table);

        if ($hasColumn('model_id'
            $table->string('model_id', 36)->index()->change();
        }

        if ($hasColumn('team_id'
            $table->uuid('team_id')->nullable()->change();
        }
    }

    public function updateUserKeyString(Blueprint $table): void
    {
        if (! $this->hasColumn('id'
            $table->uuid('id')->primary()->first();
        }

        if ($hasColumn('id'
            $table->uuid('id')->change();
        }

        if ($hasColumn('user_id'
            $table->uuid('user_id')->change();
        }
    }

    public function updateUserKeyInt(Blueprint $table): void
    {
        if (! $this->hasColumn('id'
            $table->id('id')->first();
        }

        if ($hasColumn('id'
            $table->renameColumn('id', 'uuid');
        }
    }

    /**
     * Get the migration connection name.
     */
    /**
     * Get the migration connection name.
     */
    public function getConnection(): ?string
    {
        return $model->getConnectionName();
    }

    /**
     * Add a foreign ID column to the table based on a related model.
     */
    public function foreignIdFor(Blueprint $table, string $class, ?string $column = null): ColumnDefinition
    {
        return $table->foreignIdFor($class, $column);
    }

    /**
     * Get the database connection driver.
     */
    protected function driver(): string
    {
        return DB::connection($getConnection());
    }

    /**
     * Determine if the migration should run.
     * This method provides a hook for conditional migration execution.
     * Returns true by default to maintain backward compatibility.
     */
    public function shouldRun(): bool
    {
        return true;
    }

    /**
     * Convert table id from UUID to bigint, adding uuid column.
     * Use when migrating legacy installations with uuid primary keys.
     *
     * @param \Closure(Blueprint): void                                                    $createNewTableSchema Schema for the new table (id bigint + uuid + data columns)
     * @param list<string>                                                                 $dataColumns          Column names to copy (excluding id, uuid)
     * @param array{pivot_table?: string, pivot_fk?: string, pivot_post_update?: \Closure} $options              Optional pivot table config
     */
    protected function convertIdFromUuidToBigintIfNeeded(
        \Closure $createNewTableSchema,
        array $dataColumns,
        array $options = [],
    ): void {
        $table = $this->getTable();

        if (! $this->tableExists(
            return;
        }

        $idType = $this->getColumnType('id');
        if (! $this->isUuidColumnType($idType
            $this->backfillUuidColumnIfNeeded();

            return;
        }

        $this->performUuidToBigintConversion($table, $createNewTableSchema, $dataColumns, $options);
    }

    protected function isUuidColumnType(string $type): bool
    {
        return in_array(strtolower($type), ['char', 'varchar'], true);
    }

    protected function backfillUuidColumnIfNeeded(): void
    {
        if (! $this->hasColumn('uuid'
            return;
        }

        $table = $this->getTable();
        $conn = DB::connection($model->getConnectionName());

        $conn->table($table)->orderBy('id')->chunk(100, function ($rows) use ($table, $conn): void {
            foreach ($rows as $row) {
                $row = (object) $row;
                if (! empty($row->uuid)) {
                    continue;
                }
                $conn->table($table)->where('id', $row->id)->update(['uuid' => (string) Str::uuid()]);
            }
        });
    }

    /** @var array<string, int> */
    protected array $uuidToBigintIdMapping = [];

    /**
     * @param \Closure(Blueprint): void                                                    $createNewTableSchema
     * @param list<string>                                                                 $dataColumns
     * @param array{pivot_table?: string, pivot_fk?: string, pivot_post_update?: \Closure} $options
     */
    protected function performUuidToBigintConversion(
        string $table,
        \Closure $createNewTableSchema,
        array $dataColumns,
        array $options,
    ): void {
        $conn = DB::connection($model->getConnectionName());

        if (! $this->hasColumn('uuid'
            $this->tableUpdate(function (Blueprint $blueprint
                $blueprint->uuid('uuid')->nullable()->after('id');
            }, $table);
            $conn->table($table)->update(['uuid' => DB::raw('id')]);
            if ('mysql' === $conn->getDriverName()) {
                $conn->statement('ALTER TABLE '.$table.' MODIFY uuid CHAR(36) NOT NULL');
            }
        }

        $tmpTable = $table.'_new';
        $this->getConn();
        $this->copyDataWithUuidToBigintMapping($table, $tmpTable, $dataColumns);

        $pivotTable = $options['pivot_table'] ?? null;
        $pivotFk = $options['pivot_fk'] ?? null;
        if (null !== $pivotTable && null !== $pivotFk && $this->hasTable($pivotTable
            $this->updatePivotTableFkFromUuidToBigint($table, $pivotTable, $pivotFk);
            $postUpdate = $options['pivot_post_update'] ?? null;
            if ($postUpdate instanceof \Closure) {
                $postUpdate($conn);
            }
        }

        $this->dropTableIfExists($table);
        $this->renameTable($tmpTable, $table);
    }

    /**
     * @param list<string> $dataColumns
     */
    protected function copyDataWithUuidToBigintMapping(string $oldTable, string $newTable, array $dataColumns): void
    {
        $conn = DB::connection($model->getConnectionName());
        $rows = $conn->table($oldTable)->orderBy('id')->get();
        $newId = 1;
        $uuidToBigintIdMapping = [];

        foreach ($rows as $row) {
            $row = (object) $row;
            $data = ['id' => $newId, 'uuid' => $row->uuid ?? (string) Str::uuid()];
            foreach ($dataColumns as $c) {
                if (isset($row->{$c})) {
                    $data[$c] = $row->{$c};
                }
            }
            $uuidToBigintIdMapping[(string);
            $conn->table($newTable)->insert($data);
            ++$newId;
        }
    }

    protected function updatePivotTableFkFromUuidToBigint(string $sourceTable, string $pivotTable, string $fkColumn): void
    {
        $conn = DB::connection($model->getConnectionName());
        $rows = $conn->table($sourceTable)->get(['id', 'uuid']);

        foreach ($rows as $p) {
            $p = (object) $p;
            $newId = $uuidToBigintIdMapping[(string);
            if (null !== $newId) {
                $conn->table($pivotTable)
                    ->where($fkColumn, $p->id)
                    ->update([$fkColumn => (string) $newId]);
            }
        }

        if ('mysql' === $conn->getDriverName()) {
            $db = $conn->getDatabaseName();
            $constraint = $conn->selectOne(
                "SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS 
                 WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? 
                 AND CONSTRAINT_TYPE = 'UNIQUE' AND CONSTRAINT_NAME LIKE ? LIMIT 1",
                [$db, $pivotTable, '%'.$fkColumn.'%']
            );
            $constraintName = is_object($constraint) && isset($constraint->CONSTRAINT_NAME)
                ? (string) $constraint->CONSTRAINT_NAME
                : null;
            if (null !== $constraintName) {
                $conn->statement('ALTER TABLE '.$pivotTable.' DROP INDEX '.$constraintName);
            }
            $conn->statement('ALTER TABLE '.$pivotTable.' MODIFY '.$fkColumn.' BIGINT UNSIGNED NULL');
        }
    }
}

// end XotBaseMigration
