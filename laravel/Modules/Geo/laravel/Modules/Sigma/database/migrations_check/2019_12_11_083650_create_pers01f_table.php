<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreatePers01fTable.
 */
class CreatePers01fTable extends XotBaseMigration
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
                $table->text('enteap')->nullable();
                $table->text('pepgm')->nullable();
                $table->text('periga')->nullable();
                $table->text('peprov')->nullable();
                $table->text('pepers')->nullable();
                $table->text('pedal')->nullable();
                $table->text('peal')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('pers01f');
    }
}
