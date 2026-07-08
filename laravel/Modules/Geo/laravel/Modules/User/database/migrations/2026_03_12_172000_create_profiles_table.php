<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Profile;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * PHILOSOPHY - ONE MIGRATION PER TABLE:
 * Laraxot uses a single authoritative migration file per table/model.
 * To evolve the schema, we modify THIS file and update its timestamp so it
 * re-runs. We never create separate alter/add/repair migrations.
 *
 * LARAXOT ID+UUID CONTRACT:
 * Every table must have:
 *   - `id`   bigint unsigned AUTO_INCREMENT PRIMARY KEY  (internal DB reference)
 *   - `uuid` char(36) nullable indexed                  (external/public reference)
 * The `id` is NEVER exposed in APIs or URLs; `uuid` is used for all external
 * references. XotBaseModel::casts() already handles both.
 */
return new class extends XotBaseMigration {
    protected ?string $model_class = Profile::class;

    public function up(): void
    {
        // -- CREATE (new installations) --
        $this->tableCreate(static function (Blueprint $table): void {
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
        });
    }
};
