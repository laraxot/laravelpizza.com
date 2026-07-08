<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWstr02l1Table.
 */
class CreateWstr02l1Table extends XotBaseMigration
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
                $table->text('w2annu')->nullable();
                $table->text('enteap')->nullable();
                $table->text('stdata')->nullable();
                $table->text('ortobb')->nullable();
                $table->text('w2matr')->nullable();
                $table->text('w2orar')->nullable();
                $table->text('w2odat')->nullable();
                $table->text('w2turn')->nullable();
                $table->text('w2tdat')->nullable();
                $table->text('w2chiu')->nullable();
                $table->text('w2moda')->nullable();
                $table->text('w2modp')->nullable();
                $table->text('w2quad')->nullable();
                $table->text('w2sogl')->nullable();
                $table->text('w2sogd')->nullable();
                $table->text('w2vent')->nullable();
                $table->text('w2vesc')->nullable();
                $table->text('w2tent')->nullable();
                $table->text('w2tesc')->nullable();
                $table->text('w2pesg')->nullable();
                $table->text('w2mint')->nullable();
                $table->text('w2minp')->nullable();
                $table->text('w2stab')->nullable();
                $table->text('w2repa')->nullable();
                $table->text('w2pers')->nullable();
                $table->text('w2aper')->nullable();
                $table->text('w2anom')->nullable();
                $table->text('w2orae')->nullable();
                $table->text('w2orau')->nullable();
                $table->text('w2svil')->nullable();
                $table->text('w2teef')->nullable();
                $table->text('w2minf')->nullable();
                $table->text('w2aste')->nullable();
                $table->text('w2gipe')->nullable();
                $table->text('w2calc')->nullable();
                $table->text('w2corr')->nullable();
                $table->text('w2flg1')->nullable();
                $table->text('w2flg2')->nullable();
                $table->text('w2flg3')->nullable();
                $table->text('w2flg4')->nullable();
                $table->text('w2tora')->nullable();
                $table->text('w2ttur')->nullable();
                $table->text('w2tfes')->nullable();
                $table->text('w2ruol')->nullable();
                $table->text('w2prof')->nullable();
                $table->text('w2posi')->nullable();
                $table->text('w2rapp')->nullable();
                $table->text('w2cont')->nullable();
                $table->text('w2paui')->nullable();
                $table->text('w2pauf')->nullable();
                $table->text('w2paum')->nullable();
                $table->text('w2paus')->nullable();
                $table->text('w2ince')->nullable();
                $table->text('w2incc')->nullable();
                $table->text('w2com1')->nullable();
                $table->text('w2com2')->nullable();
                $table->text('w2com3')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wstr02l1');
    }
}
