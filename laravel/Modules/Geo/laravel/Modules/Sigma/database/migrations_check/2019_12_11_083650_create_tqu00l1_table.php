<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTqu00l1Table.
 */
class CreateTqu00l1Table extends XotBaseMigration
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
                $table->text('cont')->nullable();
                $table->text('tipco')->nullable();
                $table->text('rapp')->nullable();
                $table->text('ruolo')->nullable();
                $table->text('propro')->nullable();
                $table->text('posfun')->nullable();
                $table->text('codqua')->nullable();
                $table->text('codinq')->nullable();
                $table->text('desc1')->nullable();
                $table->text('desc2')->nullable();
                $table->text('liv')->nullable();
                $table->text('tqann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('tqu00l1');
    }
}
