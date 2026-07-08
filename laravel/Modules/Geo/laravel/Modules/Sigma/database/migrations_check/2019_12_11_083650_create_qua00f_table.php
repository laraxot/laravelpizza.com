<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua00fTable.
 */
class CreateQua00fTable extends XotBaseMigration
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
                $table->integer('ente')->index();
                $table->integer('cont');
                $table->integer('matr')->index();
                $table->integer('tipco');
                $table->integer('rapp');
                $table->integer('ruolo');
                $table->integer('propro');
                $table->integer('posfun');
                $table->integer('codqua');
                $table->integer('qudal');
                $table->integer('qual');
                $table->integer('quanz');
                $table->integer('posiz');
                $table->integer('sipco');
                $table->integer('sapp');
                $table->integer('suolo');
                $table->integer('sropro');
                $table->integer('sosfun');
                $table->integer('sodqua');
                $table->integer('annise');
                $table->integer('prvtip');
                $table->integer('prvdat');
                $table->char('prvnum', 20);
                $table->integer('datpas');
                $table->char('serviz', 1);
                $table->integer('disci1');
                $table->integer('disci2');
                $table->decimal('oree', 7);
                $table->decimal('oret', 7);
                $table->integer('aapens');
                $table->char('quaann', 1)->index();
                $table->integer('qua2kd')->index();
                $table->integer('qua2ka')->index();
                $table->integer('qua2kz');
                $table->integer('prv2kd');
                $table->integer('dat2kp');
                $table->integer('qua001');
                $table->char('qua002', 1);
                $table->char('qua003', 15);
                $table->integer('qua004');
                $table->integer('qua005');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua00f');
    }
}
