<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Device;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Compatibility migration for installations that already own `devices`.
 *
 * The original file was a second direct `Schema::create()` for a table already
 * owned by the 2023 migration. Existing installations therefore failed with
 * "table already exists" instead of receiving the additive schema.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Device::class;

    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->string('uuid', 36)->nullable()->index();
            $table->string('mobile_id')->nullable()->index();
            $table->json('languages')->nullable();
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('version')->nullable();
            $table->boolean('is_robot')->nullable();
            $table->string('robot')->nullable();
            $table->boolean('is_desktop')->nullable();
            $table->boolean('is_mobile')->nullable();
            $table->boolean('is_tablet')->nullable();
            $table->boolean('is_phone')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, hasSoftDeletes: true);
        });
    }

    /**
     * This compatibility migration must never drop the shared device registry.
     */
    public function down(): void {}
};
