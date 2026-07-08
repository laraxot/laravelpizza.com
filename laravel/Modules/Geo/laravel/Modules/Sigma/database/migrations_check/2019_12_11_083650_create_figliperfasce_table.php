<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateFigliperfasceTable.
 */
class CreateFigliperfasceTable extends XotBaseMigration
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
                $table->text('ente')->nullable();
                $table->text('matr')->nullable();
                $table->text('data_dal_anno_mese')->nullable();
                $table->text('data_al_anno_mese')->nullable();
                $table->text('cognome')->nullable();
                $table->text('nome')->nullable();
                $table->text('data_di_nascita')->nullable();
                $table->text('codice_fiscale')->nullable();
                $table->text('irpper')->nullable();
                $table->text('irpinv')->nullable();
                $table->text('irptip')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('figliperfasce');
    }
}
