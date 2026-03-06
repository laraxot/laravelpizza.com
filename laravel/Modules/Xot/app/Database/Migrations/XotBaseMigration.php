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
        $this->model_class ??= $this->getModelClass();
        Assert::isInstanceOf($model = app($this->model_class), Model::class);
        $this->model = $model;
    }

    /**
     * Get the model class based on the migration class name.
     */
    public function getModelClass(): string
    {
        if (null !== $this->model_class) {
            return $this->model_class;
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

        $this->model_class = Str::of('\Modules\\'.$mod_name.'\Models\\'.$name)
            ->replace('/', \DIRECTORY_SEPARATOR)
            ->toString();

        return $this->model_class;
    }

    public function getTable(): string
    {
        return $this->model->getTable();
    }

    public function getConn(): Builder
    {
        return Schema::connection($this->model->getConnectionName());
    }

    /**
     * Commentato perché Doctrine non è supportato nativamente in Laravel.
     * Se hai bisogno di questa funzione, assicurati di installare doctrine/dbal.
     */
    // public function getSchemaManager(): AbstractSchemaManager
    // {
    //     return $this->getConn()->getConnection()->getDoctrineSchemaManager();
    // }

    /**
     * Get table details using Doctrine's schema manager.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    // public function getTableDetails(): Table
    // {
    //     return $this->getSchemaManager()->listTableDetails($this->getTable());
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
    //     return $this->getSchemaManager()->listTableIndexes($this->getTable());
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
        return $this->getConn()->hasTable($table ?? $this->getTable());
    }

    public function hasColumn(string $column): bool
    {
        return $this->getConn()->hasColumn($this->getTable(), $column);
    }

    public function hasTable(string $table): bool
    {
        return $this->getConn()->hasTable($table);
    }

    public function getColumnType(string $column): string
    {
        try {
            return $this->getConn()->getColumnType($this->getTable(), $column);
        } catch (\Exception $e) {
            return 'not-exists';
        }
    }

    public function isColumnType(string $column, string $type): bool
    {
        return $this->hasColumn($column) && $this->getColumnType($column) === $type;
    }

    public function query(string $sql): void
    {
        $this->getConn()->getConnection()->statement($sql);
    }

    public function hasIndex(string $column): bool
    {
        return $this->getConn()->hasIndex($this->getTable(), $column);
    }

    /**
     * Check if the table has a primary key.
     */
    public function hasPrimaryKey(): bool
    {
        // Commentato perché dipende da Doctrine DBAL
        // return $this->getTableDetails()->hasPrimaryKey();
        $connection = $this->getConn()->getConnection();
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
        $sql = 'ALTER TABLE '.$this->getTable().' DROP PRIMARY KEY;';
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
        $this->getConn()->dropIfExists($table);
    }

    public function renameTable(string $from, string $to): void
    {
        if ($this->tableExists($from)) {
            $this->getConn()->rename($from, $to);
        }
    }

    public function renameColumn(string $from, string $to): void
    {
        $this->getConn()->table($this->getTable(), function (Blueprint $table) use ($from, $to): void {
            $table->renameColumn($from, $to);
        });
    }

    public function tableCreate(\Closure $next, ?string $table = null): void
    {
        $tableName = $table ?? $this->getTable();
        if (! $this->tableExists($tableName)) {
            $this->getConn()->create($tableName, $next);
        }
    }

    public function tableUpdate(\Closure $next, ?string $table = null): void
    {
        $tableName = $table ?? $this->getTable();
        $this->getConn()->table($tableName, $next);
    }

    public function timestamps(Blueprint $table, bool $hasSoftDeletes = false): void
    {
        $xot = XotData::make();
        $userClass = $xot->getUserClass();

        $table->timestamps();
        //$table->foreignIdFor($userClass, 'user_id')->nullable();
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
        if (! $this->hasColumn('created_at')) {
            $table->timestamp('created_at')->nullable();
        }

        if (! $this->hasColumn('updated_at')) {
            $table->timestamp('updated_at')->nullable();
        }

        // Check and add foreign key columns only if they don't exist
        if (! $this->hasColumn('updated_by')) {
            $table->foreignIdFor($userClass, 'updated_by')->nullable();
        }

        if (! $this->hasColumn('created_by')) {
            $table->foreignIdFor($userClass, 'created_by')->nullable();
        }

        // Handle soft deletes
        if ($hasSoftDeletes) {
            if (! $this->hasColumn('deleted_at')) {
                $table->softDeletes();
            }
            if (! $this->hasColumn('deleted_by')) {
                $table->foreignIdFor($userClass, 'deleted_by')->nullable();
            }
        } else {
            // If soft deletes are not requested but deleted_at exists, add deleted_by
            if ($this->hasColumn('deleted_at') && ! $this->hasColumn('deleted_by')) {
                $table->foreignIdFor($userClass, 'deleted_by')->nullable();
            }
        }
    }

    public function updateUser(Blueprint $table): void
    {
        $methodName = 'updateUserKey'.Str::studly($this->model->getKeyType());
        $this->{$methodName}($table);

        if ($this->hasColumn('model_id') && 'bigint' === $this->getColumnType('model_id')) {
            $table->string('model_id', 36)->index()->change();
        }

        if ($this->hasColumn('team_id') && 'bigint' === $this->getColumnType('team_id')) {
            $table->uuid('team_id')->nullable()->change();
        }
    }

    public function updateUserKeyString(Blueprint $table): void
    {
        if (! $this->hasColumn('id')) {
            $table->uuid('id')->primary()->first();
        }

        if ($this->hasColumn('id') && 'bigint' === $this->getColumnType('id')) {
            $table->uuid('id')->change();
        }

        if ($this->hasColumn('user_id') && 'bigint' === $this->getColumnType('user_id')) {
            $table->uuid('user_id')->change();
        }
    }

    public function updateUserKeyInt(Blueprint $table): void
    {
        if (! $this->hasColumn('id')) {
            $table->id('id')->first();
        }

        if ($this->hasColumn('id') && in_array($this->getColumnType('id'), ['string', 'guid'], true)) {
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
        return $this->model->getConnectionName();
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
        return DB::connection($this->getConnection())->getDriverName();
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

        if (! $this->tableExists()) {
            return;
        }

        $idType = $this->getColumnType('id');
        if (! $this->isUuidColumnType($idType)) {
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
        if (! $this->hasColumn('uuid')) {
            return;
        }

        $table = $this->getTable();
        $conn = DB::connection($this->model->getConnectionName());

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
        $conn = DB::connection($this->model->getConnectionName());

        if (! $this->hasColumn('uuid')) {
            $this->tableUpdate(function (Blueprint $blueprint): void {
                $blueprint->uuid('uuid')->nullable()->after('id');
            }, $table);
            $conn->table($table)->update(['uuid' => DB::raw('id')]);
            if ('mysql' === $conn->getDriverName()) {
                $conn->statement('ALTER TABLE '.$table.' MODIFY uuid CHAR(36) NOT NULL');
            }
        }

        $tmpTable = $table.'_new';
        $this->getConn()->create($tmpTable, $createNewTableSchema);
        $this->copyDataWithUuidToBigintMapping($table, $tmpTable, $dataColumns);

        $pivotTable = $options['pivot_table'] ?? null;
        $pivotFk = $options['pivot_fk'] ?? null;
        if (null !== $pivotTable && null !== $pivotFk && $this->hasTable($pivotTable)) {
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
        $conn = DB::connection($this->model->getConnectionName());
        $rows = $conn->table($oldTable)->orderBy('id')->get();
        $newId = 1;
        $this->uuidToBigintIdMapping = [];

        foreach ($rows as $row) {
            $row = (object) $row;
            $data = ['id' => $newId, 'uuid' => $row->uuid ?? (string) Str::uuid()];
            foreach ($dataColumns as $c) {
                if (isset($row->{$c})) {
                    $data[$c] = $row->{$c};
                }
            }
            $this->uuidToBigintIdMapping[(string) $row->id] = $newId;
            $conn->table($newTable)->insert($data);
            ++$newId;
        }
    }

    protected function updatePivotTableFkFromUuidToBigint(string $sourceTable, string $pivotTable, string $fkColumn): void
    {
        $conn = DB::connection($this->model->getConnectionName());
        $rows = $conn->table($sourceTable)->get(['id', 'uuid']);

        foreach ($rows as $p) {
            $p = (object) $p;
            $newId = $this->uuidToBigintIdMapping[(string) $p->id] ?? null;
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
