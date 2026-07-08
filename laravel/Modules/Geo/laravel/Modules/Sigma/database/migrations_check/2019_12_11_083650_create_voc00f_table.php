<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateVoc00fTable.
 */
class CreateVoc00fTable extends XotBaseMigration
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
                $table->integer('cont')->nullable();
                $table->integer('vocret')->nullable();
                $table->integer('tipret')->nullable();
                $table->text('desret')->nullable();
                $table->integer('progre')->nullable();
                $table->integer('tipcal')->nullable();
                $table->integer('codcal')->nullable();
                $table->integer('codasc')->nullable();
                $table->integer('impbil')->nullable();
                $table->index(['cont', 'vocret'], 'cont_vocret');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('voc00f');
    }
}
