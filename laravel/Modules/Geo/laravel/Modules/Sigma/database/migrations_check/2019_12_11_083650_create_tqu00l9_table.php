<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTqu00l9Table.
 */
class CreateTqu00l9Table extends XotBaseMigration
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
                $table->string('cont', 100)->nullable();
                $table->string('tipco', 100)->nullable();
                $table->string('rapp', 100)->nullable();
                $table->string('ruolo', 100)->nullable();
                $table->string('propro', 100)->nullable();
                $table->string('posfun', 100)->nullable();
                $table->string('codqua', 100)->nullable();
                $table->string('codinq', 100)->nullable();
                $table->string('desc1', 250)->nullable();
                $table->string('desc2', 250)->nullable();
                $table->string('liv', 100)->nullable();
                $table->string('tqann', 100)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('tqu00l9');
    }
}
