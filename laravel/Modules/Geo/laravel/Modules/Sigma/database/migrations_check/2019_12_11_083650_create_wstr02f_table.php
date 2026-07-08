<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWstr02fTable.
 */
class CreateWstr02fTable extends XotBaseMigration
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
                $table->char('w2annu', 1)->index();
                $table->integer('enteap')->index();
                $table->integer('stdata')->index();
                $table->integer('ortobb');
                $table->integer('w2matr')->index();
                $table->char('w2orar', 3);
                $table->integer('w2odat');
                $table->char('w2turn', 3);
                $table->integer('w2tdat');
                $table->char('w2chiu', 1);
                $table->char('w2moda', 1);
                $table->char('w2modp', 1);
                $table->char('w2quad', 3);
                $table->integer('w2sogl');
                $table->integer('w2sogd');
                $table->integer('w2vent');
                $table->integer('w2vesc');
                $table->integer('w2tent');
                $table->integer('w2tesc');
                $table->integer('w2pesg');
                $table->integer('w2mint');
                $table->integer('w2minp');
                $table->integer('w2stab');
                $table->integer('w2repa');
                $table->char('w2pers', 1);
                $table->integer('w2aper');
                $table->integer('w2anom');
                $table->char('w2orae', 12);
                $table->char('w2orau', 12);
                $table->char('w2svil', 1);
                $table->char('w2teef', 1);
                $table->integer('w2minf');
                $table->char('w2aste', 1);
                $table->char('w2gipe', 1);
                $table->integer('w2calc');
                $table->char('w2corr', 1);
                $table->integer('w2flg1');
                $table->integer('w2flg2');
                $table->integer('w2flg3');
                $table->integer('w2flg4');
                $table->integer('w2tora');
                $table->integer('w2ttur');
                $table->char('w2tfes', 1);
                $table->integer('w2ruol');
                $table->integer('w2prof');
                $table->integer('w2posi');
                $table->integer('w2rapp');
                $table->integer('w2cont');
                $table->integer('w2paui');
                $table->integer('w2pauf');
                $table->integer('w2paum');
                $table->integer('w2paus');
                $table->integer('w2ince');
                $table->integer('w2incc');
                $table->char('w2com1', 10);
                $table->integer('w2com2');
                $table->integer('w2com3');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wstr02f');
    }
}
