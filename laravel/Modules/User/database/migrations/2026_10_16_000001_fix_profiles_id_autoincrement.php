<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

/**
 * Fresh installs: the oldest profiles migration creates `id` as char(36) without a default,
 * and the newer one (bigint auto-increment) is skipped because the table already exists.
 * Profile creation at first login then fails. Converts the column only when it is still a
 * string type and the table is empty; otherwise it does nothing.
 * `MODIFY ... AUTO_INCREMENT` exists only on MySQL/MariaDB: on other drivers (sqlite used by
 * the test suites and CI) the migration does nothing instead of failing the whole migrate.
 */
<<<<<<< .merge_file_4HgXIV
return new class extends Migration
{
    protected $connection = 'user';

=======
return new class() extends Migration
{
>>>>>>> .merge_file_tlA1ka
    public function up(): void
    {
        $connection = $this->connectionName();
        $schema = Schema::connection($connection);

        if (! in_array(DB::connection($connection)->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        // `MODIFY ... AUTO_INCREMENT` esiste solo in MySQL/MariaDB (SQLite dei test: niente da convertire).
        if (! in_array(DB::connection('user')->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        if (! $schema->hasTable('profiles')) {
            return;
        }

        $type = $schema->getColumnType('profiles', 'id');
        $empty = DB::connection($connection)->table('profiles')->count() === 0;

        if (in_array($type, ['char', 'varchar', 'string', 'guid', 'uuid'], true) && $empty) {
            DB::connection($connection)->statement('ALTER TABLE profiles MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
    }

    /**
     * The `user` connection is optional: it is used only when it points at a database.
     */
    private function connectionName(): string
    {
        $database = DB::connection('user')->getDatabaseName();

        if (is_string($database) && $database !== '') {
            return 'user';
        }

        return SafeStringCastAction::cast(config('database.default'));
    }

    public function down(): void
    {
        // Intentionally empty: never revert to a non auto-increment id.
    }
};
