<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAcco4fTable.
 */
class CreateAcco4fTable extends XotBaseMigration
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
                $table->integer('datces');
                $table->char('tipoce', 3);
                $table->char('con92', 2);
                $table->char('conces', 2);
                $table->integer('datpre');
                $table->integer('datapp');
                $table->text('per92');
                $table->char('ris92', 108);
                $table->char('ric92', 132);
                $table->text('per93');
                $table->char('ris93', 108);
                $table->char('ric93', 132);
                $table->text('per95');
                $table->char('ris95', 108);
                $table->char('ric95', 132);
                $table->text('ret93');
                $table->text('riv93');
                $table->text('med93');
                $table->integer('aadura');
                $table->integer('mmdura');
                $table->integer('ggdura');
                $table->integer('audura');
                $table->integer('mudura');
                $table->integer('gudura');
                $table->integer('aardur');
                $table->integer('mardur');
                $table->integer('aaut92');
                $table->integer('mmut92');
                $table->integer('ggut92');
                $table->integer('aaar92');
                $table->integer('mmar92');
                $table->integer('anzr92');
                $table->integer('aa92ar');
                $table->integer('aama92');
                $table->decimal('cost92', 7, 4);
                $table->integer('aman92');
                $table->integer('mman92');
                $table->integer('gman92');
                $table->integer('aric92');
                $table->integer('mric92');
                $table->integer('gric92');
                $table->integer('mang92');
                $table->integer('manm92');
                $table->integer('mana92');
                $table->integer('gmat92');
                $table->integer('mmat92');
                $table->integer('amat92');
                $table->integer('gacc92');
                $table->integer('macc92');
                $table->integer('aacc92');
                $table->integer('aadu93');
                $table->integer('mmdu93');
                $table->integer('ggdu93');
                $table->integer('audu93');
                $table->integer('mudu93');
                $table->integer('gudu93');
                $table->integer('aard93');
                $table->integer('mard93');
                $table->integer('aaut93');
                $table->integer('mmut93');
                $table->integer('ggut93');
                $table->integer('aaar93');
                $table->integer('mmar93');
                $table->integer('aadu95');
                $table->integer('mmdu95');
                $table->integer('ggdu95');
                $table->integer('audu95');
                $table->integer('mudu95');
                $table->integer('gudu95');
                $table->integer('aard95');
                $table->integer('mard95');
                $table->integer('aaut95');
                $table->integer('mmut95');
                $table->integer('ggut95');
                $table->integer('aaar95');
                $table->integer('mmar95');
                $table->integer('aaut94');
                $table->integer('mmut94');
                $table->integer('ggut94');
                $table->integer('aaar94');
                $table->integer('mmar94');
                $table->integer('aatuti');
                $table->integer('mmtuti');
                $table->integer('ggtuti');
                $table->integer('aatarr');
                $table->integer('mmtarr');
                $table->integer('anztot');
                $table->decimal('cof92', 8, 5);
                $table->decimal('cof94', 8, 5);
                $table->decimal('cof95', 8, 5);
                $table->decimal('coftot', 8, 5);
                $table->integer('arroaa');
                $table->integer('arromm');
                $table->decimal('totcof', 8, 5);
                $table->integer('ar92aa');
                $table->integer('ar92mm');
                $table->decimal('cof92a', 8, 5);
                $table->integer('aarife');
                $table->integer('mmrife');
                $table->integer('mesiri');
                $table->decimal('difcof', 8, 5);
                $table->integer('rifeme');
                $table->integer('mang93');
                $table->integer('manm93');
                $table->integer('mana93');
                $table->integer('gman93');
                $table->integer('mman93');
                $table->integer('aman93');
                $table->integer('gmat93');
                $table->integer('mmat93');
                $table->integer('amat93');
                $table->integer('gacc93');
                $table->integer('macc93');
                $table->integer('aacc93');
                $table->integer('inizp');
                $table->integer('finep');
                $table->integer('pendec');
                $table->integer('pede93');
                $table->integer('giorif');
                $table->integer('giori2');
                $table->decimal('coeffe', 8, 5);
                $table->integer('tgirif');
                $table->integer('tgival');
                $table->integer('torriv');
                $table->integer('torcon');
                $table->integer('rmariv');
                $table->integer('rmacon');
                $table->integer('reet80');
                $table->integer('decpen');
                $table->integer('depe93');
                $table->integer('rp92');
                $table->decimal('cf92', 8, 5);
                $table->integer('pa92');
                $table->integer('rm93');
                $table->decimal('cf93', 8, 5);
                $table->integer('pm93');
                $table->integer('pa93');
                $table->integer('pa95');
                $table->integer('pa93a');
                $table->integer('rl336');
                $table->decimal('cfl336', 8, 5);
                $table->integer('pl336');
                $table->integer('pannc');
                $table->integer('aal537');
                $table->integer('ral537');
                $table->integer('pannl');
                $table->integer('pmenc');
                $table->integer('pmenl');
                $table->integer('pmenll');
                $table->integer('ssnmen');
                $table->integer('irpnet');
                $table->integer('pennet');
                $table->integer('irpimp');
                $table->integer('irplor');
                $table->integer('detfis');
                $table->integer('dvar1');
                $table->integer('rmaco2');
                $table->integer('impmax');
                $table->integer('aapedu');
                $table->integer('mmpedu');
                $table->integer('ggpedu');
                $table->integer('aapeut');
                $table->integer('mmpeut');
                $table->integer('ggpeut');
                $table->integer('aapear');
                $table->integer('mmpear');
                $table->integer('aariut');
                $table->integer('mmriut');
                $table->integer('ggriut');
                $table->integer('aariar');
                $table->integer('mmriar');
                $table->integer('aarcut');
                $table->integer('mmrcut');
                $table->integer('ggrcut');
                $table->integer('aarcar');
                $table->integer('mmrcar');
                $table->integer('rever');
                $table->integer('costan');
                $table->integer('panind');
                $table->integer('pannc2');
                $table->integer('pannc3');
                $table->integer('pannc4');
                $table->integer('risric');
                $table->integer('annri4');
                $table->integer('mesri4');
                $table->integer('giori4');
                $table->integer('annri2');
                $table->integer('mesri2');
                $table->integer('gma92');
                $table->integer('mma92');
                $table->integer('ama92');
                $table->integer('netpen');
                $table->integer('assfam');
                $table->char('retflg', 1);
                $table->integer('mes50i');
                $table->integer('mes50r');
                $table->integer('mes66i');
                $table->integer('mes66r');
                $table->char('tipo9', 1);
                $table->char('risarr', 1);
                $table->char('risa93', 1);
                $table->char('risa95', 1);
                $table->char('ridman', 1);
                $table->integer('riduzi');
                $table->integer('riduz2');
                $table->char('access', 1);
                $table->integer('gio50i');
                $table->integer('gio50r');
                $table->integer('gio66i');
                $table->integer('gio66r');
                $table->char('sino19', 1);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('acco4f');
    }
}
