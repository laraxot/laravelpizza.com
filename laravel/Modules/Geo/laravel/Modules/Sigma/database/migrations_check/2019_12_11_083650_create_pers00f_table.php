<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreatePers00fTable.
 */
class CreatePers00fTable extends XotBaseMigration
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
                $table->text('ENTEAP')->nullable();
                $table->text('PEPGM')->nullable();
                $table->text('PERIGA')->nullable();
                $table->text('PEPROV')->nullable();
                $table->text('PEPERS')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('pers00f');
    }
}
