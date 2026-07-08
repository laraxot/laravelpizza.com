<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAna10fTable.
 */
class CreateAna10fTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('tiprec');
                $table->integer('ente');
                $table->integer('matr');
                $table->char('conome', 25);
                $table->char('nome', 25);
                $table->char('sesso', 1);
                $table->char('staciv', 1);
                $table->integer('clafun');
                $table->integer('titstu');
                $table->integer('entpro');
                $table->integer('sindac');
                $table->integer('catspe');
                $table->integer('titpro');
                $table->integer('tipag');
                $table->integer('stabi');
                $table->integer('repar');
                $table->integer('banca1');
                $table->integer('agen1');
                $table->char('conto1', 20);
                $table->char('inail', 1);
                $table->char('flagse', 1);
                $table->integer('stass');
                $table->integer('stdim');
                $table->integer('tipass');
                $table->integer('tipdim');
                $table->integer('repdal');
                $table->integer('repal');
                $table->integer('repst1');
                $table->integer('repre1');
                $table->integer('repst2');
                $table->integer('repre2');
                $table->integer('piaorg');
                $table->integer('qudal');
                $table->integer('qual');
                $table->integer('quanz');
                $table->integer('annise');
                $table->integer('posiz');
                $table->integer('datpas');
                $table->decimal('oree', 7);
                $table->decimal('oret', 7);
                $table->integer('cont');
                $table->integer('tipco');
                $table->integer('rapp');
                $table->integer('ruolo');
                $table->integer('propro');
                $table->integer('posfun');
                $table->integer('codqua');
                $table->integer('disci1');
                $table->integer('jipco');
                $table->integer('japp');
                $table->integer('juolo');
                $table->integer('jropro');
                $table->integer('josfun');
                $table->integer('jodqua');
                $table->integer('jisci2');
                $table->integer('tipasp');
                $table->integer('aspin');
                $table->integer('aspte');
                $table->char('anaann', 1);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ana10f');
    }
}
