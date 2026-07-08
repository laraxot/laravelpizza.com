<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCor01fTable.
 */
class CreateCor01fTable extends XotBaseMigration
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
                $table->text('anno')->nullable();
                $table->text('codcor')->nullable();
                $table->text('proeve')->nullable();
                $table->text('nediz')->nullable();
                $table->text('mater')->nullable();
                $table->text('concor')->nullable();
                $table->text('tipo01')->nullable();
                $table->text('tipo02')->nullable();
                $table->text('desco1')->nullable();
                $table->text('desco2')->nullable();
                $table->text('obiet1')->nullable();
                $table->text('obiet2')->nullable();
                $table->text('obiet3')->nullable();
                $table->text('resnom')->nullable();
                $table->text('restel')->nullable();
                $table->text('resema')->nullable();
                $table->text('prelir')->nullable();
                $table->text('finlir')->nullable();
                $table->text('preeur')->nullable();
                $table->text('fineur')->nullable();
                $table->text('luogo1')->nullable();
                $table->text('luogo2')->nullable();
                $table->text('discor')->nullable();
                $table->text('percor')->nullable();
                $table->text('organ1')->nullable();
                $table->text('organ2')->nullable();
                $table->text('datcor')->nullable();
                $table->text('daore')->nullable();
                $table->text('aore')->nullable();
                $table->text('nore')->nullable();
                $table->text('dalcor')->nullable();
                $table->text('alcor')->nullable();
                $table->text('ngio')->nullable();
                $table->text('tabaut')->nullable();
                $table->text('dataut')->nullable();
                $table->text('nproto')->nullable();
                $table->text('cosdoe')->nullable();
                $table->text('cosale')->nullable();
                $table->text('cosise')->nullable();
                $table->text('cosecm')->nullable();
                $table->text('prespe')->nullable();
                $table->text('preimp')->nullable();
                $table->text('pasto')->nullable();
                $table->text('ceco1')->nullable();
                $table->text('ceco2')->nullable();
                $table->text('ceco3')->nullable();
                $table->text('necm1')->nullable();
                $table->text('necm2')->nullable();
                $table->text('crecme')->nullable();
                $table->text('ecmdat')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('cor01f');
    }
}
