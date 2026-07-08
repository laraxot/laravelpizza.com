<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateDipb00l1Table.
 */
class CreateDipb00l1Table extends XotBaseMigration
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
                $table->integer('enteap')->nullable()->index('enteap');
                $table->string('dbannu', 1)->nullable();
                $table->integer('dbmatr')->nullable()->index('dbmatr');
                $table->integer('dbbadg')->nullable();
                $table->integer('dbdal')->nullable();
                $table->integer('dbal')->nullable();
                $table->string('dbcom1', 1)->nullable();
                $table->string('dbcom2', 10)->nullable();
                $table->integer('dbcom3')->nullable();
                $table->integer('dbcom4')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('dipb00l1');
    }
}
