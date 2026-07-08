<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTqu00fTable.
 */
class CreateTqu00fTable extends XotBaseMigration
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
                $table->integer('cont')->nullable()->index('cont');
                $table->integer('tipco')->nullable()->index('tipco');
                $table->integer('rapp')->nullable()->index('rapp');
                $table->integer('ruolo')->nullable()->index('ruolo');
                $table->integer('propro')->nullable()->index('propro');
                $table->integer('posfun')->nullable()->index();
                $table->integer('codqua')->nullable();
                $table->integer('codinq')->nullable();
                $table->string('desc1', 40)->nullable();
                $table->string('desc2', 40)->nullable();
                $table->string('liv', 2)->nullable();
                $table->string('tqann', 1)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('tqu00f');
    }
}
