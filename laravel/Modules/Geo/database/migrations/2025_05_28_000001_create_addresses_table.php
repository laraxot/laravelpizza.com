<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Models\Address;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Address::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table
            $table->id();
            $table->nullableUuidMorphs('model'); // Supporta sia UUID (user) che interi (altri modelli)

            // Campi informativi
            $table->string('name')->nullable()->comment('Nome identificativo dell\'indirizzo');
            $table->text('description')->nullable()->comment('Descrizione opzionale');
            $table->string('phone')->nullable()->comment('Numero di telefono associato all\'indirizzo');

            // Campi indirizzo (evitando prefissi ridondanti)
            $table->string('route')->nullable()->comment('Via/Piazza');
            $table->string('street_number')->nullable()->comment('Numero civico');
            $table->string('locality')->nullable()->comment('Località/Frazione');
            $table->string('administrative_area_level_3')->nullable()->comment('Comune/Città');
            $table->string('administrative_area_level_2')->nullable()->comment('Provincia');
            $table->string('administrative_area_level_1')->nullable()->comment('Regione');
            $table->string('country', 2)->nullable()->comment('Codice paese ISO');
            $table->string('postal_code', 20)->nullable()->comment('CAP');

            // Dati di geocoding
            $table->text('formatted_address')->nullable();
            $table->string('place_id')->nullable()->comment('ID Google Places');
            $table->decimal('latitude', 15, 10)->nullable();
            $table->decimal('longitude', 15, 10)->nullable();

            // Campi tipo indirizzo
            $table->string('type', 50)->nullable()->index()->comment('Tipo indirizzo (home, work, etc.)');
            $table->boolean('is_primary')->default(false)->index();

            // Dati aggiuntivi
            $table->json('extra_data')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table
            // Non duplicare timestamps - updateTimestamps() già li gestisce
            $this->updateTimestamps($table, true); // Aggiunge timestamps e soft deletes
        });
    }
};
