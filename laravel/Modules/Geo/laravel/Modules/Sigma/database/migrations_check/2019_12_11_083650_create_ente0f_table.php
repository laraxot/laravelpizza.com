<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEnte0fTable.
 */
class CreateEnte0fTable extends XotBaseMigration
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
                $table->text('ENTE')->nullable();
                $table->text('ENDES')->nullable();
                $table->text('ENIND')->nullable();
                $table->text('ENCAP')->nullable();
                $table->text('ENLOC')->nullable();
                $table->text('ENPRO')->nullable();
                $table->text('ENTDPO')->nullable();
                $table->text('ENTDP3')->nullable();
                $table->text('SCAD01')->nullable();
                $table->text('SCAD02')->nullable();
                $table->text('SCAD03')->nullable();
                $table->text('ENTPRE')->nullable();
                $table->text('ENTMAT')->nullable();
                $table->text('D019I1')->nullable();
                $table->text('D019I2')->nullable();
                $table->text('D019I3')->nullable();
                $table->text('D019I4')->nullable();
                $table->text('D019F1')->nullable();
                $table->text('D019F2')->nullable();
                $table->text('D019F3')->nullable();
                $table->text('D019F4')->nullable();
                $table->text('D019F5')->nullable();
                $table->text('D019F6')->nullable();
                $table->text('ENANNO')->nullable();
                $table->text('SMCOD')->nullable();
                $table->text('SMCAT')->nullable();
                $table->text('SMDEN')->nullable();
                $table->text('SMIND')->nullable();
                $table->text('SMLOC')->nullable();
                $table->text('SMRL1')->nullable();
                $table->text('SMRL2')->nullable();
                $table->text('DES101')->nullable();
                $table->text('IND101')->nullable();
                $table->text('ATI101')->nullable();
                $table->text('DOM101')->nullable();
                $table->text('SED101')->nullable();
                $table->text('PRO101')->nullable();
                $table->text('CAP101')->nullable();
                $table->text('RAP101')->nullable();
                $table->text('FIR101')->nullable();
                $table->text('CAT101')->nullable();
                $table->text('CF101')->nullable();
                $table->text('PIV101')->nullable();
                $table->text('M01')->nullable();
                $table->text('M02')->nullable();
                $table->text('M03')->nullable();
                $table->text('M04')->nullable();
                $table->text('M05')->nullable();
                $table->text('M06')->nullable();
                $table->text('M07')->nullable();
                $table->text('M08')->nullable();
                $table->text('D246I1')->nullable();
                $table->text('D246I2')->nullable();
                $table->text('D246I3')->nullable();
                $table->text('D246I4')->nullable();
                $table->text('D246I5')->nullable();
                $table->text('D246I6')->nullable();
                $table->text('D246I7')->nullable();
                $table->text('D246I8')->nullable();
                $table->text('D246F1')->nullable();
                $table->text('D246F2')->nullable();
                $table->text('D246F3')->nullable();
                $table->text('DVP001')->nullable();
                $table->text('DVP002')->nullable();
                $table->text('DVP003')->nullable();
                $table->text('DVP004')->nullable();
                $table->text('M350P1')->nullable();
                $table->text('M350P2')->nullable();
                $table->text('DINQ01')->nullable();
                $table->text('DINQ02')->nullable();
                $table->text('DINQ03')->nullable();
                $table->text('DINQ11')->nullable();
                $table->text('DINQ12')->nullable();
                $table->text('DINQ13')->nullable();
                $table->text('DINQ21')->nullable();
                $table->text('DINQ22')->nullable();
                $table->text('DINQ23')->nullable();
                $table->text('MIS001')->nullable();
                $table->text('MIS002')->nullable();
                $table->text('MIS003')->nullable();
                $table->text('MIS011')->nullable();
                $table->text('MIS012')->nullable();
                $table->text('MIS013')->nullable();
                $table->text('RUR001')->nullable();
                $table->text('RUR002')->nullable();
                $table->text('RUR003')->nullable();
                $table->text('RUR004')->nullable();
                $table->text('RUR011')->nullable();
                $table->text('RUR012')->nullable();
                $table->text('RUR013')->nullable();
                $table->text('RUR021')->nullable();
                $table->text('RUR022')->nullable();
                $table->text('RUR023')->nullable();
                $table->text('ENANN')->nullable();
                $table->text('DESTA')->nullable();
                $table->text('TIPSTA')->nullable();
                $table->text('CODSTA')->nullable();
                $table->text('FNOM')->nullable();
                $table->text('FCON')->nullable();
                $table->text('FQUA')->nullable();
                $table->text('FTEL')->nullable();
                $table->text('RNOM')->nullable();
                $table->text('RCON')->nullable();
                $table->text('RTEL')->nullable();
                $table->text('RUFF')->nullable();
                $table->text('RIND')->nullable();
                $table->text('C00001')->nullable();
                $table->text('C00002')->nullable();
                $table->text('C00003')->nullable();
                $table->text('C00004')->nullable();
                $table->text('C00005')->nullable();
                $table->text('C00006')->nullable();
                $table->text('C00007')->nullable();
                $table->text('C00008')->nullable();
                $table->text('C00009')->nullable();
                $table->text('C00010')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ente0f');
    }
}
