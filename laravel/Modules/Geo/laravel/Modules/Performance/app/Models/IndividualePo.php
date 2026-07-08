<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

// ---------- models -------
// ----------traits ---
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
// ---- services ---
// passare ad arrayservice
use Modules\Sigma\Models\Tqu00f;
use Modules\Sigma\Models\Traits\SigmaModelTrait;
use Modules\Sigma\Models\Wstr01lx;
use Modules\Xot\Traits\Updater;
use Parental\HasParent;

/**
 * Modules\Performance\Models\IndividualePo.
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
 * @property-read Collection<int, IndividualePo> $mails
 * @property-read int|null $mails_count
 * @property-read Collection<int, MyLog> $myLogs
 * @property-read int|null $my_logs_count
 * @property-read Collection<int, Option> $options
 * @property-read int|null $options_count
 * @property-read Collection<int, IndividualePo> $otherWinnerRows
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
 * @method static Builder|IndividualePo newModelQuery()
 * @method static Builder|IndividualePo newQuery()
 * @method static Builder<self>|BaseIndividualeModel<self> ofDate(int $date)
 * @method static Builder<self>|BaseIndividualeModel<self> ofEnteYear(int $ente, int $year)
 * @method static Builder<self>|BaseIndividualeModel<self> ofQuarter(int $quarter, int $year)
 * @method static Builder<self>|BaseIndividualeModel<self> ofRangeDate(int $date_start, int $date_end)
 * @method static Builder<self>|BaseIndividualeModel<self> ofYear(int $year)
 * @method static Builder|IndividualePo query()
 * @method static Builder|IndividualePo whereAl($value)
 * @method static Builder|IndividualePo whereAnno($value)
 * @method static Builder|IndividualePo whereArricchimentoProfessionale($value)
 * @method static Builder|IndividualePo whereBudgetAssegnato($value)
 * @method static Builder|IndividualePo whereCategCoeff($value)
 * @method static Builder|IndividualePo whereCategoriaEco($value)
 * @method static Builder|IndividualePo whereClafun($value)
 * @method static Builder|IndividualePo whereCodqua($value)
 * @method static Builder|IndividualePo whereCognome($value)
 * @method static Builder|IndividualePo whereCont($value)
 * @method static Builder|IndividualePo whereCreatedAt($value)
 * @method static Builder|IndividualePo whereCreatedBy($value)
 * @method static Builder|IndividualePo whereDal($value)
 * @method static Builder|IndividualePo whereDatemod($value)
 * @method static Builder|IndividualePo whereDecurtazionePerc($value)
 * @method static Builder|IndividualePo whereDisci($value)
 * @method static Builder|IndividualePo whereDisci1($value)
 * @method static Builder|IndividualePo whereDisci1Txt($value)
 * @method static Builder|IndividualePo whereDisciTxt($value)
 * @method static Builder|IndividualePo whereEmail($value)
 * @method static Builder|IndividualePo whereEnte($value)
 * @method static Builder|IndividualePo whereEsperienzaAcquisita($value)
 * @method static Builder|IndividualePo whereExcellence($value)
 * @method static Builder|IndividualePo whereGgAnno($value)
 * @method static Builder|IndividualePo whereGgAssenzSigma($value)
 * @method static Builder|IndividualePo whereGgAssenzaAnno($value)
 * @method static Builder|IndividualePo whereGgAssenzaDalal($value)
 * @method static Builder|IndividualePo whereGgParttimevert($value)
 * @method static Builder|IndividualePo whereGgParttimevertAnno($value)
 * @method static Builder|IndividualePo whereGgParttimevertDalal($value)
 * @method static Builder|IndividualePo whereGgPosiz1InSede($value)
 * @method static Builder|IndividualePo whereGgPresenzaAnno($value)
 * @method static Builder|IndividualePo whereGgPresenzaDalal($value)
 * @method static Builder|IndividualePo whereGgRuolo($value)
 * @method static Builder|IndividualePo whereGgTempoDeterminato($value)
 * @method static Builder|IndividualePo whereGgTotaleSigma($value)
 * @method static Builder|IndividualePo whereGgValidiSigma($value)
 * @method static Builder|IndividualePo whereGiorniAssenza($value)
 * @method static Builder|IndividualePo whereGiorniPresenza($value)
 * @method static Builder|IndividualePo whereGiornitempodet($value)
 * @method static Builder|IndividualePo whereHaDiritto($value)
 * @method static Builder|IndividualePo whereHhAssenzaAnno($value)
 * @method static Builder|IndividualePo whereHhAssenzaDalal($value)
 * @method static Builder|IndividualePo whereId($value)
 * @method static Builder|IndividualePo whereImpegno($value)
 * @method static Builder|IndividualePo whereImportoTotale($value)
 * @method static Builder|IndividualePo whereLang($value)
 * @method static Builder|IndividualePo whereLastDataAssunz($value)
 * @method static Builder|IndividualePo whereListaAuth($value)
 * @method static Builder|IndividualePo whereMatr($value)
 * @method static Builder|IndividualePo whereMotivo($value)
 * @method static Builder|IndividualePo whereNome($value)
 * @method static Builder|IndividualePo whereNote($value)
 * @method static Builder|IndividualePo whereOreAssenza($value)
 * @method static Builder|IndividualePo whereOreAssenzaAnno($value)
 * @method static Builder|IndividualePo whereOree($value)
 * @method static Builder|IndividualePo whereOret($value)
 * @method static Builder|IndividualePo wherePercParttime($value)
 * @method static Builder|IndividualePo wherePercParttimeAnno($value)
 * @method static Builder|IndividualePo wherePercParttimeDalal($value)
 * @method static Builder|IndividualePo wherePercParttimepond($value)
 * @method static Builder|IndividualePo wherePercParttimepondAnno($value)
 * @method static Builder|IndividualePo wherePercParttimepondDalal($value)
 * @method static Builder|IndividualePo wherePesoArricchimentoProfessionale($value)
 * @method static Builder|IndividualePo wherePesoEsperienzaAcquisita($value)
 * @method static Builder|IndividualePo wherePesoImpegno($value)
 * @method static Builder|IndividualePo wherePesoQualitaPrestazione($value)
 * @method static Builder|IndividualePo wherePesoRisultatiOttenuti($value)
 * @method static Builder|IndividualePo wherePosfun($value)
 * @method static Builder|IndividualePo wherePosiz($value)
 * @method static Builder|IndividualePo wherePosizTxt($value)
 * @method static Builder|IndividualePo wherePosizioneEco($value)
 * @method static Builder|IndividualePo wherePostType($value)
 * @method static Builder|IndividualePo wherePropro($value)
 * @method static Builder|IndividualePo whereQua2ka($value)
 * @method static Builder|IndividualePo whereQua2kd($value)
 * @method static Builder|IndividualePo whereQualitaPrestazione($value)
 * @method static Builder|IndividualePo whereQuotaEffettiva($value)
 * @method static Builder|IndividualePo whereQuotaTeorica($value)
 * @method static Builder|IndividualePo whereRep2ka($value)
 * @method static Builder|IndividualePo whereRep2kd($value)
 * @method static Builder|IndividualePo whereRepar($value)
 * @method static Builder|IndividualePo whereReparTxt($value)
 * @method static Builder|IndividualePo whereReparval($value)
 * @method static Builder|IndividualePo whereResti($value)
 * @method static Builder|IndividualePo whereRestiPond($value)
 * @method static Builder|IndividualePo whereRisultatiOttenuti($value)
 * @method static Builder|IndividualePo whereSchedaType($value)
 * @method static Builder|IndividualePo whereStabi($value)
 * @method static Builder|IndividualePo whereStabiTxt($value)
 * @method static Builder|IndividualePo whereStabival($value)
 * @method static Builder|IndividualePo whereTipco($value)
 * @method static Builder|IndividualePo whereTotalePunteggio($value)
 * @method static Builder|IndividualePo whereUpdatedAt($value)
 * @method static Builder|IndividualePo whereUpdatedBy($value)
 * @method static Builder<self>|BaseIndividualeModel<self> withDays(int $date_min, int $date_max)
 * @method static Builder<self>|BaseIndividualeModel<self> withTotPunt()
 *
 * @property int|null $assenze_aggiornate Flag per tracciamento aggiornamento assenze, vedi pipeline individuale
 * @property-read Profile|null $creator
 * @property-read Collection<int, CriteriValutazione> $criteriValutazioneOld
 * @property-read int|null $criteri_valutazione_old_count
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
 * @method static Builder<static>|IndividualePo ofEnte(int $ente)
 * @method static Builder<static>|IndividualePo ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder<static>|IndividualePo whereAssenzeAggiornate($value)
 *
 * @property string|null $scheda_type
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Scheda> $avversari
 * @property-read int|null $avversari_count
 * @property-read Collection<int, Scheda> $avversariCategoriaEco
 * @property-read int|null $avversari_categoria_eco_count
 * @property-read Profile|null $deleter
 * @property-read int|null $aventi_diritto
 * @property-read int|null $aventi_diritto_eff
 * @property-read string $from_field
 * @property-read float $gg_cateco_posfun_rapportato_max10_valutatore
 * @property-read int|null $gg_esperienza_no_asz
 * @property-read float|null $gg_integ_params_asz
 * @property-read string $to_field
 * @property-read Collection<int, Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read IndividualePo|null $maxCatecoPosfun
 * @property-read Collection<int, Individuale> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @property-read IndividualePo|null $pesi
 * @property-read Collection<int, Qua00f> $qua00fYear
 * @property-read int|null $qua00f_year_count
 * @property-read IndividualePo|null $stipendioTabellare
 *
 * @method static Builder<static>|IndividualePo childrenWith(array<int, mixed> $relations)
 * @method static Builder<static>|IndividualePo childrenWithCount(array<int, mixed> $relations)
 * @method static \Modules\Performance\Database\Factories\IndividualePoFactory factory($count = null, $state = [])
 * @method static Builder<static>|IndividualePo whereCategoriaEcoval($value)
 * @method static Builder<static>|IndividualePo wherePosfunval($value)
 * @method static Builder<static>|IndividualePo whereTitoloDiStudio($value)
 * @method static Builder<static>|IndividualePo whereType($value)
 * @method static Builder<static>|IndividualePo whereValutatoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualePo withCalculatedData()
 *
 * @property-read CategoriaPropro|null $categoriaPropro
 *
 * @mixin \Eloquent
 */
class IndividualePo extends Individuale
{
    use HasParent;

  

    public string $from_field = 'dal';

    public string $to_field = 'al';

    /*
    use Updater;
    use SigmaModelTrait;
    use Traits\RelationshipTrait;
    use Traits\MutatorTrait;

    protected $connection = 'performance'; // this will use the specified database connection
    protected $table = 'performance_individuale';
    //public $timestamps= false;
    protected $fillable = ['id', 'ente', 'matr', 'cognome', 'nome', 'email', 'propro',
    'posfun', 'categoria_eco', 'posiz', 'posiz_txt', 'clafun', 'stabi', 'stabi_txt',
    'repar', 'repar_txt', 'stabival', 'reparval', 'indir', 'gg_in_sede', 'n_gg_in_sede',
    'gg_fuori_sede', 'n_gg_fuori_sede', 'gg_aspettative_in_sede', 'gg_aspettative_fuori_sede',
     'gg_posiz_1_in_sede', 'gg_presenza_anno', 'gg_assenza_anno', 'rep003', 'disci1', 'disci1_txt',
      'rep2kd', 'rep2ka', 'qua2kd', 'qua2ka', 'st2kas', 'st2kdi', 'dal', 'al', 'gg', 'anno',
      'esperienza_acquisita', 'peso_esperienza_acquisita', 'risultati_ottenuti', 'peso_risultati_ottenuti',
      'arricchimento_professionale', 'peso_arricchimento_professionale', 'impegno', 'peso_impegno',
      'qualita_prestazione', 'peso_qualita_prestazione', 'totale', 'totale_pond',
      'ha_diritto', 'motivo', 'gg_aspettative_pond_in_sede',
      'gg_aspettative_pond_fuori_sede', 'categoria_ecoval', 'posfunval', 'gg_cateco_in_sede',
       'gg_cateco_fuori_sede', 'gg_cateco_posfun_in_sede', 'gg_cateco_posfun_fuori_sede',
       'gg_cateco_no_posfun_in_sede', 'gg_cateco_no_posfun_fuori_sede', 'gg_no_cateco_in_sede',
        'gg_no_cateco_fuori_sede', 'gg_no_cateco_posfun_in_sede', 'gg_no_cateco_posfun_fuori_sede', 'gg_tot_pond',
    'asz2ka', 'gg_presenze_in_anno', 'gg_assenze_in_anno', 'ore_assenze_in_anno', 'vincitore'
    ,'excellence',
];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    */
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
            ->where('post_type', 'individuale_po');
        // ->where('posfun', '>=', 100)
        //    ->where('totale_punteggio','>',0)
    }
}
