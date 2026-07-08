<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCertificazioniTable.
 */
class CreateCertificazioniTable extends XotBaseMigration
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
                $table->text('codicefor')->nullable();
                $table->text('nominativo')->nullable();
                $table->text('data_di_nascita')->nullable();
                $table->text('field1')->nullable();
                $table->text('f1')->nullable();
                $table->text('codice_fiscale')->nullable();
                $table->text('partita_iva')->nullable();
                $table->text('via')->nullable();
                $table->text('cap')->nullable();
                $table->text('comune')->nullable();
                $table->text('impfatt')->nullable();
                $table->text('imponibile')->nullable();
                $table->text('somme_non_soggette')->nullable();
                $table->text('ritenute_fatt')->nullable();
                $table->text('ritliquid')->nullable();
                $table->text('ritmandato')->nullable();
                $table->text('tipo_documento')->nullable();
                $table->text('anno')->nullable();
                $table->text('mese')->nullable();
                $table->text('n_mand')->nullable();
                $table->text('atto')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('certificazioni');
    }
}
