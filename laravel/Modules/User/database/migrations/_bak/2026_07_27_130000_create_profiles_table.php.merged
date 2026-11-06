<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Profile;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * PHILOSOPHY - ONE MIGRATION PER TABLE:
 * Laraxot keeps a single authoritative create migration for each table/model.
 * Schema evolution happens by editing this file and bumping its timestamp so
 * the idempotent tableUpdate() block re-runs on already-migrated databases.
 *
 * LARAXOT ID+UUID CONTRACT:
 * Every table must have:
 *   - `id`   bigint unsigned AUTO_INCREMENT PRIMARY KEY  (internal DB reference)
 *   - `uuid` char(36) nullable indexed                  (external/public reference)
 * The `id` is NEVER exposed in APIs or URLs; `uuid` is used for all external
 * references. XotBaseModel::casts() already handles both.
 *
 * LEGACY REPAIR (2026-07-27):
 * This table was first created (2022/2026-01 migrations, now consolidated into
 * this single file) with `id` as a `uuid()->primary()` column and no default
 * value, which breaks every insert once `firstOrCreate()`/`create()` relies on
 * Eloquent's auto-increment behaviour. `convertIdFromUuidToBigintIfNeeded()`
 * detects that legacy shape and rebuilds the table with a proper bigint
 * auto-increment `id`, preserving any existing rows under a new sequential id
 * and their original id value as `uuid` (or the already-populated `uuid`
 * column when present). Consolidates 5 previously-competing
 * `create_profiles_table.php` files (2022_01_01, 2026_01_01, 2026_03_12,
 * 2026_04_20, 2026_04_28) into this single owner migration.
 */
return new class extends XotBaseMigration {
    protected ?string $model_class = Profile::class;

    /** @var list<string> */
    private const DATA_COLUMNS = [
        'user_id', 'type', 'first_name', 'last_name', 'user_name', 'email', 'phone',
        'date_of_birth', 'website', 'twitter', 'facebook', 'linkedin', 'github',
        'address', 'birth_date', 'gender', 'bio', 'avatar', 'timezone', 'locale',
        'preferences', 'status', 'is_active', 'extra',
        'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function up(): void
    {
        // convertIdFromUuidToBigintIfNeeded() copies DATA_COLUMNS (including
        // timestamp/audit columns) into a temp table *before* tableUpdate()
        // ever runs, so this schema must declare those columns explicitly
        // (not via timestamps()/softDeletes(), which is only safe on the
        // plain-create path below where there is no pre-existing data to copy).
        $this->convertIdFromUuidToBigintIfNeeded(
            function (Blueprint $table): void {
                $this->newTableSchema($table);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
            },
            self::DATA_COLUMNS,
        );

        // -- CREATE (new installations, no legacy uuid-id to convert) --
        $this->tableCreate(function (Blueprint $table): void {
            $this->newTableSchema($table);
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });

        // -- UPDATE (existing installations: additive, idempotent) --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('uuid')) {
                $table->string('uuid', 36)->nullable()->index()->after('id');
            }
            if (! $this->hasColumn('user_id')) {
                $table->string('user_id', 36)->index()->nullable()->after('uuid');
            }
            if (! $this->hasColumn('type')) {
                $table->string('type')->index()->nullable()->after('user_id');
            }
            if (! $this->hasColumn('email')) {
                $table->string('email')->nullable();
            }
            if (! $this->hasColumn('phone')) {
                $table->string('phone')->nullable();
            }
            if (! $this->hasColumn('date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }
            if (! $this->hasColumn('website')) {
                $table->string('website')->nullable();
            }
            if (! $this->hasColumn('twitter')) {
                $table->string('twitter')->nullable();
            }
            if (! $this->hasColumn('facebook')) {
                $table->string('facebook')->nullable();
            }
            if (! $this->hasColumn('linkedin')) {
                $table->string('linkedin')->nullable();
            }
            if (! $this->hasColumn('github')) {
                $table->string('github')->nullable();
            }
            if (! $this->hasColumn('avatar')) {
                $table->string('avatar')->nullable();
            }
            if (! $this->hasColumn('timezone')) {
                $table->string('timezone')->nullable();
            }
            if (! $this->hasColumn('locale')) {
                $table->string('locale')->nullable();
            }
            if (! $this->hasColumn('preferences')) {
                $table->json('preferences')->nullable();
            }
            if (! $this->hasColumn('status')) {
                $table->string('status')->nullable();
            }
            if (! $this->hasColumn('extra')) {
                $table->json('extra')->nullable();
            }
            if (! $this->hasColumn('is_active')) {
                $table->boolean('is_active')->default(true);
            }

            $this->updateTimestamps($table, true);
        });
    }

    private function newTableSchema(Blueprint $table): void
    {
        $table->id();
        $table->string('uuid', 36)->index()->nullable();
        $table->string('user_id', 36)->index()->nullable();
        $table->string('type')->index()->nullable();
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('user_name')->nullable();
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->string('website')->nullable();
        $table->string('twitter')->nullable();
        $table->string('facebook')->nullable();
        $table->string('linkedin')->nullable();
        $table->string('github')->nullable();
        $table->string('address')->nullable();
        $table->date('birth_date')->nullable();
        $table->string('gender', 1)->nullable();
        $table->text('bio')->nullable();
        $table->string('avatar')->nullable();
        $table->string('timezone')->nullable();
        $table->string('locale')->nullable();
        $table->json('preferences')->nullable();
        $table->string('status')->nullable();
        $table->boolean('is_active')->default(true);
        $table->json('extra')->nullable();
    }
};
