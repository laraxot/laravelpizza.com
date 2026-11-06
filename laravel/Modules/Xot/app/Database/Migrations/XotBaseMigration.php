<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Migrations;

use Doctrine\DBAL\Schema\Index;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration as LaravelMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Facades\Module;
use Webmozart\Assert\Assert;

use function Safe\copy;

/**
 * Class XotBaseMigration.
 */
abstract class XotBaseMigration extends LaravelMigration
{
    protected Model $model;

    /** @var class-string<Model>|null */
    protected ?string $model_class = null;

    public function __construct()
    {
        $this->model_class ??= $this->getModelClass();
        Assert::isInstanceOf($model = app($this->model_class), Model::class);
        $this->model = $model;
    }

    /**
     * Get the model class based on the migration class name.
     *
     * @return class-string<Model>
     */
    public function getModelClass(): string
    {
        if ($this->model_class !== null) {
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
        $mod_name = $filename !== false ? Str::of($filename)->after($mod_path)->explode(\DIRECTORY_SEPARATOR)[1] : ''; // Fallback nel caso in cui $filename non sia valido.

        $modelClass = Str::of('\Modules\\'.$mod_name.'\Models\\'.$name)
            ->replace('/', \DIRECTORY_SEPARATOR)
            ->toString();

        Assert::stringNotEmpty($modelClass);
        Assert::classExists($modelClass);
        Assert::subclassOf($modelClass, Model::class);

        /* @var class-string<Model> $modelClass */
        $this->model_class = $modelClass;

        return $modelClass;
    }

    public function getTable(): string
    {
        return $this->model->getTable();
    }

    public function getConn(): Builder
    {
        return Schema::connection($this->resolveConnectionName());
    }

    /**
     * Resolve the model's connection name, falling back to the default
     * connection when it points at the optional 'user' connection but that
     * connection has no configured database (see config/database.php: the
     * 'user' connection's placeholder defaults were removed so this
     * getDatabaseName() check is meaningful instead of always-truthy).
     * Shared by getConn() and getConnection() so Laravel's Migrator — which
     * calls getConnection() directly to decide transaction wrapping — gets
     * the same fallback instead of eagerly connecting to 'user'.
     */
    private function resolveConnectionName(): string
    {
        $connectionName = $this->model->getConnectionName();
        if ($connectionName === 'user' && ! DB::connection($connectionName)->getDatabaseName()) {
            $default = config('database.default');

            return is_string($default) ? $default : 'mariadb';
        }

        if ($connectionName === null) {
            $default = config('database.default');

            return is_string($default) ? $default : 'mariadb';
        }

        return $connectionName;
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
     *
     * @return array<Index>
     *
     * @throws \Doctrine\DBAL\Exception
     */
    // public function getTableIndexes(): array
    // {
    //     return $this->getSchemaManager()->listTableIndexes($this->getTable());
    // }

    /**
     * Add common fields to the table.
     *
     * @param  Blueprint  $table  The table blueprint
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
        $conn = $this->getConn();
        $table = $this->getTable();

        if ($conn->hasIndex($table, $column)) {
            return true;
        }

        $defaultIndexName = $table.'_'.$column.'_index';
        if ($conn->hasIndex($table, $defaultIndexName)) {
            return true;
        }

        return false;
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

        if ($connection->getDriverName() === 'sqlite') {
            $infos = $connection->select("PRAGMA table_info({$table})");
            foreach ($infos as $info) {
                $info = (array) $info;
                if (isset($info['pk']) && $info['pk'] > 0) {
                    return true;
                }
            }

            return false;
        }

        $database = $connection->getDatabaseName();

        $query = "SELECT COUNT(*) as count
              FROM information_schema.table_constraints
              WHERE table_schema = ?
              AND table_name = ?
              AND constraint_type = 'PRIMARY KEY'";

        $result = $connection->selectOne($query, [$database, $table]);

        return $this->extractPrimaryKeyCount($result) > 0;
    }

    /**
     * Drop the primary key from the table.
     */
    public function dropPrimaryKey(): void
    {
        if ($this->driver() === 'sqlite') {
            return;
        }
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

    /**
     * Se la tabella da config (getTable()) non esiste ma esiste il plurale Laravel
     * dello stesso nome (legacy Spatie default), rinomina legacy → config.
     * Nessun nome tabella hardcoded: target dal modello, legacy = Str::plural(target).
     */
    protected function adoptPluralLegacyTableNameIfNeeded(): void
    {
        $target = $this->getTable();
        if ($this->tableExists($target)) {
            return;
        }

        $legacy = Str::plural($target);
        if ($legacy !== $target && $this->hasTable($legacy)) {
            $this->getConn()->rename($legacy, $target);
        }
    }

    public function tableUpdate(\Closure $next, ?string $table = null): void
    {
        $tableName = $table ?? $this->getTable();

        if (! $this->getConn()->hasTable($tableName)) {
            $this->getConn()->create($tableName, $next);

            return;
        }

        $this->getConn()->table($tableName, $next);
    }

    /**
     * Crea solo gli indici che mancano, sulla connessione del modello della migrazione.
     *
     * Idempotente: un indice c'e' gia' se esiste con quel nome oppure sulle stesse colonne nello stesso
     * ordine (`Builder::hasIndex()` accetta l'elenco), cosi' un indice equivalente con altro nome non viene
     * duplicato. Salta la tabella o l'indice se manca una colonna: lo schema di un ambiente puo' essere piu'
     * vecchio. Non toglie mai nulla: eliminare un indice in produzione e' una decisione dell'utente.
     *
     * Per una colonna di testo confrontata con un intero l'indice non basta (MySQL scandisce tutto l'indice):
     * la query deve passare il valore come stringa.
     *
     * @param  array<string, array<string, list<string>>>  $indexes  tabella => nome indice => colonne in ordine
     */
    protected function ensureIndexes(array $indexes): void
    {
        $schema = $this->getConn();

        foreach ($indexes as $tableName => $tableIndexes) {
            if (! $schema->hasTable($tableName)) {
                continue;
            }

            foreach ($tableIndexes as $indexName => $columns) {
                if ($this->shouldSkipIndex($schema, $tableName, $indexName, $columns)) {
                    continue;
                }

                $schema->table($tableName, static function (Blueprint $table) use ($columns, $indexName): void {
                    $table->index($columns, $indexName);
                });
            }
        }
    }

    /**
     * @param  list<string>  $columns
     */
    private function shouldSkipIndex(Builder $schema, string $tableName, string $indexName, array $columns): bool
    {
        foreach ($columns as $column) {
            if (! $schema->hasColumn($tableName, $column)) {
                return true;
            }
        }

        return $schema->hasIndex($tableName, $indexName) || $schema->hasIndex($tableName, $columns);
    }

    /**
     * @param  mixed  $result  Risultato di Connection::selectOne() (atteso array{count?: mixed}|object|null)
     */
    protected function extractPrimaryKeyCount(mixed $result): int
    {
        if (is_array($result)) {
            return isset($result['count']) ? SafeIntCastAction::cast($result['count']) : 0;
        }

        if (is_object($result)) {
            $resultAsArray = (array) $result;

            return isset($resultAsArray['count']) ? SafeIntCastAction::cast($resultAsArray['count']) : 0;
        }

        return 0;
    }

    public function updateTimestamps(Blueprint $table, bool $hasSoftDeletes = false): void
    {
        $xot = XotData::make();
        $userClass = $xot->getUserClass();

        // Listing fresca: evita "Duplicate column" quando RefreshDatabase / migrate
        // in-process lasciano la cache Schema fuori sync rispetto a information_schema.
        $columns = array_map(
            static fn (mixed $name): string => is_string($name) ? strtolower($name) : '',
            $this->getConn()->getColumnListing($this->getTable()),
        );

        if (! in_array('created_at', $columns, true)) {
            $table->timestamp('created_at')->nullable();
        }

        if (! in_array('updated_at', $columns, true)) {
            $table->timestamp('updated_at')->nullable();
        }

        if (! in_array('updated_by', $columns, true)) {
            $table->foreignIdFor($userClass, 'updated_by')->nullable();
        }

        if (! in_array('created_by', $columns, true)) {
            $table->foreignIdFor($userClass, 'created_by')->nullable();
        }

        if ($hasSoftDeletes) {
            if (! in_array('deleted_at', $columns, true)) {
                $table->softDeletes();
            }
            if (! in_array('deleted_by', $columns, true)) {
                $table->foreignIdFor($userClass, 'deleted_by')->nullable();
            }
        } elseif (in_array('deleted_at', $columns, true) && ! in_array('deleted_by', $columns, true)) {
            $table->foreignIdFor($userClass, 'deleted_by')->nullable();
        }
    }

    public function updateUser(Blueprint $table): void
    {
        $methodName = 'updateUserKey'.Str::studly($this->model->getKeyType());
        $this->{$methodName}($table);

        if ($this->hasColumn('model_id') && $this->getColumnType('model_id') === 'bigint') {
            $table->string('model_id', 36)->index()->change();
        }

        if ($this->hasColumn('team_id') && $this->getColumnType('team_id') === 'bigint') {
            $table->uuid('team_id')->nullable()->change();
        }
    }

    public function updateUserKeyString(Blueprint $table): void
    {
        if (! $this->hasColumn('id')) {
            $table->uuid('id')->primary()->first();
        }

        if ($this->hasColumn('id') && $this->getColumnType('id') === 'bigint') {
            $table->uuid('id')->change();
        }

        if ($this->hasColumn('user_id') && $this->getColumnType('user_id') === 'bigint') {
            $table->uuid('user_id')->change();
        }
    }

    /**
     * Converte user_id da bigint a UUID, solo se la colonna e' ancora bigint.
     *
     * Rifiuta la conversione se esistono valori: un id intero non diventa un UUID,
     * e uno schema cambiato in silenzio corrompe i dati. Il mapping va deciso prima.
     */
    public function convertUserIdToUuidIfLegacyBigint(Blueprint $table, bool $nullable = true): void
    {
        if (! $this->hasColumn('user_id') || $this->getColumnType('user_id') !== 'bigint') {
            return;
        }

        $legacyRows = DB::connection($this->getConnection())
            ->table($this->getTable())
            ->whereNotNull('user_id')
            ->count();

        if ($legacyRows > 0) {
            throw new \RuntimeException(sprintf(
                'Conversione user_id bloccata su %s: %d righe con valore bigint. Serve un mapping verso UUID prima della migrazione.',
                $this->getTable(),
                $legacyRows,
            ));
        }

        if ($nullable) {
            $table->uuid('user_id')->nullable()->change();

            return;
        }

        $table->uuid('user_id')->change();
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
     * Get the migration connection name. Laravel's Migrator calls this
     * directly to decide transaction wrapping, so it must apply the same
     * 'user'-connection fallback as getConn() — see resolveConnectionName().
     */
    public function getConnection(): ?string
    {
        return $this->resolveConnectionName();
    }

    /**
     * Add a foreign ID column to the table based on a related model.
     */
    public function foreignIdFor(Blueprint $table, string $class, ?string $column = null): ForeignIdColumnDefinition
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

    protected function isMysqlFamilyDriver(?string $driver = null): bool
    {
        $driver ??= $this->driver();

        return in_array($driver, ['mysql', 'mariadb'], true);
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
     * @param  \Closure(Blueprint): void  $createNewTableSchema  Schema for the new table (id bigint + uuid + data columns)
     * @param  list<string>  $dataColumns  Column names to copy (excluding id, uuid)
     * @param  array{pivot_table?: string, pivot_fk?: string, pivot_post_update?: \Closure}  $options  Optional pivot table config
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
        $conn = DB::connection($this->getConnection());

        $conn->table($table)->orderBy('id')->chunk(100, function (Collection $rows) use ($table, $conn): void {
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
     * @param  \Closure(Blueprint): void  $createNewTableSchema
     * @param  list<string>  $dataColumns
     * @param  array{pivot_table?: string, pivot_fk?: string, pivot_post_update?: \Closure}  $options
     */
    protected function performUuidToBigintConversion(
        string $table,
        \Closure $createNewTableSchema,
        array $dataColumns,
        array $options,
    ): void {
        $conn = DB::connection($this->getConnection());

        if (! $this->hasColumn('uuid')) {
            $this->tableUpdate(function (Blueprint $blueprint): void {
                $blueprint->uuid('uuid')->nullable()->after('id');
            }, $table);
            $conn->table($table)->update(['uuid' => DB::raw('id')]);
            if ($this->isMysqlFamilyDriver($conn->getDriverName())) {
                $conn->statement('ALTER TABLE '.$table.' MODIFY uuid CHAR(36) NOT NULL');
            }
        }

        $tmpTable = $table.'_new';
        $this->getConn()->create($tmpTable, $createNewTableSchema);
        $this->copyDataWithUuidToBigintMapping($table, $tmpTable, $dataColumns);

        $pivotTable = $options['pivot_table'] ?? null;
        $pivotFk = $options['pivot_fk'] ?? null;
        if ($pivotTable !== null && $pivotFk !== null && $this->hasTable($pivotTable)) {
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
     * @param  list<string>  $dataColumns
     */
    protected function copyDataWithUuidToBigintMapping(string $oldTable, string $newTable, array $dataColumns): void
    {
        $conn = DB::connection($this->getConnection());
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
            $this->uuidToBigintIdMapping[SafeStringCastAction::cast($row->id)] = $newId;
            $conn->table($newTable)->insert($data);
            $newId++;
        }
    }

    protected function updatePivotTableFkFromUuidToBigint(string $sourceTable, string $pivotTable, string $fkColumn): void
    {
        $conn = DB::connection($this->getConnection());
        $rows = $conn->table($sourceTable)->get(['id', 'uuid']);

        foreach ($rows as $p) {
            $p = (object) $p;
            $newId = $this->uuidToBigintIdMapping[SafeStringCastAction::cast($p->id)] ?? null;
            if ($newId !== null) {
                $conn->table($pivotTable)
                    ->where($fkColumn, $p->id)
                    ->update([$fkColumn => SafeStringCastAction::cast($newId)]);
            }
        }

        if ($this->isMysqlFamilyDriver($conn->getDriverName())) {
            $db = $conn->getDatabaseName();
            $constraint = $conn->selectOne(
                "SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
                 WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
                 AND CONSTRAINT_TYPE = 'UNIQUE' AND CONSTRAINT_NAME LIKE ? LIMIT 1",
                [$db, $pivotTable, '%'.$fkColumn.'%']
            );
            $constraintName = is_object($constraint) && isset($constraint->CONSTRAINT_NAME)
                ? SafeStringCastAction::cast($constraint->CONSTRAINT_NAME)
                : null;
            if ($constraintName !== null) {
                $conn->statement('ALTER TABLE '.$pivotTable.' DROP INDEX '.$constraintName);
            }
            $conn->statement('ALTER TABLE '.$pivotTable.' MODIFY '.$fkColumn.' BIGINT UNSIGNED NULL');
        }
    }
}

// end XotBaseMigration
