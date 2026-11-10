<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Fresh installs: the oldest profiles migration creates `id` as char(36) without a default,
 * and the newer one (bigint auto-increment) is skipped because the table already exists.
 * Profile creation at first login then fails. Converts the column only when it is still a
 * string type and the table is empty; otherwise it does nothing.
 */
return new class extends Migration {
    protected $connection = 'user';

    public function up(): void
    {
        $schema = Schema::connection('user');

        // `MODIFY ... AUTO_INCREMENT` esiste solo in MySQL/MariaDB (SQLite dei test: niente da convertire).
        if (! in_array(DB::connection('user')->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        if (! $schema->hasTable('profiles')) {
            return;
        }

        $type = $schema->getColumnType('profiles', 'id');
        $empty = DB::connection('user')->table('profiles')->count() === 0;

        if (in_array($type, ['char', 'varchar', 'string', 'guid', 'uuid'], true) && $empty) {
            DB::connection('user')->statement('ALTER TABLE profiles MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
    }

    public function down(): void
    {
        // Intentionally empty: never revert to a non auto-increment id.
    }
};
