<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAlianz31122008tuttiTable.
 */
class CreateAlianz31122008tuttiTable extends XotBaseMigration
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
                $table->text('assu1')->nullable();
                $table->text('dimi1')->nullable();
                $table->text('stab')->nullable();
                $table->text('repa')->nullable();
                $table->text('desst')->nullable();
                $table->text('desre')->nullable();
                $table->text('datn1')->nullable();
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
                $table->text('fasc1')->nullable();
                $table->text('fasdat')->nullable();
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
                $table->text('servp')->nullable();
                $table->text('datai2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('alianz31122008tutti');
    }
}
