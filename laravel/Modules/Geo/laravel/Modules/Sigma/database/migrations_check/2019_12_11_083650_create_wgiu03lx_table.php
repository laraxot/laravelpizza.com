<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWgiu03lxTable.
 */
class CreateWgiu03lxTable extends XotBaseMigration
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
                $table->string('g3annu', 1)->nullable();
                $table->integer('enteap')->nullable()->index('enteap');
                $table->integer('stdata')->nullable();
                $table->integer('g3matr')->nullable()->index('g3matr');
                $table->integer('lecod1')->nullable()->index('lecod1');
                $table->integer('lecod2')->nullable();
                $table->integer('g3qtaa')->nullable();
                $table->decimal('g3qtav', 9)->nullable();
                $table->decimal('g3orad', 6)->nullable();
                $table->decimal('g3oraa', 6)->nullable();
                $table->string('g3umis', 1)->nullable();
                $table->integer('g3qtar')->nullable();
                $table->string('g3flgs', 1)->nullable();
                $table->string('g3flg1', 1)->nullable();
                $table->string('g3com1', 10)->nullable();
                $table->integer('g3com2')->nullable();
                $table->integer('g3com3')->nullable();
                $table->integer('g3com4')->nullable();
                $table->integer('g3com5')->nullable();
                $table->string('g3com6', 10)->nullable();
                $table->integer('g3com7')->nullable();
                $table->decimal('g3impe', 11)->nullable();
                $table->string('g3unmi', 1)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wgiu03lx');
    }
}
