<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateStipendioTabellareTable.
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
                $table->integer('id', true);
                $table->string('categoria', 50)->nullable();
                $table->string('lista_propro', 250)->nullable();
                $table->integer('posfun')->nullable();
                $table->date('dal')->nullable();
                $table->date('al')->nullable();
                $table->integer('propro')->unsigned()->nullable();
                $table->decimal('euro_pond', 10, 4)->unsigned()->nullable();
                $table->decimal('ptime', 10, 4)->unsigned()->nullable();
                $table->decimal('euro', 10, 4)->unsigned()->nullable();
                $table->decimal('importo_stipendio_annuo', 10, 4)->unsigned()->nullable();
                $table->integer('anno')->unsigned()->nullable();
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                $this->updateTimestamps($table);
            }
        );
    }
};
