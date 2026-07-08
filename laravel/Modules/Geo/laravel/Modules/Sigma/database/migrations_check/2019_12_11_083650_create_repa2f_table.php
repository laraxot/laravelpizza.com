<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRepa2fTable.
 */
class CreateRepa2fTable extends XotBaseMigration
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
                $table->text('stabi')->nullable();
                $table->text('repar')->nullable();
                $table->text('liv1')->nullable();
                $table->text('liv2')->nullable();
                $table->text('liv3')->nullable();
                $table->text('liv4')->nullable();
                $table->text('liv5')->nullable();
                $table->text('liv6')->nullable();
                $table->text('liv7')->nullable();
                $table->text('liv8')->nullable();
                $table->text('liv9')->nullable();
                $table->text('liv10')->nullable();
                $table->text('liv11')->nullable();
                $table->text('coirap')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('repa2f');
    }
}
