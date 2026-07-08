<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWgiu04fTable.
 */
class CreateWgiu04fTable extends XotBaseMigration
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
                $table->string('g4annu', 1)->nullable();
                $table->integer('enteap')->nullable()->index('enteap');
                $table->integer('g4matr')->nullable()->index('g4matr');
                $table->integer('g4aamm')->nullable()->index('g4aamm');
                $table->integer('g4sequ')->nullable()->index('g4sequ');
                $table->integer('g4cod1')->nullable();
                $table->integer('g4cod2')->nullable();
                $table->integer('g4qtaa')->nullable();
                $table->integer('g4qtar')->nullable();
                $table->integer('g4com3')->nullable();
                $table->integer('g4com4')->nullable();
                $table->integer('g4com5')->nullable();
                $table->string('g4com6', 10)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wgiu04f');
    }
}
