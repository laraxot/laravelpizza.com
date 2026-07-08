<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCategoriaProproTable.
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
                $table->string('categoria', 250)->nullable();
                $table->string('lista_propro', 250)->nullable();
                $table->string('lista_propro_sup', 250)->nullable();
                $table->integer('posti')->unsigned()->nullable()->default(0);
                $table->integer('anno')->unsigned()->nullable()->default(0);
            });
    }
};
