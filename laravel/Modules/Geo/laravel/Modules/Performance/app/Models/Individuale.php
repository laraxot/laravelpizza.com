<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Activity\Models\Activity;
use Modules\Progressioni\Models\Scheda;
use Modules\Ptv\Enums\WorkerType;
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
use Override;
use Parental\HasChildren;

/**
 * Modules\Performance\Models\Individuale.
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
 * @property Collection<int, MyLog> $myLogs
 * @property int|null $my_logs_count
 * @property Collection<int, Option> $options
 * @property int|null $options_count
 * @property Collection<int, Individuale> $otherWinnerRows
 * @property int|null $other_winner_rows_count
 * @property IndividualePesi|null $peso
 * @property IndividualePoPesi|null $pesoPo
 * @property Collection<int, Qua00f> $qua00f
 * @property int|null $qua00f_count
 * @property Collection<int, Qua00f> $qua00fDaterange
 * @property int|null $qua00f_daterange_count
 * @property Collection<int, Qua00f> $qua00fYear
 * @property int|null $qua00f_year_count
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
 * @method static Builder|Individuale newModelQuery()
 * @method static Builder|Individuale newQuery()
 * @method static Builder|BaseIndividualeModel ofDate(int $date)
 * @method static Builder|BaseIndividualeModel ofEnteYear(int $ente, int $year)
 * @method static Builder|BaseIndividualeModel ofQuarter(int $quarter, int $year)
 * @method static Builder|BaseIndividualeModel ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|BaseIndividualeModel ofYear(int $year)
 * @method static Builder|Individuale query()
 * @method static Builder|Individuale whereAl($value)
 * @method static Builder|Individuale whereAnno($value)
 * @method static Builder|Individuale whereArricchimentoProfessionale($value)
 * @method static Builder|Individuale whereBudgetAssegnato($value)
 * @method static Builder|Individuale whereCategCoeff($value)
 * @method static Builder|Individuale whereCategoriaEco($value)
 * @method static Builder|Individuale whereClafun($value)
 * @method static Builder|Individuale whereCodqua($value)
 * @method static Builder|Individuale whereCognome($value)
 * @method static Builder|Individuale whereCont($value)
 * @method static Builder|Individuale whereCreatedAt($value)
 * @method static Builder|Individuale whereCreatedBy($value)
 * @method static Builder|Individuale whereDal($value)
 * @method static Builder|Individuale whereDatemod($value)
 * @method static Builder|Individuale whereDecurtazionePerc($value)
 * @method static Builder|Individuale whereDisci($value)
 * @method static Builder|Individuale whereDisci1($value)
 * @method static Builder|Individuale whereDisci1Txt($value)
 * @method static Builder|Individuale whereDisciTxt($value)
 * @method static Builder|Individuale whereEmail($value)
 * @method static Builder|Individuale whereEnte($value)
 * @method static Builder|Individuale whereEsperienzaAcquisita($value)
 * @method static Builder|Individuale whereExcellence($value)
 * @method static Builder|Individuale whereGgAnno($value)
 * @method static Builder|Individuale whereGgAssenzSigma($value)
 * @method static Builder|Individuale whereGgAssenzaAnno($value)
 * @method static Builder|Individuale whereGgAssenzaDalal($value)
 * @method static Builder|Individuale whereGgParttimevert($value)
 * @method static Builder|Individuale whereGgParttimevertAnno($value)
 * @method static Builder|Individuale whereGgParttimevertDalal($value)
 * @method static Builder|Individuale whereGgPosiz1InSede($value)
 * @method static Builder|Individuale whereGgPresenzaAnno($value)
 * @method static Builder|Individuale whereGgPresenzaDalal($value)
 * @method static Builder|Individuale whereGgRuolo($value)
 * @method static Builder|Individuale whereGgTempoDeterminato($value)
 * @method static Builder|Individuale whereGgTotaleSigma($value)
 * @method static Builder|Individuale whereGgValidiSigma($value)
 * @method static Builder|Individuale whereGiorniAssenza($value)
 * @method static Builder|Individuale whereGiorniPresenza($value)
 * @method static Builder|Individuale whereGiornitempodet($value)
 * @method static Builder|Individuale whereHaDiritto($value)
 * @method static Builder|Individuale whereHhAssenzaAnno($value)
 * @method static Builder|Individuale whereHhAssenzaDalal($value)
 * @method static Builder|Individuale whereId($value)
 * @method static Builder|Individuale whereImpegno($value)
 * @method static Builder|Individuale whereImportoTotale($value)
 * @method static Builder|Individuale whereLang($value)
 * @method static Builder|Individuale whereLastDataAssunz($value)
 * @method static Builder|Individuale whereListaAuth($value)
 * @method static Builder|Individuale whereMatr($value)
 * @method static Builder|Individuale whereMotivo($value)
 * @method static Builder|Individuale whereNome($value)
 * @method static Builder|Individuale whereNote($value)
 * @method static Builder|Individuale whereOreAssenza($value)
 * @method static Builder|Individuale whereOreAssenzaAnno($value)
 * @method static Builder|Individuale whereOree($value)
 * @method static Builder|Individuale whereOret($value)
 * @method static Builder|Individuale wherePercParttime($value)
 * @method static Builder|Individuale wherePercParttimeAnno($value)
 * @method static Builder|Individuale wherePercParttimeDalal($value)
 * @method static Builder|Individuale wherePercParttimepond($value)
 * @method static Builder|Individuale wherePercParttimepondAnno($value)
 * @method static Builder|Individuale wherePercParttimepondDalal($value)
 * @method static Builder|Individuale wherePesoArricchimentoProfessionale($value)
 * @method static Builder|Individuale wherePesoEsperienzaAcquisita($value)
 * @method static Builder|Individuale wherePesoImpegno($value)
 * @method static Builder|Individuale wherePesoQualitaPrestazione($value)
 * @method static Builder|Individuale wherePesoRisultatiOttenuti($value)
 * @method static Builder|Individuale wherePosfun($value)
 * @method static Builder|Individuale wherePosiz($value)
 * @method static Builder|Individuale wherePosizTxt($value)
 * @method static Builder|Individuale wherePosizioneEco($value)
 * @method static Builder|Individuale wherePostType($value)
 * @method static Builder|Individuale wherePropro($value)
 * @method static Builder|Individuale whereQua2ka($value)
 * @method static Builder|Individuale whereQua2kd($value)
 * @method static Builder|Individuale whereQualitaPrestazione($value)
 * @method static Builder|Individuale whereQuotaEffettiva($value)
 * @method static Builder|Individuale whereQuotaTeorica($value)
 * @method static Builder|Individuale whereRep2ka($value)
 * @method static Builder|Individuale whereRep2kd($value)
 * @method static Builder|Individuale whereRepar($value)
 * @method static Builder|Individuale whereReparTxt($value)
 * @method static Builder|Individuale whereReparval($value)
 * @method static Builder|Individuale whereResti($value)
 * @method static Builder|Individuale whereRestiPond($value)
 * @method static Builder|Individuale whereRisultatiOttenuti($value)
 * @method static Builder|Individuale whereSchedaType($value)
 * @method static Builder|Individuale whereStabi($value)
 * @method static Builder|Individuale whereStabiTxt($value)
 * @method static Builder|Individuale whereStabival($value)
 * @method static Builder|Individuale whereTipco($value)
 * @method static Builder|Individuale whereTotalePunteggio($value)
 * @method static Builder|Individuale whereUpdatedAt($value)
 * @method static Builder|Individuale whereUpdatedBy($value)
 * @method static Builder|BaseIndividualeModel withDays(int $date_min, int $date_max)
 * @method static Builder|BaseIndividualeModel withTotPunt()
 *
 * @property int|null $assenze_aggiornate Flag per tracciamento aggiornamento assenze, vedi pipeline individuale
 * @property-read Profile|null $creator
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
 * @property mixed $fascia_punteggio Dynamic property from selectRaw queries
 * @property mixed $num_dipendenti Dynamic property from selectRaw queries
 * @property mixed $tot_resti_pond Dynamic property from selectRaw queries
 *
 * @method static Builder<static>|Individuale ofEnte(int $ente)
 * @method static Builder<static>|Individuale ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder<static>|Individuale whereAssenzeAggiornate($value)
 *
 * @property string|null $scheda_type
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Scheda> $avversari
 * @property-read int|null $avversari_count
 * @property-read Collection<int, Scheda> $avversariCategoriaEco
 * @property-read int|null $avversari_categoria_eco_count
 * @property-read Collection<int, CriteriValutazione> $criteriValutazioneOld
 * @property-read int|null $criteri_valutazione_old_count
 * @property-read Profile|null $deleter
 * @property-read string $from_field
 * @property-read float $gg_cateco_posfun_rapportato_max10_valutatore
 * @property-read int|null $gg_esperienza_no_asz
 * @property-read float|null $gg_integ_params_asz
 * @property-read string $to_field
 * @property-read Collection<int, Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read Individuale|null $maxCatecoPosfun
 * @property-read Collection<int, Individuale> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @property-read Individuale|null $pesi
 * @property-read Individuale|null $stipendioTabellare
 *
 * @method static Builder<static>|Individuale childrenWith(array $relations)
 * @method static Builder<static>|Individuale childrenWithCount(array $relations)
 * @method static \Modules\Performance\Database\Factories\IndividualeFactory factory($count = null, $state = [])
 * @method static Builder<static>|Individuale whereCategoriaEcoval($value)
 * @method static Builder<static>|Individuale wherePosfunval($value)
 * @method static Builder<static>|Individuale whereTitoloDiStudio($value)
 * @method static Builder<static>|Individuale whereType($value)
 * @method static Builder<static>|Individuale whereValutatoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Individuale withCalculatedData()
 *
 * @property-read CategoriaPropro|null $categoriaPropro
 *
 * @mixin \Eloquent
 */
/** @extends BaseIndividualeModel<self> */
class Individuale extends BaseIndividualeModel
{
    use HasChildren;

    /** @var string */
    protected $connection = 'performance';

    /** @var string */
    protected $table = 'performance_individuale';

    /** @var string */
    protected $childColumn = 'type';

    /** @var list<string> */
    protected $fillable = [
        'type', 'post_type', 'ente', 'matr', 'cognome', 'nome', 'email',
        'stabi', 'repar', 'stabival', 'reparval', 'stabi_txt', 'repar_txt',
        'disci', 'disci_txt', 'rep2kd', 'rep2ka', 'posiz', 'propro', 'posfun',
        'categoria_eco', 'qua2kd', 'qua2ka', 'dal', 'al', 'anno',
        'giornitempodet', 'ha_diritto', 'motivo', 'esperienza_acquisita',
        'risultati_ottenuti', 'arricchimento_professionale', 'impegno',
        'qualita_prestazione', 'totale_punteggio', 'lista_auth',
        'peso_esperienza_acquisita', 'peso_risultati_ottenuti',
        'peso_arricchimento_professionale', 'peso_impegno',
        'peso_qualita_prestazione', 'datemod', 'note', 'oree', 'oret',
        'perc_parttime', 'perc_parttimepond', 'gg_parttimevert', 'ore_assenza',
        'giorni_assenza', 'giorni_presenza', 'categ_coeff', 'quota_teorica',
        'budget_assegnato', 'quota_effettiva', 'resti', 'resti_pond',
        'importo_totale', 'gg_totale_sigma', 'gg_validi_sigma',
        'gg_assenz_sigma', 'decurtazione_perc', 'gg_tempo_determinato',
        'gg_posiz_1_in_sede', 'gg_assenza_anno', 'gg_presenza_anno',
        'ore_assenza_anno', 'created_by', 'updated_by', 'posiz_txt', 'clafun',
        'disci1', 'disci1_txt', 'gg_ruolo', 'last_data_assunz',
        'perc_parttime_anno', 'perc_parttime_dalal', 'gg_parttimevert_anno',
        'gg_parttimevert_dalal', 'perc_parttimepond_anno',
        'perc_parttimepond_dalal', 'gg_presenza_dalal', 'gg_assenza_dalal',
        'hh_assenza_anno', 'hh_assenza_dalal', 'lang', 'excellence', 'codqua',
        'cont', 'tipco', 'posizione_eco', 'gg_anno', 'valutatore_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    public function casts(): array
    {
        return [
            'stabi' => 'integer',
            'repar' => 'integer',
            'stabival' => 'integer',
            'reparval' => 'integer',
            'disci' => 'integer',
            'rep2kd' => 'integer',
            'rep2ka' => 'integer',
            'posiz' => 'integer',
            'propro' => 'integer',
            'posfun' => 'integer',
            'qua2kd' => 'integer',
            'qua2ka' => 'integer',
            'dal' => 'integer',
            'al' => 'integer',
            'anno' => 'integer',
            'giornitempodet' => 'integer',
            'ha_diritto' => 'integer',
            'gg_parttimevert' => 'integer',
            'gg_tempo_determinato' => 'integer',
            'gg_posiz_1_in_sede' => 'integer',
            'gg_assenza_anno' => 'integer',
            'gg_presenza_anno' => 'integer',
            'gg_ruolo' => 'integer',
            'last_data_assunz' => 'integer',
            'gg_parttimevert_anno' => 'integer',
            'gg_parttimevert_dalal' => 'integer',
            'gg_presenza_dalal' => 'integer',
            'gg_assenza_dalal' => 'integer',
            'hh_assenza_anno' => 'float',
            'hh_assenza_dalal' => 'float',
            'codqua' => 'integer',
            'cont' => 'integer',
            'tipco' => 'integer',
            'gg_anno' => 'float',
            'peso_esperienza_acquisita' => 'float',
            'peso_risultati_ottenuti' => 'float',
            'peso_arricchimento_professionale' => 'float',
            'peso_impegno' => 'float',
            'peso_qualita_prestazione' => 'float',
            'totale_punteggio' => 'float',
            'perc_parttime' => 'float',
            'perc_parttime_anno' => 'float',
            'perc_parttime_dalal' => 'float',
            'perc_parttimepond_anno' => 'float',
            'perc_parttimepond_dalal' => 'float',
        ];
    }

    /** @var array<string, class-string> */
    protected array $childTypes = [
        'po' => IndividualePo::class,
        'dip' => IndividualeDip::class,
        'regionale' => IndividualeRegionale::class,
        'individuale_regionale' => IndividualeRegionale::class,
        'dirigente' => IndividualeDirigente::class,
    ];

    /**
     * Accessor per il tipo di lavoratore.
     */
    public function getTypeAttribute(?string $value): ?\Modules\Ptv\Enums\WorkerType
    {
        return $value ? \Modules\Ptv\Enums\WorkerType::tryFrom($value) : null;
    }
}
