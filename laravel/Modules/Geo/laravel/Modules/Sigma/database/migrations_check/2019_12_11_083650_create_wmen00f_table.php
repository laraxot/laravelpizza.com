<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWmen00fTable.
 */
class CreateWmen00fTable extends XotBaseMigration
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
                $table->integer('enteap');
                $table->char('mnannu', 1);
                $table->integer('mnbadg');
                $table->integer('mnmatr');
                $table->char('mncogn', 25);
                $table->char('mnnome', 25);
                $table->integer('mncaus');
                $table->integer('mnp1');
                $table->integer('mnp2');
                $table->integer('mnp3');
                $table->integer('mnp4');
                $table->integer('mndata');
                $table->integer('mnorat');
                $table->char('mnflg1', 1);
                $table->char('mnflg2', 1);
                $table->integer('mnflg3');
                $table->char('mnflg4', 1);
                $table->integer('mntmen');
                $table->char('mncom2', 10);
                $table->integer('mncom3');
                $table->char('ixterm', 5);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wmen00f');
    }
}
