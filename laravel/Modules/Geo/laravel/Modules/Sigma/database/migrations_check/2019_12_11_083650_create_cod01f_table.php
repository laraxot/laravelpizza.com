<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCod01fTable.
 */
class CreateCod01fTable extends XotBaseMigration
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
                $table->text('TIPO')->nullable();
                $table->text('CODICE')->nullable();
                $table->text('CODREG')->nullable();
                $table->text('CODIC1')->nullable();
                $table->text('CODIC2')->nullable();
                $table->text('CODIC3')->nullable();
                $table->text('CODIC4')->nullable();
                $table->text('CODIC5')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('cod01f');
    }
}
