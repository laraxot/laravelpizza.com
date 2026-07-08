<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateDipt00l3Table.
 */
class CreateDipt00l3Table extends XotBaseMigration
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
                $table->text('dtannu')->nullable();
                $table->text('dtmatr')->nullable();
                $table->text('dtturn')->nullable();
                $table->text('dtdal')->nullable();
                $table->text('dtal')->nullable();
                $table->text('dtcom1')->nullable();
                $table->text('dtcom2')->nullable();
                $table->text('dtcom3')->nullable();
                $table->text('dtcom4')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('dipt00l3');
    }
}
