<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWstr01lxTable.
 */
class CreateWstr01lxTable extends XotBaseMigration
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
                $table->integer('enteap')->index();
                $table->char('wtannu', 1)->index();
                $table->integer('wtsens');
                $table->integer('wtindi');
                $table->integer('wtbadg');
                $table->integer('wtdata')->index();
                $table->integer('wtteor');
                $table->integer('wtorat')->index();
                $table->integer('wxorat');
                $table->integer('wyorat');
                $table->char('t1codi', 3);
                $table->char('orcodi', 3);
                $table->integer('wtmatr')->index();
                $table->integer('wtcaus');
                $table->char('wtflg1', 1);
                $table->char('wtflg2', 1);
                $table->integer('wtcomp');
                $table->char('wtcom1', 10);
                $table->integer('wtcom2');
                $table->char('ixterm', 5);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wstr01lx');
    }
}
