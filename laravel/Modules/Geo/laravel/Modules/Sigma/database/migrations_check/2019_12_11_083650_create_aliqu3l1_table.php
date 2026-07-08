<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAliqu3l1Table.
 */
class CreateAliqu3l1Table extends XotBaseMigration
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
                $table->text('q3tipo')->nullable();
                $table->text('q3pro')->nullable();
                $table->text('q3fun')->nullable();
                $table->text('q32kd')->nullable();
                $table->text('q32ka')->nullable();
                $table->text('pt1q3')->nullable();
                $table->text('pt2q3')->nullable();
                $table->text('q3desc')->nullable();
                $table->text('q3des2')->nullable();
                $table->text('q32ka1')->nullable();
                $table->text('q32ka2')->nullable();
                $table->text('q3003')->nullable();
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
                $table->text('pt1')->nullable();
                $table->text('pt2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('aliqu3l1');
    }
}
