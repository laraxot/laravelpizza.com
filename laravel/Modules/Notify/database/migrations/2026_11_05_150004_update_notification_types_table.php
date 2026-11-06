<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\NotificationType;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Update `Notify::notification_types` (schema drift round 2,
 * story notify-missing-tables-columns).
 *
 * Aggiunge le colonne richieste da `$fillable` del modello e dai test:
 * `slug`, `category`, `is_active`, `channels` (JSON) e `settings` (JSON).
 * La create canonica (`2026_03_03_000001`) non si tocca.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = NotificationType::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('slug')) {
                $table->string('slug')->nullable()->index();
            }

            if (! $this->hasColumn('category')) {
                $table->string('category')->nullable();
            }

            if (! $this->hasColumn('is_active')) {
                $table->boolean('is_active')->default(true);
            }

            if (! $this->hasColumn('channels')) {
                $table->json('channels')->nullable();
            }

            if (! $this->hasColumn('settings')) {
                $table->json('settings')->nullable();
            }

            $this->updateTimestamps($table, false);
        });
    }
};
