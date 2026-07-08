<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCor04l3Table.
 */
class CreateCor04l3Table extends XotBaseMigration
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
                $table->text('anno')->nullable();
                $table->text('mese')->nullable();
                $table->text('aaliq')->nullable();
                $table->text('mmliq')->nullable();
                $table->text('seqc')->nullable();
                $table->text('profil')->nullable();
                $table->text('datcar')->nullable();
                $table->text('tipmc')->nullable();
                $table->text('anncor')->nullable();
                $table->text('codcor')->nullable();
                $table->text('form')->nullable();
                $table->text('qtac')->nullable();
                $table->text('impuni')->nullable();
                $table->text('risul')->nullable();
                $table->text('istit')->nullable();
                $table->text('numpro')->nullable();
                $table->text('area')->nullable();
                $table->text('numero')->nullable();
                $table->text('tipod')->nullable();
                $table->text('tipcod')->nullable();
                $table->text('cor001')->nullable();
                $table->text('cor002')->nullable();
                $table->text('datmis')->nullable();
                $table->text('cc1')->nullable();
                $table->text('cc2')->nullable();
                $table->text('cc3')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('cor04l3');
    }
}
