<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Activity\Models\Activity;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Owner Activity — UNICA migrazione per `activity_log` (connessione activity).
 * Vietato: add_* / fix_* / update_* su stesso modello — evoluzione = edit + bump timestamp.
 * Ultimo bump: 2026_06_10_141000 — consolida add_attribute_changes + fix_causer + update_schema
 * Contratto: laravel/Modules/Activity/docs/wiki/concepts/activity-log-single-migration-contract.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Activity::class;

    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableUuidMorphs('subject', 'subject');
            $table->nullableUuidMorphs('causer', 'causer');
            $table->json('properties')->nullable();
            $table->json('attribute_changes')->nullable();
            $table->index('log_name');
            $table->uuid('batch_uuid')->nullable();
            $table->string('event')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('attribute_changes')) {
                $table->json('attribute_changes')->nullable();
            }

            if (! $this->hasColumn('batch_uuid')) {
                $table->uuid('batch_uuid')->nullable();
            }

            if (! $this->hasColumn('event')) {
                $table->string('event')->nullable();
            }

            if (
                $this->hasColumn('subject_id')
                && in_array($this->getColumnType('subject_id'), ['integer', 'bigint'], true)
            ) {
                $table->string('subject_id', 36)->nullable()->change();
            }

            if ($this->hasColumn('subject_type')) {
                $table->string('subject_type')->nullable()->change();
            }

            if ($this->hasColumn('causer_id')) {
                $table->string('causer_id', 36)->nullable()->change();
            }

            if ($this->hasColumn('causer_type')) {
                $table->string('causer_type')->nullable()->change();
            }

            $this->updateTimestamps(table: $table, hasSoftDeletes: true);
        });
    }
};
