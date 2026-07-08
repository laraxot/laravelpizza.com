<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAna00efTable.
 */
class CreateAna00efTable extends XotBaseMigration
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
                $table->integer('ente');
                $table->integer('matr');
                $table->char('conome', 25);
                $table->char('nome', 25);
                $table->char('cogacq', 25);
                $table->char('sesso', 1);
                $table->char('codfis', 16);
                $table->char('staciv', 1);
                $table->integer('anadat');
                $table->integer('comnas');
                $table->integer('clafun');
                $table->integer('titstu');
                $table->integer('entpro');
                $table->integer('sinda');
                $table->integer('sinda2');
                $table->integer('sinda3');
                $table->integer('catspe');
                $table->integer('titpro');
                $table->char('topo', 3);
                $table->char('indir', 40);
                $table->char('locres', 40);
                $table->integer('comres');
                $table->integer('cap');
                $table->char('topod', 3);
                $table->char('indird', 40);
                $table->char('locdom', 40);
                $table->integer('comdom');
                $table->integer('capdom');
                $table->char('pretel', 7);
                $table->char('numtel', 9);
                $table->integer('tipag');
                $table->integer('stabi');
                $table->integer('repar');
                $table->integer('banca1');
                $table->integer('agen1');
                $table->char('conto1', 20);
                $table->integer('banca2');
                $table->integer('agen2');
                $table->char('conto2', 20);
                $table->integer('imp2');
                $table->char('codass', 16);
                $table->char('codpre', 16);
                $table->char('codic1', 16);
                $table->char('codic2', 16);
                $table->char('inail', 1);
                $table->integer('matseg');
                $table->integer('tipdip');
                $table->decimal('fematc', 9);
                $table->decimal('fegodc', 9);
                $table->decimal('fesopm', 7);
                $table->decimal('fesopg', 7);
                $table->decimal('femata', 9);
                $table->decimal('fegoda', 9);
                $table->char('flagse', 1);
                $table->char('anaann', 1);
                $table->char('lireu', 1);
                $table->integer('ana2kd');
                $table->decimal('impeu', 11, 3);
                $table->integer('comna2');
                $table->integer('comre2');
                $table->integer('comdo2');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ana00ef');
    }
}
