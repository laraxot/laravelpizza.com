<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateLturn1l1Table.
 */
class CreateLturn1l1Table extends XotBaseMigration
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
                $table->string('t1annu', 1)->nullable();
                $table->integer('enteap')->nullable()->index('enteap');
                $table->string('t1codi', 3)->nullable();
                $table->integer('t1dal')->nullable();
                $table->integer('t1al')->nullable();
                $table->integer('t1stor')->nullable();
                $table->string('t1desc', 30)->nullable();
                $table->integer('t1modu')->nullable();
                $table->string('t1fest', 1)->nullable();
                $table->string('t1manu', 1)->nullable();
                $table->integer('t1orar')->nullable();
                $table->integer('t1turn')->nullable();
                $table->integer('t1sogl')->nullable();
                $table->integer('t1sogd')->nullable();
                $table->string('t1chiu', 1)->nullable();
                $table->string('t1moda', 1)->nullable();
                $table->string('t1modp', 1)->nullable();
                $table->string('t1quad', 3)->nullable();
                $table->string('t1pers', 1)->nullable();
                $table->string('t1svil', 1)->nullable();
                $table->string('t1teef', 1)->nullable();
                $table->string('t1aste', 1)->nullable();
                $table->string('t1gipe', 1)->nullable();
                $table->string('t1corr', 1)->nullable();
                $table->string('t1rife', 3)->nullable();
                $table->string('t1rico', 1)->nullable();
                $table->string('t1cofe', 1)->nullable();
                $table->string('t1ripp', 56)->nullable();
                $table->string('t1com1', 1)->nullable();
                $table->string('t1com2', 10)->nullable();
                $table->string('t1com3', 15)->nullable();
                $table->integer('t1com4')->nullable();
                $table->integer('t1com5')->nullable();
                $table->integer('t1com6')->nullable();
                $table->integer('t1com7')->nullable();
                $table->string('tjob', 6)->nullable();
                $table->string('utente', 10)->nullable();
                $table->integer('fldate')->nullable();
                $table->integer('fltime')->nullable();
                $table->string('fltipo', 1)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('lturn1l1');
    }
}
