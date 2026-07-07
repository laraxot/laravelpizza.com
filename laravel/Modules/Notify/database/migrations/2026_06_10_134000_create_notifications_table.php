<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Modules\User\Models\Notification as UserDatabaseNotification;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Owner Notify — UNICA migrazione per `notifications` (connessione user / fixcity_user).
 * Runtime Eloquent: Modules\User\Models\Notification (DatabaseNotification).
 * Schema: uuid PK + uuidMorphs — users.id è UUID/ULID string.
 * Evoluzione: edit QUESTO file + bump timestamp — vietato secondo create_* in User/.
 * Ultimo bump: 2026_06_10_134000
 * Contratto: laravel/Modules/Notify/docs/wiki/concepts/notifications-database-contract.md
 */
return new class extends XotBaseMigration
{
    /** @var class-string<UserDatabaseNotification> */
    protected ?string $model_class = UserDatabaseNotification::class;

    public function up(): void
    {
        if (
            $this->tableExists()
            && $this->hasColumn('id')
            && in_array($this->getColumnType('id'), ['integer', 'bigint'], true)
        ) {
            $connection = $this->model->getConnectionName() ?? 'user';

            if (0 === DB::connection($connection)->table($this->getTable())->count()) {
                $this->dropTableIfExists($this->getTable());
            }
        }

        $this->tableCreate(static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->uuidMorphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('type')) {
                $table->string('type');
            }

            if (! $this->hasColumn('notifiable_type')) {
                $table->string('notifiable_type');
            }

            if (! $this->hasColumn('notifiable_id')) {
                $table->uuid('notifiable_id');
            } elseif (
                $this->hasColumn('notifiable_id')
                && in_array($this->getColumnType('notifiable_id'), ['integer', 'bigint'], true)
            ) {
                $table->string('notifiable_id', 36)->nullable()->change();
            }

            if (! $this->hasColumn('data')) {
                $table->text('data');
            }

            if (! $this->hasColumn('read_at')) {
                $table->timestamp('read_at')->nullable();
            }

            $this->updateTimestamps(table: $table, hasSoftDeletes: false);
        });
    }
};
