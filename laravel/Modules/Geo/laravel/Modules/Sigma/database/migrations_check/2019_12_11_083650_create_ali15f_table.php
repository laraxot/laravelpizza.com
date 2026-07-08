<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAli15fTable.
 */
class CreateAli15fTable extends XotBaseMigration
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
                $table->text('step')->nullable();
                $table->text('stepd')->nullable();
                $table->text('codra')->nullable();
                $table->text('codrad')->nullable();
                $table->text('ente')->nullable();
                $table->text('matr')->nullable();
                $table->text('conome')->nullable();
                $table->text('nome')->nullable();
                $table->text('datn1')->nullable();
                $table->text('sess1')->nullable();
                $table->text('codfis')->nullable();
                $table->text('dtass')->nullable();
                $table->text('dtast')->nullable();
                $table->text('asscau')->nullable();
                $table->text('numas')->nullable();
                $table->text('dtces')->nullable();
                $table->text('dtcet')->nullable();
                $table->text('dimcau')->nullable();
                $table->text('numce')->nullable();
                $table->text('xdcont')->nullable();
                $table->text('xdtipc')->nullable();
                $table->text('xdrapp')->nullable();
                $table->text('xdruol')->nullable();
                $table->text('xdpro')->nullable();
                $table->text('xdpos')->nullable();
                $table->text('xdcoq')->nullable();
                $table->text('xdcat')->nullable();
                $table->text('xdfas')->nullable();
                $table->text('xdore')->nullable();
                $table->text('xdort')->nullable();
                $table->text('xdpsz')->nullable();
                $table->text('xdstem')->nullable();
                $table->text('xapdes')->nullable();
                $table->text('xespr')->nullable();
                $table->text('xflag')->nullable();
                $table->text('xdes1')->nullable();
                $table->text('xdes2')->nullable();
                $table->text('xdes3')->nullable();
                $table->text('arec')->nullable();
                $table->text('idcam')->nullable();
                $table->text('idcamd')->nullable();
                $table->text('idlib3')->nullable();
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
        Schema::drop('ali15f');
    }
}
