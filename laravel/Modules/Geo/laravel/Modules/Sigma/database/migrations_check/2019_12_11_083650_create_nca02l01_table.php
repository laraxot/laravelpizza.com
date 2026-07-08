<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateNca02l01Table.
 */
class CreateNca02l01Table extends XotBaseMigration
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
                $table->text('matr')->nullable();
                $table->text('paymon')->nullable();
                $table->text('payann')->nullable();
                $table->text('anno')->nullable();
                $table->text('scont')->nullable();
                $table->text('svocfi')->nullable();
                $table->text('impbil')->nullable();
                $table->text('tipret')->nullable();
                $table->text('codist')->nullable();
                $table->text('totc1')->nullable();
                $table->text('totc2')->nullable();
                $table->text('totc3')->nullable();
                $table->text('totc4')->nullable();
                $table->text('totc5')->nullable();
                $table->text('cla')->nullable();
                $table->text('sta')->nullable();
                $table->text('rep')->nullable();
                $table->text('ruo')->nullable();
                $table->text('pro')->nullable();
                $table->text('pos')->nullable();
                $table->text('liv')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('nca02l01');
    }
}
