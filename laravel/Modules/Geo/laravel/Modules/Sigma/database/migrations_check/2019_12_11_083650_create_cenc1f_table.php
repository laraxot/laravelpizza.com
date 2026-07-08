<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCenc1fTable.
 */
class CreateCenc1fTable extends XotBaseMigration
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
                $table->text('cdccod')->nullable();
                $table->text('cdcdal')->nullable();
                $table->text('cdcal')->nullable();
                $table->text('cdcdec')->nullable();
                $table->text('cdcdel')->nullable();
                $table->text('cdcas1')->nullable();
                $table->text('cdcas2')->nullable();
                $table->text('cdcas3')->nullable();
                $table->text('cdcas4')->nullable();
                $table->text('cdc001')->nullable();
                $table->text('cdc002')->nullable();
                $table->text('cdc003')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('cenc1f');
    }
}
