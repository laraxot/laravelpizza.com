<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAlianzTable.
 */
class CreateAlianzTable extends XotBaseMigration
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
                $table->text('assu1_assunzione')->nullable();
                $table->text('dimi1_dimissione')->nullable();
                $table->text('stab_stabilimento')->nullable();
                $table->text('repa_reparto')->nullable();
                $table->text('desst')->nullable();
                $table->text('desre')->nullable();
                $table->text('datn1_data_nascita')->nullable();
                $table->text('eta')->nullable();
                $table->text('sess1')->nullable();
                $table->text('codf11')->nullable();
                $table->text('gru1')->nullable();
                $table->text('con1')->nullable();
                $table->text('tip1')->nullable();
                $table->text('rap1')->nullable();
                $table->text('ruo1')->nullable();
                $table->text('pro1')->nullable();
                $table->text('pos1')->nullable();
                $table->text('man1')->nullable();
                $table->text('dis1')->nullable();
                $table->text('qu1d')->nullable();
                $table->text('qu2d')->nullable();
                $table->text('qu3d')->nullable();
                $table->text('quli')->nullable();
                $table->text('pt1')->nullable();
                $table->text('pt2')->nullable();
                $table->text('poo')->nullable();
                $table->text('datpr1')->nullable();
                $table->text('gg1c')->nullable();
                $table->text('aa1')->nullable();
                $table->text('mm1')->nullable();
                $table->text('gg1')->nullable();
                $table->text('gg1as')->nullable();
                $table->text('gg2c')->nullable();
                $table->text('aa2')->nullable();
                $table->text('mm2')->nullable();
                $table->text('gg2')->nullable();
                $table->text('gg2as')->nullable();
                $table->text('gg3c')->nullable();
                $table->text('aa3')->nullable();
                $table->text('mm3')->nullable();
                $table->text('gg3')->nullable();
                $table->text('gg3as')->nullable();
                $table->text('gg4c')->nullable();
                $table->text('aa4')->nullable();
                $table->text('mm4')->nullable();
                $table->text('gg4')->nullable();
                $table->text('gg5c')->nullable();
                $table->text('aa5')->nullable();
                $table->text('mm5')->nullable();
                $table->text('gg5')->nullable();
                $table->text('gg5as')->nullable();
                $table->text('gg6c')->nullable();
                $table->text('aa6')->nullable();
                $table->text('mm6')->nullable();
                $table->text('gg6')->nullable();
                $table->text('gg6as')->nullable();
                $table->text('gg6cco')->nullable();
                $table->text('datai2')->nullable();
                $table->text('titstu')->nullable();
                $table->text('codstu')->nullable();
                $table->text('destit')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('alianz');
    }
}
