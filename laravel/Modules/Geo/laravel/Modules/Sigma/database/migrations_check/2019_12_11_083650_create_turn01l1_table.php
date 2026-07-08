<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTurn01l1Table.
 */
class CreateTurn01l1Table extends XotBaseMigration
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
                $table->char('t1annu', 1);
                $table->integer('enteap');
                $table->char('t1codi', 3);
                $table->integer('t1dal');
                $table->integer('t1al');
                $table->integer('t1stor');
                $table->char('t1desc', 30);
                $table->integer('t1modu');
                $table->char('t1fest', 1);
                $table->char('t1manu', 1);
                $table->integer('t1orar');
                $table->integer('t1turn');
                $table->integer('t1sogl');
                $table->integer('t1sogd');
                $table->char('t1chiu', 1);
                $table->char('t1moda', 1);
                $table->char('t1modp', 1);
                $table->char('t1quad', 3);
                $table->char('t1pers', 1);
                $table->char('t1svil', 1);
                $table->char('t1teef', 1);
                $table->char('t1aste', 1);
                $table->char('t1gipe', 1);
                $table->char('t1corr', 1);
                $table->char('t1rife', 3);
                $table->char('t1rico', 1);
                $table->char('t1cofe', 1);
                $table->char('t1ripp', 56);
                $table->char('t1com1', 1);
                $table->char('t1com2', 10);
                $table->char('t1com3', 15);
                $table->integer('t1com4');
                $table->integer('t1com5');
                $table->integer('t1com6');
                $table->integer('t1com7');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('turn01l1');
    }
}
