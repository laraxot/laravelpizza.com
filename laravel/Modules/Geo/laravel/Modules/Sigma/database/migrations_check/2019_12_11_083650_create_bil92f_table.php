<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateBil92fTable.
 */
class CreateBil92fTable extends XotBaseMigration
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
                $table->text('ente')->nullable();
                $table->text('annori')->nullable();
                $table->text('annoca')->nullable();
                $table->text('ruol')->nullable();
                $table->text('area1')->nullable();
                $table->text('area2')->nullable();
                $table->text('gruppo')->nullable();
                $table->text('impbil')->nullable();
                $table->text('fondo')->nullable();
                $table->text('aafon')->nullable();
                $table->text('ccfon')->nullable();
                $table->text('cproie')->nullable();
                $table->text('contra')->nullable();
                $table->text('voce')->nullable();
                $table->text('ist')->nullable();
                $table->text('cosann')->nullable();
                $table->text('onepe1')->nullable();
                $table->text('onepe2')->nullable();
                $table->text('onepe3')->nullable();
                $table->text('cospre')->nullable();
                $table->text('cosmes')->nullable();
                $table->text('one1')->nullable();
                $table->text('one2')->nullable();
                $table->text('one3')->nullable();
                $table->text('proiet')->nullable();
                $table->text('proiea')->nullable();
                $table->text('proiec')->nullable();
                $table->text('proieb')->nullable();
                $table->text('proied')->nullable();
                $table->text('pone1')->nullable();
                $table->text('pone2')->nullable();
                $table->text('pone3')->nullable();
                $table->text('totcom')->nullable();
                $table->text('tone1')->nullable();
                $table->text('tone2')->nullable();
                $table->text('tone3')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('bil92f');
    }
}
