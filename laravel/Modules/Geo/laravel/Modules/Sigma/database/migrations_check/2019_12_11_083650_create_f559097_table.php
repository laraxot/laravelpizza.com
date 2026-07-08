<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateF559097Table.
 */
class CreateF559097Table extends XotBaseMigration
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
                $table->text('mat')->nullable();
                $table->text('cognome')->nullable();
                $table->text('nome')->nullable();
                $table->text('contratto')->nullable();
                $table->text('voce')->nullable();
                $table->text('field')->nullable();
                $table->text('importo')->nullable();
                $table->text('anno_liquidazione')->nullable();
                $table->text('mese_liq')->nullable();
                $table->text('anno_riferimento')->nullable();
                $table->text('mese_riferimento')->nullable();
                $table->text('field1')->nullable();
                $table->text('field11')->nullable();
                $table->text('field111')->nullable();
                $table->text('field1111')->nullable();
                $table->text('field11111')->nullable();
                $table->text('field111111')->nullable();
                $table->text('stabilimento')->nullable();
                $table->text('field1111111')->nullable();
                $table->text('reparto')->nullable();
                $table->text('field11111111')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('f559097');
    }
}
