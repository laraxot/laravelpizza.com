<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAddc1fTable.
 */
class CreateAddc1fTable extends XotBaseMigration
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
                $table->text('addist')->nullable();
                $table->text('addper')->nullable();
                $table->text('adddal')->nullable();
                $table->text('addal')->nullable();
                $table->text('addim1')->nullable();
                $table->text('addim2')->nullable();
                $table->text('addim3')->nullable();
                $table->text('addfra')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('addc1f');
    }
}
