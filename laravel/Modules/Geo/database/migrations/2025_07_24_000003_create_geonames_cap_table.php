<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Models\GeoNamesCap;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = GeoNamesCap::class;

    public function up(): void
    {
        // -- CREATE --
        // Struttura ispirata al dataset "postal codes" di GeoNames.
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('country_code', 2)->nullable()->index()->comment('Codice paese ISO (es. IT)');
            $table->string('postal_code', 20)->nullable()->index()->comment('CAP / codice postale');
            $table->string('place_name')->nullable()->comment('Nome della località');
            $table->string('admin_name1')->nullable()->comment('Regione');
            $table->string('admin_code1', 20)->nullable()->comment('Codice regione');
            $table->string('admin_name2')->nullable()->comment('Provincia');
            $table->string('admin_code2', 20)->nullable()->comment('Codice provincia');
            $table->string('admin_name3')->nullable()->comment('Comune');
            $table->string('admin_code3', 20)->nullable()->comment('Codice comune');
            $table->decimal('latitude', 15, 10)->nullable();
            $table->decimal('longitude', 15, 10)->nullable();
            $table->unsignedTinyInteger('accuracy')->nullable()->comment('Accuratezza coordinate GeoNames');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Non duplicare timestamps - updateTimestamps() gestisce timestamps e soft deletes
            $this->updateTimestamps($table, true);
        });
    }
};
