<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Activity\Models\Activity;
use Modules\Progressioni\Models\Scheda;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Integparam;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Repart;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Tqu00f;
use Modules\Sigma\Models\Wstr01lx;
use Parental\HasParent;

/**
 * Modules\Performance\Models\IndividualeRegionale.
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $post_type
 * @property int $ente
 * @property int|null $matr
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $email
 * @property int|null $stabi
 * @property int|null $repar
 * @property int|null $stabival
 * @property int|null $reparval
 * @property string|null $stabi_txt
 * @property string|null $repar_txt
 * @property int|null $disci
 * @property string|null $disci_txt
 * @property int|null $rep2kd
 * @property int|null $rep2ka
 * @property int|null $posiz
 * @property int|null $propro
 * @property int|null $posfun
 * @property string|null $categoria_eco
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property int|null $dal
 * @property int|null $al
 * @property int|null $anno
 * @property int|null $giornitempodet
 * @property int $ha_diritto
 * @property string|null $motivo
 * @property string|null $esperienza_acquisita
 * @property string|null $risultati_ottenuti
 * @property string|null $arricchimento_professionale
 * @property string|null $impegno
 * @property string|null $qualita_prestazione
 * @property float|null $totale_punteggio
 * @property string|null $lista_auth
 * @property float|null $peso_esperienza_acquisita
 * @property float|null $peso_risultati_ottenuti
 * @property float|null $peso_arricchimento_professionale
 * @property float|null $peso_impegno
 * @property float|null $peso_qualita_prestazione
 * @property string|null $datemod
 * @property string|null $note
 * @property string|null $oree
 * @property string|null $oret
 * @property float|null $perc_parttime
 * @property string|null $perc_parttimepond
 * @property int|null $gg_parttimevert
 * @property string|null $ore_assenza
 * @property string|null $giorni_assenza
 * @property string|null $giorni_presenza
 * @property string|null $categ_coeff
 * @property string|null $quota_teorica
 * @property string|null $budget_assegnato
 * @property string|null $quota_effettiva
 * @property string|null $resti
 * @property string|null $resti_pond
 * @property string|null $importo_totale
 * @property string|null $gg_totale_sigma
 * @property string|null $gg_validi_sigma
 * @property string|null $gg_assenz_sigma
 * @property string|null $decurtazione_perc
 * @property int $gg_tempo_determinato
 * @property int|null $gg_posiz_1_in_sede
 * @property int $gg_assenza_anno
 * @property int $gg_presenza_anno
 * @property string|null $ore_assenza_anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $posiz_txt
 * @property int|null $clafun
 * @property int|null $disci1
 * @property string|null $disci1_txt
 * @property int $gg_ruolo
 * @property int|null $last_data_assunz
 * @property string|null $perc_parttime_anno
 * @property string|null $perc_parttime_dalal
 * @property int|null $gg_parttimevert_anno
 * @property int|null $gg_parttimevert_dalal
 * @property float|null $perc_parttimepond_anno
 * @property string|null $perc_parttimepond_dalal
 * @property int|null $gg_presenza_dalal
 * @property int|null $gg_assenza_dalal
 * @property float|null $hh_assenza_anno
 * @property float|null $hh_assenza_dalal
 * @property string|null $lang
 * @property int|null $excellence
 * @property int|null $codqua
 * @property int|null $cont
 * @property int|null $tipco
 * @property string|null $posizione_eco
 * @property float $gg_anno
 * @property-read Collection<int, Sto00f> $Sto00fYear
 * @property-read int|null $sto00f_year_count
 * @property-read Collection<int, Ana02f> $ana02f
 * @property-read int|null $ana02f_count
 * @property-read Ana10f|null $ana10f
 * @property-read Anag|null $anag
 * @property-read Collection<int, Asz00f> $asz00f
 * @property-read int|null $asz00f_count
 * @property-read Collection<int, Asz00k1> $asz00k1
 * @property-read int|null $asz00k1_count
 * @property-read Collection<int, Asz00k1> $asz00k1Year
 * @property-read int|null $asz00k1_year_count
 * @property-read Collection<int, Individuale> $cards
 * @property-read int|null $cards_count
 * @property-read Collection<int, IndividualeAssenze> $codiciAssenze
 * @property-read int|null $codici_assenze_count
 * @property-read Collection<int, CriteriEsclusione> $criteriEsclusione
 * @property-read int|null $criteri_esclusione_count
 * @property-read CriteriMaggiorazione|null $criteriMaggiorazione
 * @property-read Collection<int, CriteriOption> $criteriOptions
 * @property-read int|null $criteri_options_count
 * @property-read Collection<int, CriteriValutazione> $criteriValutazione
 * @property-read int|null $criteri_valutazione_count
 * @property-read int|float $gg_p_time_vert_year
 * @property-read int|float $perc_p_time_daterange
 * @property-read int|float $perc_p_time_year
 * @property-read mixed $titolo_di_studio
 * @property-read Collection<int, MyLog> $mailInviate
 * @property-read int|null $mail_inviate_count
 * @property-read Collection<int, IndividualeRegionale> $mails
 * @property-read int|null $mails_count
 * @property-read Collection<int, MyLog> $myLogs
 * @property-read int|null $my_logs_count
 * @property-read Collection<int, Option> $options
 * @property-read int|null $options_count
 * @property-read Collection<int, IndividualeRegionale> $otherWinnerRows
 * @property-read int|null $other_winner_rows_count
 * @property-read IndividualePesi|null $peso
 * @property-read IndividualePoPesi|null $pesoPo
 * @property-read Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 * @property-read Collection<int, Qua00f> $qua00fDaterange
 * @property-read int|null $qua00f_daterange_count
 * @property-read Collection<int, Qua03f> $qua03f
 * @property-read int|null $qua03f_count
 * @property-read Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 * @property-read Collection<int, Repart> $reparts
 * @property-read int|null $reparts_count
 * @property-read StabiDirigente|null $stabiDirigente
 * @property-read Collection<int, Sto00f> $sto00f
 * @property-read int|null $sto00f_count
 * @property-read IndividualeTotStabi|null $totStabi
 * @property-read Tqu00f|null $tqu00f
 * @property-read Collection<int, Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 * @property-read Collection<int, Wstr01lx> $wstr01lxYear
 * @property-read int|null $wstr01lx_year_count
 *
 * @method static Builder|IndividualeRegionale newModelQuery()
 * @method static Builder|IndividualeRegionale newQuery()
 * @method static Builder<self>|BaseIndividualeModel<self> ofDate(int $date)
 * @method static Builder<self>|BaseIndividualeModel<self> ofEnteYear(int $ente, int $year)
 * @method static Builder<self>|BaseIndividualeModel<self> ofQuarter(int $quarter, int $year)
 * @method static Builder<self>|BaseIndividualeModel<self> ofRangeDate(int $date_start, int $date_end)
 * @method static Builder<self>|BaseIndividualeModel<self> ofYear(int $year)
 * @method static Builder|IndividualeRegionale query()
 * @method static Builder|IndividualeRegionale whereAl($value)
 * @method static Builder|IndividualeRegionale whereAnno($value)
 * @method static Builder|IndividualeRegionale whereArricchimentoProfessionale($value)
 * @method static Builder|IndividualeRegionale whereBudgetAssegnato($value)
 * @method static Builder|IndividualeRegionale whereCategCoeff($value)
 * @method static Builder|IndividualeRegionale whereCategoriaEco($value)
 * @method static Builder|IndividualeRegionale whereClafun($value)
 * @method static Builder|IndividualeRegionale whereCodqua($value)
 * @method static Builder|IndividualeRegionale whereCognome($value)
 * @method static Builder|IndividualeRegionale whereCont($value)
 * @method static Builder|IndividualeRegionale whereCreatedAt($value)
 * @method static Builder|IndividualeRegionale whereCreatedBy($value)
 * @method static Builder|IndividualeRegionale whereDal($value)
 * @method static Builder|IndividualeRegionale whereDatemod($value)
 * @method static Builder|IndividualeRegionale whereDecurtazionePerc($value)
 * @method static Builder|IndividualeRegionale whereDisci($value)
 * @method static Builder|IndividualeRegionale whereDisci1($value)
 * @method static Builder|IndividualeRegionale whereDisci1Txt($value)
 * @method static Builder|IndividualeRegionale whereDisciTxt($value)
 * @method static Builder|IndividualeRegionale whereEmail($value)
 * @method static Builder|IndividualeRegionale whereEnte($value)
 * @method static Builder|IndividualeRegionale whereEsperienzaAcquisita($value)
 * @method static Builder|IndividualeRegionale whereExcellence($value)
 * @method static Builder|IndividualeRegionale whereGgAnno($value)
 * @method static Builder|IndividualeRegionale whereGgAssenzSigma($value)
 * @method static Builder|IndividualeRegionale whereGgAssenzaAnno($value)
 * @method static Builder|IndividualeRegionale whereGgAssenzaDalal($value)
 * @method static Builder|IndividualeRegionale whereGgParttimevert($value)
 * @method static Builder|IndividualeRegionale whereGgParttimevertAnno($value)
 * @method static Builder|IndividualeRegionale whereGgParttimevertDalal($value)
 * @method static Builder|IndividualeRegionale whereGgPosiz1InSede($value)
 * @method static Builder|IndividualeRegionale whereGgPresenzaAnno($value)
 * @method static Builder|IndividualeRegionale whereGgPresenzaDalal($value)
 * @method static Builder|IndividualeRegionale whereGgRuolo($value)
 * @method static Builder|IndividualeRegionale whereGgTempoDeterminato($value)
 * @method static Builder|IndividualeRegionale whereGgTotaleSigma($value)
 * @method static Builder|IndividualeRegionale whereGgValidiSigma($value)
 * @method static Builder|IndividualeRegionale whereGiorniAssenza($value)
 * @method static Builder|IndividualeRegionale whereGiorniPresenza($value)
 * @method static Builder|IndividualeRegionale whereGiornitempodet($value)
 * @method static Builder|IndividualeRegionale whereHaDiritto($value)
 * @method static Builder|IndividualeRegionale whereHhAssenzaAnno($value)
 * @method static Builder|IndividualeRegionale whereHhAssenzaDalal($value)
 * @method static Builder|IndividualeRegionale whereId($value)
 * @method static Builder|IndividualeRegionale whereImpegno($value)
 * @method static Builder|IndividualeRegionale whereImportoTotale($value)
 * @method static Builder|IndividualeRegionale whereLang($value)
 * @method static Builder|IndividualeRegionale whereLastDataAssunz($value)
 * @method static Builder|IndividualeRegionale whereListaAuth($value)
 * @method static Builder|IndividualeRegionale whereMatr($value)
 * @method static Builder|IndividualeRegionale whereMotivo($value)
 * @method static Builder|IndividualeRegionale whereNome($value)
 * @method static Builder|IndividualeRegionale whereNote($value)
 * @method static Builder|IndividualeRegionale whereOreAssenza($value)
 * @method static Builder|IndividualeRegionale whereOreAssenzaAnno($value)
 * @method static Builder|IndividualeRegionale whereOree($value)
 * @method static Builder|IndividualeRegionale whereOret($value)
 * @method static Builder|IndividualeRegionale wherePercParttime($value)
 * @method static Builder|IndividualeRegionale wherePercParttimeAnno($value)
 * @method static Builder|IndividualeRegionale wherePercParttimeDalal($value)
 * @method static Builder|IndividualeRegionale wherePercParttimepond($value)
 * @method static Builder|IndividualeRegionale wherePercParttimepondAnno($value)
 * @method static Builder|IndividualeRegionale wherePercParttimepondDalal($value)
 * @method static Builder|IndividualeRegionale wherePesoArricchimentoProfessionale($value)
 * @method static Builder|IndividualeRegionale wherePesoEsperienzaAcquisita($value)
 * @method static Builder|IndividualeRegionale wherePesoImpegno($value)
 * @method static Builder|IndividualeRegionale wherePesoQualitaPrestazione($value)
 * @method static Builder|IndividualeRegionale wherePesoRisultatiOttenuti($value)
 * @method static Builder|IndividualeRegionale wherePosfun($value)
 * @method static Builder|IndividualeRegionale wherePosiz($value)
 * @method static Builder|IndividualeRegionale wherePosizTxt($value)
 * @method static Builder|IndividualeRegionale wherePosizioneEco($value)
 * @method static Builder|IndividualeRegionale wherePostType($value)
 * @method static Builder|IndividualeRegionale wherePropro($value)
 * @method static Builder|IndividualeRegionale whereQua2ka($value)
 * @method static Builder|IndividualeRegionale whereQua2kd($value)
 * @method static Builder|IndividualeRegionale whereQualitaPrestazione($value)
 * @method static Builder|IndividualeRegionale whereQuotaEffettiva($value)
 * @method static Builder|IndividualeRegionale whereQuotaTeorica($value)
 * @method static Builder|IndividualeRegionale whereRep2ka($value)
 * @method static Builder|IndividualeRegionale whereRep2kd($value)
 * @method static Builder|IndividualeRegionale whereRepar($value)
 * @method static Builder|IndividualeRegionale whereReparTxt($value)
 * @method static Builder|IndividualeRegionale whereReparval($value)
 * @method static Builder|IndividualeRegionale whereResti($value)
 * @method static Builder|IndividualeRegionale whereRestiPond($value)
 * @method static Builder|IndividualeRegionale whereRisultatiOttenuti($value)
 * @method static Builder|IndividualeRegionale whereSchedaType($value)
 * @method static Builder|IndividualeRegionale whereStabi($value)
 * @method static Builder|IndividualeRegionale whereStabiTxt($value)
 * @method static Builder|IndividualeRegionale whereStabival($value)
 * @method static Builder|IndividualeRegionale whereTipco($value)
 * @method static Builder|IndividualeRegionale whereTotalePunteggio($value)
 * @method static Builder|IndividualeRegionale whereUpdatedAt($value)
 * @method static Builder|IndividualeRegionale whereUpdatedBy($value)
 * @method static Builder<self>|BaseIndividualeModel<self> withDays(int $date_min, int $date_max)
 * @method static Builder<self>|BaseIndividualeModel<self> withTotPunt()
 *
 * @property int|null $assenze_aggiornate Flag per tracciamento aggiornamento assenze, vedi pipeline individuale
 * @property-read Profile|null $creator
 * @property-read Collection<int, CriteriValutazione> $criteriValutazioneOld
 * @property-read int|null $criteri_valutazione_old_count
 * @property-read mixed $aventi_diritto
 * @property-read mixed $aventi_diritto_eff
 * @property-read string|null $categoria_ecoval
 * @property-read string|null $codice_fiscale
 * @property-read float|null $eta
 * @property-read int|null $excellences_count_last3years
 * @property-read int|null $gg_asz
 * @property-read int|null $gg_asz_cateco
 * @property-read int|null $gg_asz_cateco_fuori_sede
 * @property-read int|null $gg_asz_cateco_in_sede
 * @property-read int|null $gg_asz_cateco_posfun
 * @property-read int|null $gg_asz_cateco_posfun_fuori_sede
 * @property-read int|null $gg_asz_cateco_posfun_in_sede
 * @property-read int|null $gg_asz_fuori_sede
 * @property-read int|null $gg_asz_in_sede
 * @property-read int|null $gg_asz_tip_cod_escluso_subito
 * @property-read int|null $gg
 * @property-read int|null $gg_cateco
 * @property-read int|null $gg_cateco_fuori_sede
 * @property-read int|null $gg_cateco_in_sede
 * @property-read int|null $gg_cateco_no_asz
 * @property-read int|null $gg_cateco_no_posfun_no_asz
 * @property-read int|null $gg_cateco_posfun
 * @property-read int|null $gg_cateco_posfun_fuori_sede
 * @property-read int|null $gg_cateco_posfun_in_sede
 * @property-read int|null $gg_cateco_posfun_in_sede_no_asz
 * @property-read int|null $gg_cateco_posfun_no_asz
 * @property-read int|null $gg_cateco_sup
 * @property-read int|null $gg_cateco_sup_fuori_sede
 * @property-read int|null $gg_cateco_sup_in_sede
 * @property-read int|null $gg_fuori_sede
 * @property-read float|null $gg_fuori_sede_no_asz
 * @property-read int|null $gg_in_sede
 * @property-read float|null $gg_in_sede_no_asz
 * @property-read float|null $gg_no_asz
 * @property-read int|null $gg_posiz1_in_sede
 * @property-read int|null $hh_asz
 * @property-read int|null $hh_asz_fuori_sede
 * @property-read int|null $hh_asz_in_sede
 * @property-read float|null $importo_stipendio_annuo
 * @property-read string|null $inail
 * @property-read string|null $lista_propro
 * @property-read string|null $lista_propro_sup
 * @property-read float|null $perf_ind2014
 * @property-read float|null $perf_ind2015
 * @property-read float|null $perf_ind2016
 * @property-read float|null $perf_ind2017
 * @property-read float|null $perf_ind2018
 * @property-read float|null $perf_ind2019
 * @property-read float|null $perf_ind2020
 * @property-read float|null $perf_ind2021
 * @property-read float|null $perf_ind2022
 * @property-read float|null $perf_ind2023
 * @property-read float|null $perf_ind2024
 * @property-read float|null $perf_ind2025
 * @property-read float|null $perf_ind2026
 * @property-read float|null $perf_ind2027
 * @property-read float|null $perf_ind2028
 * @property-read float|null $perf_ind2029
 * @property-read float|null $perf_ind2030
 * @property-read int|null $perf_ind_count_last3_years
 * @property-read float|null $perf_ind_media
 * @property-read int $posfunval
 * @property-read int $posizione
 * @property-read float|null $ptime
 * @property float|null $punt_progressione_finale
 * @property-read string|null $sesso
 * @property-read float|null $totale_pond
 * @property-read float|null $valore_differenziale_rapportato_pt
 * @property-read int|null $valutatore_id
 * @property-read string|null $valutatore_txt
 * @property-read Profile|null $updater
 * @property-read StabiDirigente|null $valutatore
 *
 * @method static Builder<static>|IndividualeRegionale ofEnte(int $ente)
 * @method static Builder<static>|IndividualeRegionale ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder<static>|IndividualeRegionale whereAssenzeAggiornate($value)
 *
 * @property string|null $scheda_type
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Scheda> $avversari
 * @property-read int|null $avversari_count
 * @property-read Collection<int, Scheda> $avversariCategoriaEco
 * @property-read int|null $avversari_categoria_eco_count
 * @property-read Profile|null $deleter
 * @property-read string $from_field
 * @property-read float $gg_cateco_posfun_rapportato_max10_valutatore
 * @property-read int|null $gg_esperienza_no_asz
 * @property-read float|null $gg_integ_params_asz
 * @property-read string $to_field
 * @property-read Collection<int, Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read IndividualeRegionale|null $maxCatecoPosfun
 * @property-read Collection<int, Individuale> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @property-read IndividualeRegionale|null $pesi
 * @property-read Collection<int, Qua00f> $qua00fYear
 * @property-read int|null $qua00f_year_count
 * @property-read IndividualeRegionale|null $stipendioTabellare
 *
 * @method static Builder<static>|IndividualeRegionale childrenWith(array<int, mixed> $relations)
 * @method static Builder<static>|IndividualeRegionale childrenWithCount(array<int, mixed> $relations)
 * @method static \Modules\Performance\Database\Factories\IndividualeRegionaleFactory factory($count = null, $state = [])
 * @method static Builder<static>|IndividualeRegionale whereCategoriaEcoval($value)
 * @method static Builder<static>|IndividualeRegionale wherePosfunval($value)
 * @method static Builder<static>|IndividualeRegionale whereTitoloDiStudio($value)
 * @method static Builder<static>|IndividualeRegionale whereType($value)
 * @method static Builder<static>|IndividualeRegionale whereValutatoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualeRegionale withCalculatedData()
 *
 * @property-read CategoriaPropro|null $categoriaPropro
 *
 * @mixin \Eloquent
 */
class IndividualeRegionale extends Individuale
{
    use HasParent;

   

    /**
     * @return HasMany<self, $this>
     */
    public function mails(): HasMany
    {
        $stabi = request()->input('stabi', '');
        $repar = request()->input('repar', '');
        $this->anno = (int) request()->input('year', 0);

        return $this->hasMany(self::class, 'anno', 'anno')
            ->where('stabi', $stabi)
            ->where('repar', $repar);
    }
}
