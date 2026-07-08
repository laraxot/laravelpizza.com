<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua00k2Table.
 */
class CreateQua00k2Table extends XotBaseMigration
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
                $table->integer('ente')->nullable()->index('ente');
                $table->integer('cont')->nullable()->index('cont');
                $table->integer('matr')->nullable()->index('matr');
                $table->integer('tipco')->nullable()->index('tipco');
                $table->integer('rapp')->nullable()->index('rapp');
                $table->integer('ruolo')->nullable();
                $table->integer('propro')->nullable();
                $table->integer('posfun')->nullable();
                $table->integer('codqua')->nullable();
                $table->integer('qudal')->nullable();
                $table->integer('qual')->nullable();
                $table->integer('quanz')->nullable();
                $table->integer('posiz')->nullable();
                $table->integer('sipco')->nullable();
                $table->integer('sapp')->nullable();
                $table->integer('suolo')->nullable();
                $table->integer('sropro')->nullable();
                $table->integer('sosfun')->nullable();
                $table->integer('sodqua')->nullable();
                $table->integer('annise')->nullable();
                $table->integer('prvtip')->nullable();
                $table->integer('prvdat')->nullable();
                $table->string('prvnum', 20)->nullable();
                $table->integer('datpas')->nullable();
                $table->string('serviz', 1)->nullable();
                $table->integer('disci1')->nullable();
                $table->integer('disci2')->nullable();
                $table->decimal('oree', 7)->nullable();
                $table->decimal('oret', 7)->nullable();
                $table->integer('aapens')->nullable();
                $table->string('quaann', 1)->nullable();
                $table->integer('qua2kd')->nullable();
                $table->integer('qua2ka')->nullable();
                $table->integer('qua2kz')->nullable();
                $table->integer('prv2kd')->nullable();
                $table->integer('dat2kp')->nullable();
                $table->integer('qua001')->nullable();
                $table->string('qua002', 1)->nullable();
                $table->string('qua003', 15)->nullable();
                $table->integer('qua004')->nullable();
                $table->integer('qua005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua00k2');
    }
}
