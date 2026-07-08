<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateExwr00l6Table.
 */
class CreateExwr00l6Table extends XotBaseMigration
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
                $table->text('etannu')->nullable();
                $table->text('etsens')->nullable();
                $table->text('etindi')->nullable();
                $table->text('etbadg')->nullable();
                $table->text('etdata')->nullable();
                $table->text('etorat')->nullable();
                $table->text('ezorat')->nullable();
                $table->text('etmatr')->nullable();
                $table->text('etcaus')->nullable();
                $table->text('etcau1')->nullable();
                $table->text('etcomp')->nullable();
                $table->text('etteor')->nullable();
                $table->text('etcom1')->nullable();
                $table->text('etcom2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('exwr00l6');
    }
}
