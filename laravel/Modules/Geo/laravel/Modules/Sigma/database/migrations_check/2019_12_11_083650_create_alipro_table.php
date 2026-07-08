<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAliproTable.
 */
class CreateAliproTable extends XotBaseMigration
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
                $table->text('cognome')->nullable();
                $table->text('nome')->nullable();
                $table->text('ente')->nullable();
                $table->string('matricola', 250)->nullable();
                $table->text('data_nascita')->nullable();
                $table->text('comune_nascita')->nullable();
                $table->text('codice_fiscale')->nullable();
                $table->text('sesso')->nullable();
                $table->text('comune_residenza')->nullable();
                $table->text('provincia')->nullable();
                $table->text('localita')->nullable();
                $table->text('toponomastica')->nullable();
                $table->text('indirizzo')->nullable();
                $table->text('cap')->nullable();
                $table->text('data_assunzione')->nullable();
                $table->text('data_cessazione')->nullable();
                $table->text('part_time_eff')->nullable();
                $table->text('part_time_teor')->nullable();
                $table->text('cod_stabilimento')->nullable();
                $table->text('des_stabilimento')->nullable();
                $table->text('cod_reparto')->nullable();
                $table->text('des_reparto')->nullable();
                $table->text('contratto')->nullable();
                $table->text('rapporto_lavoro')->nullable();
                $table->text('ruolo')->nullable();
                $table->text('profilo_professionale')->nullable();
                $table->text('pos_funzionale')->nullable();
                $table->text('mansione')->nullable();
                $table->text('disciplina')->nullable();
                $table->text('des_profilo')->nullable();
                $table->text('des_disciplina')->nullable();
                $table->text('des_qualifica_1')->nullable();
                $table->text('des_qualifica_2')->nullable();
                $table->text('liv_categoria')->nullable();
                $table->text('fascia')->nullable();
                $table->text('pos_giuridica')->nullable();
                $table->text('des_pos_giuridica')->nullable();
                $table->text('cod_cc_a_n1')->nullable();
                $table->text('des_cc_a_n1')->nullable();
                $table->text('cod_cc_b_n1')->nullable();
                $table->text('des_cc_b_n1')->nullable();
                $table->text('cod_cc_c_n1')->nullable();
                $table->text('des_cc_c_n1')->nullable();
                $table->text('percentuale_cc_n1')->nullable();
                $table->text('cod_cc_a_n2')->nullable();
                $table->text('des_cc_a_n2')->nullable();
                $table->text('cod_cc_b_n2')->nullable();
                $table->text('des_cc_b_n2')->nullable();
                $table->text('cod_cc_c_n2')->nullable();
                $table->text('des_cc_c_n2')->nullable();
                $table->text('percentuale_cc_n2')->nullable();
                $table->text('cod_cc_a_n3')->nullable();
                $table->text('des_cc_a_n3')->nullable();
                $table->text('cod_cc_b_n3')->nullable();
                $table->text('des_cc_b_n3')->nullable();
                $table->text('cod_cc_c_n3')->nullable();
                $table->text('des_cc_c_n3')->nullable();
                $table->text('percentuale_cc_n3')->nullable();
                $table->text('cod_categ_spec_l_68_1999')->nullable();
                $table->text('des_categ_spec_l_68_1999')->nullable();
                $table->text('cod_invalid_successiva')->nullable();
                $table->text('des_invalid_successiva')->nullable();
                $table->text('cod_titolo_di_studio')->nullable();
                $table->text('des_titolo_di_studio')->nullable();
                $table->text('cod_posizione_inail')->nullable();
                $table->text('des_posizione_inail')->nullable();
                $table->text('cod_class_spesa')->nullable();
                $table->text('cod_class_spesa1')->nullable();
                $table->text('cod_tipologia_irap')->nullable();
                $table->text('des_tipologia_irap')->nullable();
                $table->text('data_di_scadenza')->nullable();
                $table->text('livello_1')->nullable();
                $table->text('descrizione_livello_1')->nullable();
                $table->text('livello_2')->nullable();
                $table->text('descrizione_livello_2')->nullable();
                $table->text('livello_3')->nullable();
                $table->text('descrizione_livello_3')->nullable();
                $table->text('livello_4')->nullable();
                $table->text('descrizione_livello_4')->nullable();
                $table->text('livello_5')->nullable();
                $table->text('descrizione_livello_5')->nullable();
                $table->text('livello_6')->nullable();
                $table->text('descrizione_livello_6')->nullable();
                $table->text('livello_7')->nullable();
                $table->text('descrizione_livello_7')->nullable();
                $table->text('livello_8')->nullable();
                $table->text('descrizione_livello_8')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('alipro');
    }
}
