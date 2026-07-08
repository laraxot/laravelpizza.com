<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateLturn2l1Table.
 */
class CreateLturn2l1Table extends XotBaseMigration
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
                $table->string('t2annu', 1)->nullable();
                $table->integer('enteap')->nullable()->index('enteap');
                $table->string('t2codi', 3)->nullable();
                $table->integer('t2stor')->nullable()->index('t2stor');
                $table->integer('t2sequ')->nullable()->index('t2sequ');
                $table->string('t2ripp', 28)->nullable();
                $table->string('t2com1', 3)->nullable();
                $table->string('t2com2', 3)->nullable();
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
        Schema::drop('lturn2l1');
    }
}
