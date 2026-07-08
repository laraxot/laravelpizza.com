<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAnagdicTable.
 */
class CreateAnagdicTable extends XotBaseMigration
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
                $table->text('cogacq')->nullable();
                $table->text('sesso')->nullable();
                $table->text('codfis')->nullable();
                $table->text('staciv')->nullable();
                $table->text('anadat')->nullable();
                $table->text('comnas')->nullable();
                $table->text('clafun')->nullable();
                $table->text('titstu')->nullable();
                $table->text('entpro')->nullable();
                $table->text('sinda')->nullable();
                $table->text('sinda2')->nullable();
                $table->text('sinda3')->nullable();
                $table->text('catspe')->nullable();
                $table->text('titpro')->nullable();
                $table->text('topo')->nullable();
                $table->text('indir')->nullable();
                $table->text('locres')->nullable();
                $table->text('comres')->nullable();
                $table->text('cap')->nullable();
                $table->text('topod')->nullable();
                $table->text('indird')->nullable();
                $table->text('locdom')->nullable();
                $table->text('comdom')->nullable();
                $table->text('capdom')->nullable();
                $table->text('pretel')->nullable();
                $table->text('numtel')->nullable();
                $table->text('tipag')->nullable();
                $table->text('stabi')->nullable();
                $table->text('repar')->nullable();
                $table->text('banca1')->nullable();
                $table->text('agen1')->nullable();
                $table->text('conto1')->nullable();
                $table->text('banca2')->nullable();
                $table->text('agen2')->nullable();
                $table->text('conto2')->nullable();
                $table->text('imp2')->nullable();
                $table->text('codass')->nullable();
                $table->text('codpre')->nullable();
                $table->text('codic1')->nullable();
                $table->text('codic2')->nullable();
                $table->text('inail')->nullable();
                $table->text('matseg')->nullable();
                $table->text('tipdip')->nullable();
                $table->text('fematc')->nullable();
                $table->text('fegodc')->nullable();
                $table->text('fesopm')->nullable();
                $table->text('fesopg')->nullable();
                $table->text('femata')->nullable();
                $table->text('fegoda')->nullable();
                $table->text('flagse')->nullable();
                $table->text('anaann')->nullable();
                $table->text('lireu')->nullable();
                $table->text('ana2kd')->nullable();
                $table->text('impeu')->nullable();
                $table->text('comna2')->nullable();
                $table->text('comre2')->nullable();
                $table->text('comdo2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('anagdic');
    }
}
