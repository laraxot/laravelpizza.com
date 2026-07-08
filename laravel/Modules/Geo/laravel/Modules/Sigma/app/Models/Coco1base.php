<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Coco1base.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $contratto
 * @property string|null $matricola
 * @property string|null $mese_da_liquidare
 * @property string|null $anno_da_liquidare
 * @property string|null $numero_giorni_mese_da_liq
 * @property string|null $voce_retributiva
 * @property string|null $_riduzione_per_aspettativa
 * @property string|null $totale_voce
 * @property string|null $totale_voce_in_euro
 * @property string|null $totale_voce_salvato
 * @property string|null $totale_voce_salvato_in_euro
 * @property string|null $totale_ore_straord
 * @property string|null $anno_di_appartenenza
 * @property string|null $mese_di_appartenenza
 * @property string|null $ruolo
 * @property string|null $imputazione_bilancio
 * @property string|null $clas_funz_dip
 * @property string|null $flag_inq_clafun
 * @property string|null $codice_istituto_tab_14
 * @property string|null $base_2__aggiuntivi
 * @property string|null $field21
 * @property string|null $field22
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $sesso
 * @property string|null $stato_civile
 * @property string|null $classificazione_funzionale
 * @property string|null $titolo_di_studio
 * @property string|null $ente_di_provenienza
 * @property string|null $sindacato
 * @property string|null $categoria_speciale
 * @property string|null $titolo_professionale
 * @property string|null $field33
 * @property string|null $stabilimento
 * @property string|null $reparto
 * @property string|null $banca_per_accredito_stipend
 * @property string|null $agenzia
 * @property string|null $numero_conto_corrente
 * @property string|null $codice_inail
 * @property string|null $flag_servizio_
 * @property string|null $data_assunzione
 * @property string|null $data_dimissione
 * @property string|null $tipo_assunzione
 * @property string|null $tipo_dimissione
 * @property string|null $data_dal
 * @property string|null $data_al
 * @property string|null $stabpianta_organica
 * @property string|null $reppianta_organica
 * @property string|null $stabposto_lavoro
 * @property string|null $repposto_lavoro
 * @property string|null $tipo_pianta_organica
 * @property string|null $data_partenza_qualifica
 * @property string|null $data_fine_qualifica
 * @property string|null $data_anzian_convenzionale
 * @property string|null $nanni_qual_second
 * @property string|null $posizione
 * @property string|null $data_passaggio_in_ruolo
 * @property string|null $ore_lavorate
 * @property string|null $ore_teoriche
 * @property string|null $field60
 * @property string|null $tipo_contribuzione
 * @property string|null $rapporto_lavoro
 * @property string|null $field63
 * @property string|null $profilo_professionale
 * @property string|null $posizione__funzionale
 * @property string|null $codice_qualifica
 * @property string|null $disciplina_qualif_primaria
 * @property string|null $qual_secondaria
 * @property string|null $field69
 * @property string|null $field70
 * @property string|null $field71
 * @property string|null $field72
 * @property string|null $field73
 * @property string|null $disciplina_qulif_secondaria
 * @property string|null $tipo_aspettativa
 * @property string|null $data_inizio
 * @property string|null $data_fine
 * @property string|null $flag_di_annullamento
 *
 * @method static Builder|Coco1base newModelQuery()
 * @method static Builder|Coco1base newQuery()
 * @method static Builder|Coco1base query()
 * @method static Builder|Coco1base whereAgenzia($value)
 * @method static Builder|Coco1base whereAnnoDaLiquidare($value)
 * @method static Builder|Coco1base whereAnnoDiAppartenenza($value)
 * @method static Builder|Coco1base whereBancaPerAccreditoStipend($value)
 * @method static Builder|Coco1base whereBase2Aggiuntivi($value)
 * @method static Builder|Coco1base whereCategoriaSpeciale($value)
 * @method static Builder|Coco1base whereClasFunzDip($value)
 * @method static Builder|Coco1base whereClassificazioneFunzionale($value)
 * @method static Builder|Coco1base whereCodiceInail($value)
 * @method static Builder|Coco1base whereCodiceIstitutoTab14($value)
 * @method static Builder|Coco1base whereCodiceQualifica($value)
 * @method static Builder|Coco1base whereCognome($value)
 * @method static Builder|Coco1base whereContratto($value)
 * @method static Builder|Coco1base whereDataAl($value)
 * @method static Builder|Coco1base whereDataAnzianConvenzionale($value)
 * @method static Builder|Coco1base whereDataAssunzione($value)
 * @method static Builder|Coco1base whereDataDal($value)
 * @method static Builder|Coco1base whereDataDimissione($value)
 * @method static Builder|Coco1base whereDataFine($value)
 * @method static Builder|Coco1base whereDataFineQualifica($value)
 * @method static Builder|Coco1base whereDataInizio($value)
 * @method static Builder|Coco1base whereDataPartenzaQualifica($value)
 * @method static Builder|Coco1base whereDataPassaggioInRuolo($value)
 * @method static Builder|Coco1base whereDisciplinaQualifPrimaria($value)
 * @method static Builder|Coco1base whereDisciplinaQulifSecondaria($value)
 * @method static Builder|Coco1base whereEnte($value)
 * @method static Builder|Coco1base whereEnteDiProvenienza($value)
 * @method static Builder|Coco1base whereField21($value)
 * @method static Builder|Coco1base whereField22($value)
 * @method static Builder|Coco1base whereField33($value)
 * @method static Builder|Coco1base whereField60($value)
 * @method static Builder|Coco1base whereField63($value)
 * @method static Builder|Coco1base whereField69($value)
 * @method static Builder|Coco1base whereField70($value)
 * @method static Builder|Coco1base whereField71($value)
 * @method static Builder|Coco1base whereField72($value)
 * @method static Builder|Coco1base whereField73($value)
 * @method static Builder|Coco1base whereFlagDiAnnullamento($value)
 * @method static Builder|Coco1base whereFlagInqClafun($value)
 * @method static Builder|Coco1base whereFlagServizio($value)
 * @method static Builder|Coco1base whereId($value)
 * @method static Builder|Coco1base whereImputazioneBilancio($value)
 * @method static Builder|Coco1base whereMatricola($value)
 * @method static Builder|Coco1base whereMeseDaLiquidare($value)
 * @method static Builder|Coco1base whereMeseDiAppartenenza($value)
 * @method static Builder|Coco1base whereNanniQualSecond($value)
 * @method static Builder|Coco1base whereNome($value)
 * @method static Builder|Coco1base whereNumeroContoCorrente($value)
 * @method static Builder|Coco1base whereNumeroGiorniMeseDaLiq($value)
 * @method static Builder|Coco1base whereOreLavorate($value)
 * @method static Builder|Coco1base whereOreTeoriche($value)
 * @method static Builder|Coco1base wherePosizione($value)
 * @method static Builder|Coco1base wherePosizioneFunzionale($value)
 * @method static Builder|Coco1base whereProfiloProfessionale($value)
 * @method static Builder|Coco1base whereQualSecondaria($value)
 * @method static Builder|Coco1base whereRapportoLavoro($value)
 * @method static Builder|Coco1base whereReparto($value)
 * @method static Builder|Coco1base whereReppiantaOrganica($value)
 * @method static Builder|Coco1base whereReppostoLavoro($value)
 * @method static Builder|Coco1base whereRiduzionePerAspettativa($value)
 * @method static Builder|Coco1base whereRuolo($value)
 * @method static Builder|Coco1base whereSesso($value)
 * @method static Builder|Coco1base whereSindacato($value)
 * @method static Builder|Coco1base whereStabilimento($value)
 * @method static Builder|Coco1base whereStabpiantaOrganica($value)
 * @method static Builder|Coco1base whereStabpostoLavoro($value)
 * @method static Builder|Coco1base whereStatoCivile($value)
 * @method static Builder|Coco1base whereTipoAspettativa($value)
 * @method static Builder|Coco1base whereTipoAssunzione($value)
 * @method static Builder|Coco1base whereTipoContribuzione($value)
 * @method static Builder|Coco1base whereTipoDimissione($value)
 * @method static Builder|Coco1base whereTipoPiantaOrganica($value)
 * @method static Builder|Coco1base whereTitoloDiStudio($value)
 * @method static Builder|Coco1base whereTitoloProfessionale($value)
 * @method static Builder|Coco1base whereTotaleOreStraord($value)
 * @method static Builder|Coco1base whereTotaleVoce($value)
 * @method static Builder|Coco1base whereTotaleVoceInEuro($value)
 * @method static Builder|Coco1base whereTotaleVoceSalvato($value)
 * @method static Builder|Coco1base whereTotaleVoceSalvatoInEuro($value)
 * @method static Builder|Coco1base whereVoceRetributiva($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Coco1baseFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Coco1base extends BaseModel
{
    protected $table = 'coco1base';
}
