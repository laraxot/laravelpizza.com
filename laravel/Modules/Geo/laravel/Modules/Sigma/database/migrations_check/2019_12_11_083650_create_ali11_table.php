<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAli11Table.
 */
class CreateAli11Table extends XotBaseMigration
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
                $table->text('datn1')->nullable();
                $table->text('sess1')->nullable();
                $table->text('idcont')->nullable();
                $table->text('idtipc')->nullable();
                $table->text('idrapp')->nullable();
                $table->text('idruol')->nullable();
                $table->text('idpro')->nullable();
                $table->text('idpos')->nullable();
                $table->text('idcoq')->nullable();
                $table->text('idcat')->nullable();
                $table->text('idfas')->nullable();
                $table->text('idore')->nullable();
                $table->text('idort')->nullable();
                $table->text('idpsz')->nullable();
                $table->text('rapdes')->nullable();
                $table->text('despr')->nullable();
                $table->text('desco')->nullable();
                $table->text('desdi')->nullable();
                $table->text('area')->nullable();
                $table->text('stab')->nullable();
                $table->text('repa')->nullable();
                $table->text('desar')->nullable();
                $table->text('desst')->nullable();
                $table->text('desse')->nullable();
                $table->text('idcam')->nullable();
                $table->text('idctd')->nullable();
                $table->text('idcre')->nullable();
                $table->text('dtass')->nullable();
                $table->text('dtasu')->nullable();
                $table->text('dtast')->nullable();
                $table->text('asscau')->nullable();
                $table->text('dtasn')->nullable();
                $table->text('dtdec')->nullable();
                $table->text('dtces')->nullable();
                $table->text('dtcet')->nullable();
                $table->text('dimcau')->nullable();
                $table->text('codra')->nullable();
                $table->text('codrad')->nullable();
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
        Schema::drop('ali11');
    }
}
