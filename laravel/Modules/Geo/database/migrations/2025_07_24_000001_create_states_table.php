<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Models\State;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = State::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('state')->comment('Nome dello stato/regione');
            $table->string('state_code', 10)->nullable()->index()->comment('Codice dello stato/regione');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Non duplicare timestamps - updateTimestamps() gestisce timestamps e soft deletes
            $this->updateTimestamps($table, true);
        });
    }
};
