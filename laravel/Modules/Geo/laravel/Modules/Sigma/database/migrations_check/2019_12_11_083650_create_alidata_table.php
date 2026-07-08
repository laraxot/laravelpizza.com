<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAlidataTable.
 */
class CreateAlidataTable extends XotBaseMigration
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
                $table->text('matr')->nullable();
                $table->text('conome')->nullable();
                $table->text('nome')->nullable();
                $table->text('datn')->nullable();
                $table->text('comn')->nullable();
                $table->text('codf')->nullable();
                $table->text('sess')->nullable();
                $table->text('comr')->nullable();
                $table->text('pror')->nullable();
                $table->text('locr')->nullable();
                $table->text('topr')->nullable();
                $table->text('viar')->nullable();
                $table->text('capr')->nullable();
                $table->text('ass')->nullable();
                $table->text('dim')->nullable();
                $table->text('sta')->nullable();
                $table->text('stad')->nullable();
                $table->text('rep')->nullable();
                $table->text('repd')->nullable();
                $table->text('ca1')->nullable();
                $table->text('ca1d')->nullable();
                $table->text('cb1')->nullable();
                $table->text('cb1d')->nullable();
                $table->text('cc1')->nullable();
                $table->text('cc1d')->nullable();
                $table->text('pr1')->nullable();
                $table->text('ca2')->nullable();
                $table->text('ca2d')->nullable();
                $table->text('cb2')->nullable();
                $table->text('cb2d')->nullable();
                $table->text('cc2')->nullable();
                $table->text('cc2d')->nullable();
                $table->text('pr2')->nullable();
                $table->text('ca3')->nullable();
                $table->text('ca3d')->nullable();
                $table->text('cb3')->nullable();
                $table->text('cb3d')->nullable();
                $table->text('cc3')->nullable();
                $table->text('cc3d')->nullable();
                $table->text('pr3')->nullable();
                $table->text('con')->nullable();
                $table->text('rap')->nullable();
                $table->text('ruo')->nullable();
                $table->text('pro')->nullable();
                $table->text('pos')->nullable();
                $table->text('man')->nullable();
                $table->text('dis')->nullable();
                $table->text('prod')->nullable();
                $table->text('disd')->nullable();
                $table->text('qu1d')->nullable();
                $table->text('qu2d')->nullable();
                $table->text('quli')->nullable();
                $table->text('fascia')->nullable();
                $table->text('pt1')->nullable();
                $table->text('pt2')->nullable();
                $table->text('poo')->nullable();
                $table->text('pood')->nullable();
                $table->text('cat1')->nullable();
                $table->text('decat1')->nullable();
                $table->text('cat2')->nullable();
                $table->text('decat2')->nullable();
                $table->text('tit')->nullable();
                $table->text('destit')->nullable();
                $table->text('ina')->nullable();
                $table->text('desina')->nullable();
                $table->text('cla')->nullable();
                $table->text('descla')->nullable();
                $table->text('irap')->nullable();
                $table->text('deirap')->nullable();
                $table->text('datsca')->nullable();
                $table->text('cliv1')->nullable();
                $table->text('dliv1')->nullable();
                $table->text('cliv2')->nullable();
                $table->text('dliv2')->nullable();
                $table->text('cliv3')->nullable();
                $table->text('dliv3')->nullable();
                $table->text('cliv4')->nullable();
                $table->text('dliv4')->nullable();
                $table->text('cliv5')->nullable();
                $table->text('dliv5')->nullable();
                $table->text('cliv6')->nullable();
                $table->text('dliv6')->nullable();
                $table->text('cliv7')->nullable();
                $table->text('dliv7')->nullable();
                $table->text('cliv8')->nullable();
                $table->text('dliv8')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('alidata');
    }
}
