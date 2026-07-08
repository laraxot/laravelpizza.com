<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTurn02l1Table.
 */
class CreateTurn02l1Table extends XotBaseMigration
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
                $table->text('T2ANNU')->nullable();
                $table->text('ENTEAP')->nullable();
                $table->text('T2CODI')->nullable();
                $table->text('T2STOR')->nullable();
                $table->text('T2SEQU')->nullable();
                $table->text('T2RIPP')->nullable();
                $table->text('T2COM1')->nullable();
                $table->text('T2COM2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('turn02l1');
    }
}
