<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAssenzeTable.
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
                $table->integer('ente')->nullable();
                $table->integer('matr')->nullable();
                $table->string('conome', 150)->nullable();
                $table->string('nome', 150)->nullable();
                $table->integer('gg_aspettative_in_sede')->nullable();
                $table->integer('gg_aspettative_fuori_sede')->nullable();
                $table->integer('anno')->nullable();
            });
    }
};
