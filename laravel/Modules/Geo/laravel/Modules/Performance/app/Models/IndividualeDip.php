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
 * Modules\Performance\Models\IndividualeDip.
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
 * @property Collection<int, Sto00f> $Sto00fYear
 * @property int|null $sto00f_year_count
 * @property Collection<int, Ana02f> $ana02f
 * @property int|null $ana02f_count
 * @property Ana10f|null $ana10f
 * @property Anag|null $anag
 * @property Collection<int, Asz00f> $asz00f
 * @property int|null $asz00f_count
 * @property Collection<int, Asz00k1> $asz00k1
 * @property int|null $asz00k1_count
 * @property Collection<int, Asz00k1> $asz00k1Year
 * @property int|null $asz00k1_year_count
 * @property Collection<int, Individuale> $cards
 * @property int|null $cards_count
 * @property Collection<int, IndividualeAssenze> $codiciAssenze
 * @property int|null $codici_assenze_count
 * @property Collection<int, CriteriEsclusione> $criteriEsclusione
 * @property int|null $criteri_esclusione_count
 * @property CriteriMaggiorazione|null $criteriMaggiorazione
 * @property Collection<int, CriteriOption> $criteriOptions
 * @property int|null $criteri_options_count
 * @property Collection<int, CriteriValutazione> $criteriValutazione
 * @property int|null $criteri_valutazione_count
 * @property int|float $gg_p_time_vert_year
 * @property int|float $perc_p_time_daterange
 * @property int|float $perc_p_time_year
 * @property mixed $titolo_di_studio
 * @property Collection<int, MyLog> $mailInviate
 * @property int|null $mail_inviate_count
 * @property Collection<int, IndividualeDip> $mails
 * @property int|null $mails_count
 * @property Collection<int, MyLog> $myLogs
 * @property int|null $my_logs_count
 * @property Collection<int, Option> $options
 * @property int|null $options_count
 * @property Collection<int, IndividualeDip> $otherWinnerRows
 * @property int|null $other_winner_rows_count
 * @property IndividualePesi|null $peso
 * @property IndividualePoPesi|null $pesoPo
 * @property Collection<int, Qua00f> $qua00f
 * @property int|null $qua00f_count
 * @property Collection<int, Qua00f> $qua00fDaterange
 * @property int|null $qua00f_daterange_count
 * @property Collection<int, Qua03f> $qua03f
 * @property int|null $qua03f_count
 * @property Collection<int, Rep00f> $rep00f
 * @property int|null $rep00f_count
 * @property Collection<int, Repart> $reparts
 * @property int|null $reparts_count
 * @property StabiDirigente|null $stabiDirigente
 * @property Collection<int, Sto00f> $sto00f
 * @property int|null $sto00f_count
 * @property IndividualeTotStabi|null $totStabi
 * @property Tqu00f|null $tqu00f
 * @property Collection<int, Wstr01lx> $wstr01lx
 * @property int|null $wstr01lx_count
 * @property Collection<int, Wstr01lx> $wstr01lxYear
 * @property int|null $wstr01lx_year_count
 *
 * @method static Builder|IndividualeDip newModelQuery()
 * @method static Builder|IndividualeDip newQuery()
 * @method static Builder<self>|BaseIndividualeModel<self> ofDate(int $date)
 * @method static Builder<self>|BaseIndividualeModel<self> ofEnteYear(int $ente, int $year)
 * @method static Builder<self>|BaseIndividualeModel<self> ofQuarter(int $quarter, int $year)
 * @method static Builder<self>|BaseIndividualeModel<self> ofRangeDate(int $date_start, int $date_end)
 * @method static Builder<self>|BaseIndividualeModel<self> ofYear(int $year)
 * @method static Builder|IndividualeDip query()
 * @method static Builder|IndividualeDip whereAl($value)
 * @method static Builder|IndividualeDip whereAnno($value)
 * @method static Builder|IndividualeDip whereArricchimentoProfessionale($value)
 * @method static Builder|IndividualeDip whereBudgetAssegnato($value)
 * @method static Builder|IndividualeDip whereCategCoeff($value)
 * @method static Builder|IndividualeDip whereCategoriaEco($value)
 * @method static Builder|IndividualeDip whereClafun($value)
 * @method static Builder|IndividualeDip whereCodqua($value)
 * @method static Builder|IndividualeDip whereCognome($value)
 * @method static Builder|IndividualeDip whereCont($value)
 * @method static Builder|IndividualeDip whereCreatedAt($value)
 * @method static Builder|IndividualeDip whereCreatedBy($value)
 * @method static Builder|IndividualeDip whereDal($value)
 * @method static Builder|IndividualeDip whereDatemod($value)
 * @method static Builder|IndividualeDip whereDecurtazionePerc($value)
 * @method static Builder|IndividualeDip whereDisci($value)
 * @method static Builder|IndividualeDip whereDisci1($value)
 * @method static Builder|IndividualeDip whereDisci1Txt($value)
 * @method static Builder|IndividualeDip whereDisciTxt($value)
 * @method static Builder|IndividualeDip whereEmail($value)
 * @method static Builder|IndividualeDip whereEnte($value)
 * @method static Builder|IndividualeDip whereEsperienzaAcquisita($value)
 * @method static Builder|IndividualeDip whereExcellence($value)
 * @method static Builder|IndividualeDip whereGgAnno($value)
 * @method static Builder|IndividualeDip whereGgAssenzSigma($value)
 * @method static Builder|IndividualeDip whereGgAssenzaAnno($value)
 * @method static Builder|IndividualeDip whereGgAssenzaDalal($value)
 * @method static Builder|IndividualeDip whereGgParttimevert($value)
 * @method static Builder|IndividualeDip whereGgParttimevertAnno($value)
 * @method static Builder|IndividualeDip whereGgParttimevertDalal($value)
 * @method static Builder|IndividualeDip whereGgPosiz1InSede($value)
 * @method static Builder|IndividualeDip whereGgPresenzaAnno($value)
 * @method static Builder|IndividualeDip whereGgPresenzaDalal($value)
 * @method static Builder|IndividualeDip whereGgRuolo($value)
 * @method static Builder|IndividualeDip whereGgTempoDeterminato($value)
 * @method static Builder|IndividualeDip whereGgTotaleSigma($value)
 * @method static Builder|IndividualeDip whereGgValidiSigma($value)
 * @method static Builder|IndividualeDip whereGiorniAssenza($value)
 * @method static Builder|IndividualeDip whereGiorniPresenza($value)
 * @method static Builder|IndividualeDip whereGiornitempodet($value)
 * @method static Builder|IndividualeDip whereHaDiritto($value)
 * @method static Builder|IndividualeDip whereHhAssenzaAnno($value)
 * @method static Builder|IndividualeDip whereHhAssenzaDalal($value)
 * @method static Builder|IndividualeDip whereId($value)
 * @method static Builder|IndividualeDip whereImpegno($value)
 * @method static Builder|IndividualeDip whereImportoTotale($value)
 * @method static Builder|IndividualeDip whereLang($value)
 * @method static Builder|IndividualeDip whereLastDataAssunz($value)
 * @method static Builder|IndividualeDip whereListaAuth($value)
 * @method static Builder|IndividualeDip whereMatr($value)
 * @method static Builder|IndividualeDip whereMotivo($value)
 * @method static Builder|IndividualeDip whereNome($value)
 * @method static Builder|IndividualeDip whereNote($value)
 * @method static Builder|IndividualeDip whereOreAssenza($value)
 * @method static Builder|IndividualeDip whereOreAssenzaAnno($value)
 * @method static Builder|IndividualeDip whereOree($value)
 * @method static Builder|IndividualeDip whereOret($value)
 * @method static Builder|IndividualeDip wherePercParttime($value)
 * @method static Builder|IndividualeDip wherePercParttimeAnno($value)
 * @method static Builder|IndividualeDip wherePercParttimeDalal($value)
 * @method static Builder|IndividualeDip wherePercParttimepond($value)
 * @method static Builder|IndividualeDip wherePercParttimepondAnno($value)
 * @method static Builder|IndividualeDip wherePercParttimepondDalal($value)
 * @method static Builder|IndividualeDip wherePesoArricchimentoProfessionale($value)
 * @method static Builder|IndividualeDip wherePesoEsperienzaAcquisita($value)
 * @method static Builder|IndividualeDip wherePesoImpegno($value)
 * @method static Builder|IndividualeDip wherePesoQualitaPrestazione($value)
 * @method static Builder|IndividualeDip wherePesoRisultatiOttenuti($value)
 * @method static Builder|IndividualeDip wherePosfun($value)
 * @method static Builder|IndividualeDip wherePosiz($value)
 * @method static Builder|IndividualeDip wherePosizTxt($value)
 * @method static Builder|IndividualeDip wherePosizioneEco($value)
 * @method static Builder|IndividualeDip wherePostType($value)
 * @method static Builder|IndividualeDip wherePropro($value)
 * @method static Builder|IndividualeDip whereQua2ka($value)
 * @method static Builder|IndividualeDip whereQua2kd($value)
 * @method static Builder|IndividualeDip whereQualitaPrestazione($value)
 * @method static Builder|IndividualeDip whereQuotaEffettiva($value)
 * @method static Builder|IndividualeDip whereQuotaTeorica($value)
 * @method static Builder|IndividualeDip whereRep2ka($value)
 * @method static Builder|IndividualeDip whereRep2kd($value)
 * @method static Builder|IndividualeDip whereRepar($value)
 * @method static Builder|IndividualeDip whereReparTxt($value)
 * @method static Builder|IndividualeDip whereReparval($value)
 * @method static Builder|IndividualeDip whereResti($value)
 * @method static Builder|IndividualeDip whereRestiPond($value)
 * @method static Builder|IndividualeDip whereRisultatiOttenuti($value)
 * @method static Builder|IndividualeDip whereSchedaType($value)
 * @method static Builder|IndividualeDip whereStabi($value)
 * @method static Builder|IndividualeDip whereStabiTxt($value)
 * @method static Builder|IndividualeDip whereStabival($value)
 * @method static Builder|IndividualeDip whereTipco($value)
 * @method static Builder|IndividualeDip whereTotalePunteggio($value)
 * @method static Builder|IndividualeDip whereUpdatedAt($value)
 * @method static Builder|IndividualeDip whereUpdatedBy($value)
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
 * @method static Builder<static>|IndividualeDip ofEnte(int $ente)
 * @method static Builder<static>|IndividualeDip ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder<static>|IndividualeDip whereAssenzeAggiornate($value)
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
 * @property-read IndividualeDip|null $maxCatecoPosfun
 * @property-read Collection<int, Individuale> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @property-read IndividualeDip|null $pesi
 * @property-read Collection<int, Qua00f> $qua00fYear
 * @property-read int|null $qua00f_year_count
 * @property-read IndividualeDip|null $stipendioTabellare
 *
 * @method static Builder<static>|IndividualeDip childrenWith(array<int, mixed> $relations)
 * @method static Builder<static>|IndividualeDip childrenWithCount(array<int, mixed> $relations)
 * @method static \Modules\Performance\Database\Factories\IndividualeDipFactory factory($count = null, $state = [])
 * @method static Builder<static>|IndividualeDip whereCategoriaEcoval($value)
 * @method static Builder<static>|IndividualeDip wherePosfunval($value)
 * @method static Builder<static>|IndividualeDip whereTitoloDiStudio($value)
 * @method static Builder<static>|IndividualeDip whereType($value)
 * @method static Builder<static>|IndividualeDip whereValutatoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualeDip withCalculatedData()
 *
 * @property-read CategoriaPropro|null $categoriaPropro
 *
 * @mixin \Eloquent
 */
class IndividualeDip extends Individuale
{
    use HasParent;

    
    public string $from_field = 'dal';

    public string $to_field = 'al';

    /**
     * @return HasMany<self, $this>
     */
    public function mails(): HasMany
    {
        $stabi = request()->input('stabi', '');
        $repar = request()->input('repar', '');
        $year = request()->input('year', '');
        $this->anno = is_numeric($year) ? (int) $year : null;

        return $this->hasMany(self::class, 'anno', 'anno')
            ->where('stabi', $stabi)
            ->where('repar', $repar)
            ->where('ha_diritto', 1)
            ->where('post_type', 'individuale_dip')
            ->where('totale_punteggio', '>', 0);
    }
}
