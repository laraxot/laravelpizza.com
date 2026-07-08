<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCoco1baseTable.
 */
class CreateCoco1baseTable extends XotBaseMigration
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
                $table->text('contratto')->nullable();
                $table->text('matricola')->nullable();
                $table->text('mese_da_liquidare')->nullable();
                $table->text('anno_da_liquidare')->nullable();
                $table->text('numero_giorni_mese_da_liq')->nullable();
                $table->text('voce_retributiva')->nullable();
                $table->text('_riduzione_per_aspettativa')->nullable();
                $table->text('totale_voce')->nullable();
                $table->text('totale_voce_in_euro')->nullable();
                $table->text('totale_voce_salvato')->nullable();
                $table->text('totale_voce_salvato_in_euro')->nullable();
                $table->text('totale_ore_straord')->nullable();
                $table->text('anno_di_appartenenza')->nullable();
                $table->text('mese_di_appartenenza')->nullable();
                $table->text('ruolo')->nullable();
                $table->text('imputazione_bilancio')->nullable();
                $table->text('clas_funz_dip')->nullable();
                $table->text('flag_inq_clafun')->nullable();
                $table->text('codice_istituto_tab_14')->nullable();
                $table->text('base_2__aggiuntivi')->nullable();
                $table->text('field21')->nullable();
                $table->text('field22')->nullable();
                $table->text('cognome')->nullable();
                $table->text('nome')->nullable();
                $table->text('sesso')->nullable();
                $table->text('stato_civile')->nullable();
                $table->text('classificazione_funzionale')->nullable();
                $table->text('titolo_di_studio')->nullable();
                $table->text('ente_di_provenienza')->nullable();
                $table->text('sindacato')->nullable();
                $table->text('categoria_speciale')->nullable();
                $table->text('titolo_professionale')->nullable();
                $table->text('field33')->nullable();
                $table->text('stabilimento')->nullable();
                $table->text('reparto')->nullable();
                $table->text('banca_per_accredito_stipend')->nullable();
                $table->text('agenzia')->nullable();
                $table->text('numero_conto_corrente')->nullable();
                $table->text('codice_inail')->nullable();
                $table->text('flag_servizio_')->nullable();
                $table->text('data_assunzione')->nullable();
                $table->text('data_dimissione')->nullable();
                $table->text('tipo_assunzione')->nullable();
                $table->text('tipo_dimissione')->nullable();
                $table->text('data_dal')->nullable();
                $table->text('data_al')->nullable();
                $table->text('stabpianta_organica')->nullable();
                $table->text('reppianta_organica')->nullable();
                $table->text('stabposto_lavoro')->nullable();
                $table->text('repposto_lavoro')->nullable();
                $table->text('tipo_pianta_organica')->nullable();
                $table->text('data_partenza_qualifica')->nullable();
                $table->text('data_fine_qualifica')->nullable();
                $table->text('data_anzian_convenzionale')->nullable();
                $table->text('nanni_qual_second')->nullable();
                $table->text('posizione')->nullable();
                $table->text('data_passaggio_in_ruolo')->nullable();
                $table->text('ore_lavorate')->nullable();
                $table->text('ore_teoriche')->nullable();
                $table->text('field60')->nullable();
                $table->text('tipo_contribuzione')->nullable();
                $table->text('rapporto_lavoro')->nullable();
                $table->text('field63')->nullable();
                $table->text('profilo_professionale')->nullable();
                $table->text('posizione__funzionale')->nullable();
                $table->text('codice_qualifica')->nullable();
                $table->text('disciplina_qualif_primaria')->nullable();
                $table->text('qual_secondaria')->nullable();
                $table->text('field69')->nullable();
                $table->text('field70')->nullable();
                $table->text('field71')->nullable();
                $table->text('field72')->nullable();
                $table->text('field73')->nullable();
                $table->text('disciplina_qulif_secondaria')->nullable();
                $table->text('tipo_aspettativa')->nullable();
                $table->text('data_inizio')->nullable();
                $table->text('data_fine')->nullable();
                $table->text('flag_di_annullamento')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('coco1base');
    }
}
