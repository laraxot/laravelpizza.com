<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTurn04l1Table.
 */
class CreateTurn04l1Table extends XotBaseMigration
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
                $table->text('T4ANNU')->nullable();
                $table->text('ENTEAP')->nullable();
                $table->text('T4CODI')->nullable();
                $table->text('T4STOR')->nullable();
                $table->text('T4SEQU')->nullable();
                $table->text('T4RIPP')->nullable();
                $table->text('T4COM1')->nullable();
                $table->text('T4COM2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('turn04l1');
    }
}
