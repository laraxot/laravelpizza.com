<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWgiu03fTable.
 */
class CreateWgiu03fTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->char('g3annu', 1)->index();
                $table->integer('enteap')->index();
                $table->integer('stdata')->index();
                $table->integer('g3matr')->index();
                $table->integer('lecod1');
                $table->integer('lecod2');
                $table->integer('g3qtaa');
                $table->decimal('g3qtav', 9);
                $table->decimal('g3orad', 6);
                $table->decimal('g3oraa', 6);
                $table->char('g3umis', 1);
                $table->integer('g3qtar');
                $table->char('g3flgs', 1);
                $table->char('g3flg1', 1);
                $table->char('g3com1', 10);
                $table->integer('g3com2');
                $table->integer('g3com3');
                $table->integer('g3com4');
                $table->integer('g3com5');
                $table->char('g3com6', 10);
                $table->integer('g3com7');
                $table->decimal('g3impe', 11);
                $table->char('g3unmi', 1);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wgiu03f');
    }
}
