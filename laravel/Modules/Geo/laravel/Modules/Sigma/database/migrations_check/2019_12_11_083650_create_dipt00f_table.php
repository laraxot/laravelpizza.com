<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateDipt00fTable.
 */
class CreateDipt00fTable extends XotBaseMigration
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
                $table->integer('enteap');
                $table->char('dtannu', 1);
                $table->integer('dtmatr');
                $table->char('dtturn', 3);
                $table->integer('dtdal');
                $table->integer('dtal');
                $table->char('dtcom1', 1);
                $table->char('dtcom2', 10);
                $table->integer('dtcom3');
                $table->integer('dtcom4');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('dipt00f');
    }
}
