<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAli12Table.
 */
class CreateAli12Table extends XotBaseMigration
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
                $table->text('flag')->nullable();
                $table->text('ente')->nullable();
                $table->text('matr')->nullable();
                $table->text('conome')->nullable();
                $table->text('nome')->nullable();
                $table->text('area')->nullable();
                $table->text('stab')->nullable();
                $table->text('repa')->nullable();
                $table->text('desar')->nullable();
                $table->text('desst')->nullable();
                $table->text('desse')->nullable();
                $table->text('cont')->nullable();
                $table->text('tipco')->nullable();
                $table->text('rapp')->nullable();
                $table->text('ruolo')->nullable();
                $table->text('propro')->nullable();
                $table->text('posfun')->nullable();
                $table->text('fascia')->nullable();
                $table->text('codqua')->nullable();
                $table->text('liv')->nullable();
                $table->text('oree')->nullable();
                $table->text('oret')->nullable();
                $table->text('idpsz')->nullable();
                $table->text('rapdes')->nullable();
                $table->text('despr')->nullable();
                $table->text('desco')->nullable();
                $table->text('desdi')->nullable();
                $table->text('impo1')->nullable();
                $table->text('impo2')->nullable();
                $table->text('impo3')->nullable();
                $table->text('impo4')->nullable();
                $table->text('impo5')->nullable();
                $table->text('impo6')->nullable();
                $table->text('impo7')->nullable();
                $table->text('idcam')->nullable();
                $table->text('ruo11')->nullable();
                $table->text('pro11')->nullable();
                $table->text('pos11')->nullable();
                $table->text('fas11')->nullable();
                $table->text('liv11')->nullable();
                $table->text('ore11')->nullable();
                $table->text('ort11')->nullable();
                $table->text('impo1p')->nullable();
                $table->text('impo2p')->nullable();
                $table->text('impo3p')->nullable();
                $table->text('impo4p')->nullable();
                $table->text('impo5p')->nullable();
                $table->text('impo6p')->nullable();
                $table->text('impo7p')->nullable();
                $table->text('delta')->nullable();
                $table->text('mesi')->nullable();
                $table->text('impo1d')->nullable();
                $table->text('impo2d')->nullable();
                $table->text('impo3d')->nullable();
                $table->text('impo4d')->nullable();
                $table->text('impo5d')->nullable();
                $table->text('impo6d')->nullable();
                $table->text('impo7d')->nullable();
                $table->text('datarp')->nullable();
                $table->text('datara')->nullable();
                $table->text('lib1')->nullable();
                $table->text('lib2')->nullable();
                $table->text('lib3')->nullable();
                $table->text('lib4')->nullable();
                $table->text('lib5')->nullable();
                $table->text('lib6')->nullable();
                $table->text('lib7')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ali12');
    }
}
