<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCed03fTable.
 */
class CreateCed03fTable extends XotBaseMigration
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
                $table->integer('scont');
                $table->integer('smatr');
                $table->integer('smesli');
                $table->integer('sannli');
                $table->integer('sgiome');
                $table->integer('svocfi');
                $table->decimal('perrid', 7);
                $table->integer('totale');
                $table->decimal('impoeu', 13);
                $table->integer('totsav');
                $table->decimal('impseu', 13);
                $table->decimal('qtaore', 7);
                $table->integer('anno');
                $table->integer('mese');
                $table->integer('sruolo');
                $table->integer('impbil');
                $table->integer('clafun');
                $table->integer('flagcf');
                $table->integer('cedist');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ced03f');
    }
}
