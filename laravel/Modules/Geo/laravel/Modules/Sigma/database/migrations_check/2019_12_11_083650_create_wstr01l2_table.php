<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWstr01l2Table.
 */
class CreateWstr01l2Table extends XotBaseMigration
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
                $table->text('wtannu')->nullable();
                $table->text('wtsens')->nullable();
                $table->text('wtindi')->nullable();
                $table->text('wtbadg')->nullable();
                $table->text('wtdata')->nullable();
                $table->text('wtteor')->nullable();
                $table->text('wtorat')->nullable();
                $table->text('wxorat')->nullable();
                $table->text('wyorat')->nullable();
                $table->text('t1codi')->nullable();
                $table->text('orcodi')->nullable();
                $table->text('wtmatr')->nullable();
                $table->text('wtcaus')->nullable();
                $table->text('wtflg1')->nullable();
                $table->text('wtflg2')->nullable();
                $table->text('wtcomp')->nullable();
                $table->text('wtcom1')->nullable();
                $table->text('wtcom2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wstr01l2');
    }
}
