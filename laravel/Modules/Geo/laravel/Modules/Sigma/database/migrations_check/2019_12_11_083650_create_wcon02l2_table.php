<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWcon02l2Table.
 */
class CreateWcon02l2Table extends XotBaseMigration
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
                $table->text('w2oann')->nullable();
                $table->text('w2omat')->nullable();
                $table->text('w2ddat')->nullable();
                $table->text('w2ogiu')->nullable();
                $table->text('w2olet')->nullable();
                $table->text('w2oora')->nullable();
                $table->text('w2oass')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wcon02l2');
    }
}
