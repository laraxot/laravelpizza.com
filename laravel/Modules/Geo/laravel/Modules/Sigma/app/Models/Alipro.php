<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Alipro.
 *
 * @property int $id
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $ente
 * @property string|null $matricola
 * @property string|null $data_nascita
 * @property string|null $comune_nascita
 * @property string|null $codice_fiscale
 * @property string|null $sesso
 * @property string|null $comune_residenza
 * @property string|null $provincia
 * @property string|null $localita
 * @property string|null $toponomastica
 * @property string|null $indirizzo
 * @property string|null $cap
 * @property string|null $data_assunzione
 * @property string|null $data_cessazione
 * @property string|null $part_time_eff
 * @property string|null $part_time_teor
 * @property string|null $cod_stabilimento
 * @property string|null $des_stabilimento
 * @property string|null $cod_reparto
 * @property string|null $des_reparto
 * @property string|null $contratto
 * @property string|null $rapporto_lavoro
 * @property string|null $ruolo
 * @property string|null $profilo_professionale
 * @property string|null $pos_funzionale
 * @property string|null $mansione
 * @property string|null $disciplina
 * @property string|null $des_profilo
 * @property string|null $des_disciplina
 * @property string|null $des_qualifica_1
 * @property string|null $des_qualifica_2
 * @property string|null $liv_categoria
 * @property string|null $fascia
 * @property string|null $pos_giuridica
 * @property string|null $des_pos_giuridica
 * @property string|null $cod_cc_a_n1
 * @property string|null $des_cc_a_n1
 * @property string|null $cod_cc_b_n1
 * @property string|null $des_cc_b_n1
 * @property string|null $cod_cc_c_n1
 * @property string|null $des_cc_c_n1
 * @property string|null $percentuale_cc_n1
 * @property string|null $cod_cc_a_n2
 * @property string|null $des_cc_a_n2
 * @property string|null $cod_cc_b_n2
 * @property string|null $des_cc_b_n2
 * @property string|null $cod_cc_c_n2
 * @property string|null $des_cc_c_n2
 * @property string|null $percentuale_cc_n2
 * @property string|null $cod_cc_a_n3
 * @property string|null $des_cc_a_n3
 * @property string|null $cod_cc_b_n3
 * @property string|null $des_cc_b_n3
 * @property string|null $cod_cc_c_n3
 * @property string|null $des_cc_c_n3
 * @property string|null $percentuale_cc_n3
 * @property string|null $cod_categ_spec_l_68_1999
 * @property string|null $des_categ_spec_l_68_1999
 * @property string|null $cod_invalid_successiva
 * @property string|null $des_invalid_successiva
 * @property string|null $cod_titolo_di_studio
 * @property string|null $des_titolo_di_studio
 * @property string|null $cod_posizione_inail
 * @property string|null $des_posizione_inail
 * @property string|null $cod_class_spesa
 * @property string|null $cod_class_spesa1
 * @property string|null $cod_tipologia_irap
 * @property string|null $des_tipologia_irap
 * @property string|null $data_di_scadenza
 * @property string|null $livello_1
 * @property string|null $descrizione_livello_1
 * @property string|null $livello_2
 * @property string|null $descrizione_livello_2
 * @property string|null $livello_3
 * @property string|null $descrizione_livello_3
 * @property string|null $livello_4
 * @property string|null $descrizione_livello_4
 * @property string|null $livello_5
 * @property string|null $descrizione_livello_5
 * @property string|null $livello_6
 * @property string|null $descrizione_livello_6
 * @property string|null $livello_7
 * @property string|null $descrizione_livello_7
 * @property string|null $livello_8
 * @property string|null $descrizione_livello_8
 *
 * @method static Builder|Alipro newModelQuery()
 * @method static Builder|Alipro newQuery()
 * @method static Builder|Alipro query()
 * @method static Builder|Alipro whereCap($value)
 * @method static Builder|Alipro whereCodCategSpecL681999($value)
 * @method static Builder|Alipro whereCodCcAN1($value)
 * @method static Builder|Alipro whereCodCcAN2($value)
 * @method static Builder|Alipro whereCodCcAN3($value)
 * @method static Builder|Alipro whereCodCcBN1($value)
 * @method static Builder|Alipro whereCodCcBN2($value)
 * @method static Builder|Alipro whereCodCcBN3($value)
 * @method static Builder|Alipro whereCodCcCN1($value)
 * @method static Builder|Alipro whereCodCcCN2($value)
 * @method static Builder|Alipro whereCodCcCN3($value)
 * @method static Builder|Alipro whereCodClassSpesa($value)
 * @method static Builder|Alipro whereCodClassSpesa1($value)
 * @method static Builder|Alipro whereCodInvalidSuccessiva($value)
 * @method static Builder|Alipro whereCodPosizioneInail($value)
 * @method static Builder|Alipro whereCodReparto($value)
 * @method static Builder|Alipro whereCodStabilimento($value)
 * @method static Builder|Alipro whereCodTipologiaIrap($value)
 * @method static Builder|Alipro whereCodTitoloDiStudio($value)
 * @method static Builder|Alipro whereCodiceFiscale($value)
 * @method static Builder|Alipro whereCognome($value)
 * @method static Builder|Alipro whereComuneNascita($value)
 * @method static Builder|Alipro whereComuneResidenza($value)
 * @method static Builder|Alipro whereContratto($value)
 * @method static Builder|Alipro whereDataAssunzione($value)
 * @method static Builder|Alipro whereDataCessazione($value)
 * @method static Builder|Alipro whereDataDiScadenza($value)
 * @method static Builder|Alipro whereDataNascita($value)
 * @method static Builder|Alipro whereDesCategSpecL681999($value)
 * @method static Builder|Alipro whereDesCcAN1($value)
 * @method static Builder|Alipro whereDesCcAN2($value)
 * @method static Builder|Alipro whereDesCcAN3($value)
 * @method static Builder|Alipro whereDesCcBN1($value)
 * @method static Builder|Alipro whereDesCcBN2($value)
 * @method static Builder|Alipro whereDesCcBN3($value)
 * @method static Builder|Alipro whereDesCcCN1($value)
 * @method static Builder|Alipro whereDesCcCN2($value)
 * @method static Builder|Alipro whereDesCcCN3($value)
 * @method static Builder|Alipro whereDesDisciplina($value)
 * @method static Builder|Alipro whereDesInvalidSuccessiva($value)
 * @method static Builder|Alipro whereDesPosGiuridica($value)
 * @method static Builder|Alipro whereDesPosizioneInail($value)
 * @method static Builder|Alipro whereDesProfilo($value)
 * @method static Builder|Alipro whereDesQualifica1($value)
 * @method static Builder|Alipro whereDesQualifica2($value)
 * @method static Builder|Alipro whereDesReparto($value)
 * @method static Builder|Alipro whereDesStabilimento($value)
 * @method static Builder|Alipro whereDesTipologiaIrap($value)
 * @method static Builder|Alipro whereDesTitoloDiStudio($value)
 * @method static Builder|Alipro whereDescrizioneLivello1($value)
 * @method static Builder|Alipro whereDescrizioneLivello2($value)
 * @method static Builder|Alipro whereDescrizioneLivello3($value)
 * @method static Builder|Alipro whereDescrizioneLivello4($value)
 * @method static Builder|Alipro whereDescrizioneLivello5($value)
 * @method static Builder|Alipro whereDescrizioneLivello6($value)
 * @method static Builder|Alipro whereDescrizioneLivello7($value)
 * @method static Builder|Alipro whereDescrizioneLivello8($value)
 * @method static Builder|Alipro whereDisciplina($value)
 * @method static Builder|Alipro whereEnte($value)
 * @method static Builder|Alipro whereFascia($value)
 * @method static Builder|Alipro whereId($value)
 * @method static Builder|Alipro whereIndirizzo($value)
 * @method static Builder|Alipro whereLivCategoria($value)
 * @method static Builder|Alipro whereLivello1($value)
 * @method static Builder|Alipro whereLivello2($value)
 * @method static Builder|Alipro whereLivello3($value)
 * @method static Builder|Alipro whereLivello4($value)
 * @method static Builder|Alipro whereLivello5($value)
 * @method static Builder|Alipro whereLivello6($value)
 * @method static Builder|Alipro whereLivello7($value)
 * @method static Builder|Alipro whereLivello8($value)
 * @method static Builder|Alipro whereLocalita($value)
 * @method static Builder|Alipro whereMansione($value)
 * @method static Builder|Alipro whereMatricola($value)
 * @method static Builder|Alipro whereNome($value)
 * @method static Builder|Alipro wherePartTimeEff($value)
 * @method static Builder|Alipro wherePartTimeTeor($value)
 * @method static Builder|Alipro wherePercentualeCcN1($value)
 * @method static Builder|Alipro wherePercentualeCcN2($value)
 * @method static Builder|Alipro wherePercentualeCcN3($value)
 * @method static Builder|Alipro wherePosFunzionale($value)
 * @method static Builder|Alipro wherePosGiuridica($value)
 * @method static Builder|Alipro whereProfiloProfessionale($value)
 * @method static Builder|Alipro whereProvincia($value)
 * @method static Builder|Alipro whereRapportoLavoro($value)
 * @method static Builder|Alipro whereRuolo($value)
 * @method static Builder|Alipro whereSesso($value)
 * @method static Builder|Alipro whereToponomastica($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AliproFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Alipro extends BaseModel
{
    protected $table = 'alipro';
}
