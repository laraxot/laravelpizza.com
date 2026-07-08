<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua00l1Table.
 */
class CreateQua00l1Table extends XotBaseMigration
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
                $table->text('cont')->nullable();
                $table->text('matr')->nullable();
                $table->text('tipco')->nullable();
                $table->text('rapp')->nullable();
                $table->text('ruolo')->nullable();
                $table->text('propro')->nullable();
                $table->text('posfun')->nullable();
                $table->text('codqua')->nullable();
                $table->text('qudal')->nullable();
                $table->text('qual')->nullable();
                $table->text('quanz')->nullable();
                $table->text('posiz')->nullable();
                $table->text('sipco')->nullable();
                $table->text('sapp')->nullable();
                $table->text('suolo')->nullable();
                $table->text('sropro')->nullable();
                $table->text('sosfun')->nullable();
                $table->text('sodqua')->nullable();
                $table->text('annise')->nullable();
                $table->text('prvtip')->nullable();
                $table->text('prvdat')->nullable();
                $table->text('prvnum')->nullable();
                $table->text('datpas')->nullable();
                $table->text('serviz')->nullable();
                $table->text('disci1')->nullable();
                $table->text('disci2')->nullable();
                $table->text('oree')->nullable();
                $table->text('oret')->nullable();
                $table->text('aapens')->nullable();
                $table->text('quaann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua00l1');
    }
}
