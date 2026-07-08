<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAna20l01Table.
 */
class CreateAna20l01Table extends XotBaseMigration
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
                $table->text('tiprec')->nullable();
                $table->text('ente')->nullable();
                $table->text('matr')->nullable();
                $table->text('conome')->nullable();
                $table->text('nome')->nullable();
                $table->text('sesso')->nullable();
                $table->text('staciv')->nullable();
                $table->text('clafun')->nullable();
                $table->text('titstu')->nullable();
                $table->text('entpro')->nullable();
                $table->text('sindac')->nullable();
                $table->text('catspe')->nullable();
                $table->text('titpro')->nullable();
                $table->text('tipag')->nullable();
                $table->text('stabi')->nullable();
                $table->text('repar')->nullable();
                $table->text('banca1')->nullable();
                $table->text('agen1')->nullable();
                $table->text('conto1')->nullable();
                $table->text('inail')->nullable();
                $table->text('flagse')->nullable();
                $table->text('stass')->nullable();
                $table->text('stdim')->nullable();
                $table->text('tipass')->nullable();
                $table->text('tipdim')->nullable();
                $table->text('repdal')->nullable();
                $table->text('repal')->nullable();
                $table->text('repst1')->nullable();
                $table->text('repre1')->nullable();
                $table->text('repst2')->nullable();
                $table->text('repre2')->nullable();
                $table->text('piaorg')->nullable();
                $table->text('qudal')->nullable();
                $table->text('qual')->nullable();
                $table->text('quanz')->nullable();
                $table->text('annise')->nullable();
                $table->text('posiz')->nullable();
                $table->text('datpas')->nullable();
                $table->text('oree')->nullable();
                $table->text('oret')->nullable();
                $table->text('cont')->nullable();
                $table->text('tipco')->nullable();
                $table->text('rapp')->nullable();
                $table->text('ruolo')->nullable();
                $table->text('propro')->nullable();
                $table->text('posfun')->nullable();
                $table->text('codqua')->nullable();
                $table->text('disci1')->nullable();
                $table->text('jipco')->nullable();
                $table->text('japp')->nullable();
                $table->text('juolo')->nullable();
                $table->text('jropro')->nullable();
                $table->text('josfun')->nullable();
                $table->text('jodqua')->nullable();
                $table->text('jisci2')->nullable();
                $table->text('tipasp')->nullable();
                $table->text('aspin')->nullable();
                $table->text('aspte')->nullable();
                $table->text('datdal')->nullable();
                $table->text('datal')->nullable();
                $table->text('anaann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ana20l01');
    }
}
