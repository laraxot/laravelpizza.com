<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAnzianitaTable.
 */
return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->string('ente', 250)->nullable()->default('90');
                $table->string('matr', 250)->nullable();
                $table->string('propro', 250)->nullable();
                $table->string('posfun', 250)->nullable();
                $table->string('liv', 250)->nullable();
                $table->decimal('giorni', 10, 0)->nullable();
                $table->string('punt_anz', 250)->nullable();
                $table->string('anno', 250)->nullable();
                $table->string('giorni_in_fascia', 250)->nullable();
                $table->string('giorni_in_pa', 250)->nullable();
            });
    }
};
