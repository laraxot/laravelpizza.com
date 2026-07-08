<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateDipb00l2Table.
 */
class CreateDipb00l2Table extends XotBaseMigration
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
                $table->text('enteap')->nullable();
                $table->text('dbannu')->nullable();
                $table->text('dbmatr')->nullable();
                $table->text('dbbadg')->nullable();
                $table->text('dbdal')->nullable();
                $table->text('dbal')->nullable();
                $table->text('dbcom1')->nullable();
                $table->text('dbcom2')->nullable();
                $table->text('dbcom3')->nullable();
                $table->text('dbcom4')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('dipb00l2');
    }
}
