<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

// --- traits ---
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
use Override;

/**
 * Modules\Performance\Models\Organizzativa.
 *
 * @property int $id
 * @property string|null $type
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
 * @property int $gg_ruolo
 * @property int|null $last_data_assunz
 * @property string|null $ore_assenza_anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $posiz_txt
 * @property int|null $clafun
 * @property int|null $disci1
 * @property string|null $disci1_txt
 * @property int|null $gg_assenza_dalal
 * @property float|null $hh_assenza_anno
 * @property float|null $hh_assenza_dalal
 * @property string|null $gg_parttimevert_anno
 * @property float|null $perc_parttimepond_anno
 * @property string|null $perc_parttimepond_dalal
 * @property string|null $gg_parttimevert_dalal
 * @property string|null $gg_presenza_dalal
 * @property string|null $perc_parttime_dalal
 * @property string|null $perc_parttime_anno
 * @property string|null $posizione_eco
 * @property float $gg_anno
 * @property float|null $tot Total value
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
 * @property mixed $codqua
 * @property mixed $cont
 * @property int|float $gg_p_time_vert_year
 * @property int|float $perc_p_time_daterange
 * @property int|float $perc_p_time_year
 * @property string|null $post_type
 * @property mixed $tipco
 * @property mixed $titolo_di_studio
 * @property Collection<int, MyLog> $mailInviate
 * @property int|null $mail_inviate_count
 * @property Collection<int, MyLog> $myLogs
 * @property int|null $my_logs_count
 * @property Collection<int, Option> $options
 * @property int|null $options_count
 * @property Collection<int, Organizzativa> $otherWinnerRows
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
 * @method static Builder|Organizzativa newModelQuery()
 * @method static Builder|Organizzativa newQuery()
 * @method static Builder|Organizzativa ofDate(int $date)
 * @method static Builder|Organizzativa ofEnteYear(int $ente, int $year)
 * @method static Builder|Organizzativa ofQuarter(int $quarter, int $year)
 * @method static Builder|Organizzativa ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Organizzativa ofYear(int $year)
 * @method static Builder|Organizzativa query()
 * @method static Builder|Organizzativa whereAl($value)
 * @method static Builder|Organizzativa whereAnno($value)
 * @method static Builder|Organizzativa whereArricchimentoProfessionale($value)
 * @method static Builder|Organizzativa whereBudgetAssegnato($value)
 * @method static Builder|Organizzativa whereCategCoeff($value)
 * @method static Builder|Organizzativa whereCategoriaEco($value)
 * @method static Builder|Organizzativa whereClafun($value)
 * @method static Builder|Organizzativa whereCognome($value)
 * @method static Builder|Organizzativa whereCreatedAt($value)
 * @method static Builder|Organizzativa whereCreatedBy($value)
 * @method static Builder|Organizzativa whereDal($value)
 * @method static Builder|Organizzativa whereDatemod($value)
 * @method static Builder|Organizzativa whereDecurtazionePerc($value)
 * @method static Builder|Organizzativa whereDisci($value)
 * @method static Builder|Organizzativa whereDisci1($value)
 * @method static Builder|Organizzativa whereDisci1Txt($value)
 * @method static Builder|Organizzativa whereDisciTxt($value)
 * @method static Builder|Organizzativa whereEmail($value)
 * @method static Builder|Organizzativa whereEnte($value)
 * @method static Builder|Organizzativa whereEsperienzaAcquisita($value)
 * @method static Builder|Organizzativa whereGgAnno($value)
 * @method static Builder|Organizzativa whereGgAssenzSigma($value)
 * @method static Builder|Organizzativa whereGgAssenzaAnno($value)
 * @method static Builder|Organizzativa whereGgAssenzaDalal($value)
 * @method static Builder|Organizzativa whereGgParttimevert($value)
 * @method static Builder|Organizzativa whereGgParttimevertAnno($value)
 * @method static Builder|Organizzativa whereGgParttimevertDalal($value)
 * @method static Builder|Organizzativa whereGgPosiz1InSede($value)
 * @method static Builder|Organizzativa whereGgPresenzaAnno($value)
 * @method static Builder|Organizzativa whereGgPresenzaDalal($value)
 * @method static Builder|Organizzativa whereGgRuolo($value)
 * @method static Builder|Organizzativa whereGgTempoDeterminato($value)
 * @method static Builder|Organizzativa whereGgTotaleSigma($value)
 * @method static Builder|Organizzativa whereGgValidiSigma($value)
 * @method static Builder|Organizzativa whereGiorniAssenza($value)
 * @method static Builder|Organizzativa whereGiorniPresenza($value)
 * @method static Builder|Organizzativa whereGiornitempodet($value)
 * @method static Builder|Organizzativa whereHaDiritto($value)
 * @method static Builder|Organizzativa whereHhAssenzaAnno($value)
 * @method static Builder|Organizzativa whereHhAssenzaDalal($value)
 * @method static Builder|Organizzativa whereId($value)
 * @method static Builder|Organizzativa whereImpegno($value)
 * @method static Builder|Organizzativa whereImportoTotale($value)
 * @method static Builder|Organizzativa whereLastDataAssunz($value)
 * @method static Builder|Organizzativa whereListaAuth($value)
 * @method static Builder|Organizzativa whereMatr($value)
 * @method static Builder|Organizzativa whereMotivo($value)
 * @method static Builder|Organizzativa whereNome($value)
 * @method static Builder|Organizzativa whereNote($value)
 * @method static Builder|Organizzativa whereOreAssenza($value)
 * @method static Builder|Organizzativa whereOreAssenzaAnno($value)
 * @method static Builder|Organizzativa whereOree($value)
 * @method static Builder|Organizzativa whereOret($value)
 * @method static Builder|Organizzativa wherePercParttime($value)
 * @method static Builder|Organizzativa wherePercParttimeAnno($value)
 * @method static Builder|Organizzativa wherePercParttimeDalal($value)
 * @method static Builder|Organizzativa wherePercParttimepond($value)
 * @method static Builder|Organizzativa wherePercParttimepondAnno($value)
 * @method static Builder|Organizzativa wherePercParttimepondDalal($value)
 * @method static Builder|Organizzativa wherePesoArricchimentoProfessionale($value)
 * @method static Builder|Organizzativa wherePesoEsperienzaAcquisita($value)
 * @method static Builder|Organizzativa wherePesoImpegno($value)
 * @method static Builder|Organizzativa wherePesoQualitaPrestazione($value)
 * @method static Builder|Organizzativa wherePesoRisultatiOttenuti($value)
 * @method static Builder|Organizzativa wherePosfun($value)
 * @method static Builder|Organizzativa wherePosiz($value)
 * @method static Builder|Organizzativa wherePosizTxt($value)
 * @method static Builder|Organizzativa wherePosizioneEco($value)
 * @method static Builder|Organizzativa wherePropro($value)
 * @method static Builder|Organizzativa whereQua2ka($value)
 * @method static Builder|Organizzativa whereQua2kd($value)
 * @method static Builder|Organizzativa whereQualitaPrestazione($value)
 * @method static Builder|Organizzativa whereQuotaEffettiva($value)
 * @method static Builder|Organizzativa whereQuotaTeorica($value)
 * @method static Builder|Organizzativa whereRep2ka($value)
 * @method static Builder|Organizzativa whereRep2kd($value)
 * @method static Builder|Organizzativa whereRepar($value)
 * @method static Builder|Organizzativa whereReparTxt($value)
 * @method static Builder|Organizzativa whereReparval($value)
 * @method static Builder|Organizzativa whereResti($value)
 * @method static Builder|Organizzativa whereRestiPond($value)
 * @method static Builder|Organizzativa whereRisultatiOttenuti($value)
 * @method static Builder|Organizzativa whereSchedaType($value)
 * @method static Builder|Organizzativa whereStabi($value)
 * @method static Builder|Organizzativa whereStabiTxt($value)
 * @method static Builder|Organizzativa whereStabival($value)
 * @method static Builder|Organizzativa whereTotalePunteggio($value)
 * @method static Builder|Organizzativa whereUpdatedAt($value)
 * @method static Builder|Organizzativa whereUpdatedBy($value)
 * @method static Builder|Organizzativa withDays(int $date_min, int $date_max)
 * @method static Builder|Organizzativa withTotPunt()
 *
 * @property int|null $valutatore_id
 * @property string|null $importo_totale_valutatore
 * @property string|null $resti_pond_valutatore
 * @property string|null $resti_pond_valutatore_id
 * @property string|null $importo_totale_valutatore_id
 * @property Collection<int, IndividualeAssenze> $assenze
 * @property int|null $assenze_count
 * @property Profile|null $creator
 * @property mixed $aventi_diritto
 * @property mixed $aventi_diritto_eff
 * @property string|null $categoria_ecoval
 * @property string|null $codice_fiscale
 * @property float|null $eta
 * @property int|null $excellences_count_last3years
 * @property int|null $gg_asz
 * @property int|null $gg_asz_cateco
 * @property int|null $gg_asz_cateco_fuori_sede
 * @property int|null $gg_asz_cateco_in_sede
 * @property int|null $gg_asz_cateco_posfun
 * @property int|null $gg_asz_cateco_posfun_fuori_sede
 * @property int|null $gg_asz_cateco_posfun_in_sede
 * @property int|null $gg_asz_fuori_sede
 * @property int|null $gg_asz_in_sede
 * @property int|null $gg_asz_tip_cod_escluso_subito
 * @property int|null $gg
 * @property int|null $gg_cateco
 * @property int|null $gg_cateco_fuori_sede
 * @property int|null $gg_cateco_in_sede
 * @property int|null $gg_cateco_no_asz
 * @property int|null $gg_cateco_no_posfun_no_asz
 * @property int|null $gg_cateco_posfun
 * @property int|null $gg_cateco_posfun_fuori_sede
 * @property int|null $gg_cateco_posfun_in_sede
 * @property int|null $gg_cateco_posfun_in_sede_no_asz
 * @property int|null $gg_cateco_posfun_no_asz
 * @property int|null $gg_cateco_sup
 * @property int|null $gg_cateco_sup_fuori_sede
 * @property int|null $gg_cateco_sup_in_sede
 * @property int|null $gg_fuori_sede
 * @property float|null $gg_fuori_sede_no_asz
 * @property int|null $gg_in_sede
 * @property float|null $gg_in_sede_no_asz
 * @property float|null $gg_no_asz
 * @property int|null $gg_posiz1_in_sede
 * @property int|null $hh_asz
 * @property int|null $hh_asz_fuori_sede
 * @property int|null $hh_asz_in_sede
 * @property float|null $importo_stipendio_annuo
 * @property string|null $inail
 * @property string|null $lista_propro
 * @property string|null $lista_propro_sup
 * @property float|null $perf_ind2014
 * @property float|null $perf_ind2015
 * @property float|null $perf_ind2016
 * @property float|null $perf_ind2017
 * @property float|null $perf_ind2018
 * @property float|null $perf_ind2019
 * @property float|null $perf_ind2020
 * @property float|null $perf_ind2021
 * @property float|null $perf_ind2022
 * @property float|null $perf_ind2023
 * @property float|null $perf_ind2024
 * @property float|null $perf_ind2025
 * @property float|null $perf_ind2026
 * @property float|null $perf_ind2027
 * @property float|null $perf_ind2028
 * @property float|null $perf_ind2029
 * @property float|null $perf_ind2030
 * @property int|null $perf_ind_count_last3_years
 * @property float|null $perf_ind_media
 * @property int $posfunval
 * @property int $posizione
 * @property float|null $ptime
 * @property float|null $punt_progressione_finale
 * @property string|null $sesso
 * @property float|null $totale_pond
 * @property float|null $valore_differenziale_rapportato_pt
 * @property string|null $valutatore_txt
 * @property Profile|null $updater
 *
 * @method static Builder<static>|Organizzativa ofEnte(int $ente)
 * @method static Builder<static>|Organizzativa ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder<static>|Organizzativa whereImportoTotaleValutatore($value)
 * @method static Builder<static>|Organizzativa whereImportoTotaleValutatoreId($value)
 * @method static Builder<static>|Organizzativa whereRestiPondValutatore($value)
 * @method static Builder<static>|Organizzativa whereRestiPondValutatoreId($value)
 * @method static Builder<static>|Organizzativa whereValutatoreId($value)
 *
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Asz00k1> $asz
 * @property-read int|null $asz_count
 * @property-read Collection<int, Asz00k1> $aszEff
 * @property-read int|null $asz_eff_count
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
 * @property-read Organizzativa|null $maxCatecoPosfun
 * @property-read Collection<int, Individuale> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @property-read Organizzativa|null $pesi
 * @property-read Organizzativa|null $stipendioTabellare
 * @property-read StabiDirigente|null $valutatore
 *
 * @method static \Modules\Performance\Database\Factories\OrganizzativaFactory factory($count = null, $state = [])
 * @method static Builder<static>|Organizzativa whereCategoriaEcoval($value)
 * @method static Builder<static>|Organizzativa wherePosfunval($value)
 * @method static Builder<static>|Organizzativa whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organizzativa withCalculatedData()
 *
 * @property-read CategoriaPropro|null $categoriaPropro
 *
 * @mixin \Eloquent
 */
/** @extends BaseIndividualeModel<self> */
class Organizzativa extends BaseIndividualeModel
{
    public string $from_field = 'dal';

    public string $to_field = 'al';

    protected $connection = 'performance';

    protected $table = 'performance_organizzativa';

    protected $fillable = [
        'id', 'ente', 'matr', 'cognome', 'nome', 'email', 'propro', 'posfun',
        'categoria_eco', 'posiz', 'posiz_txt', 'clafun', 'stabi', 'stabi_txt',
        'repar', 'repar_txt', 'stabival', 'reparval',
        'gg_fuori_sede', 'n_gg_fuori_sede', 'gg_aspettative_in_sede', 'gg_aspettative_fuori_sede',
        'gg_posiz_1_in_sede', 'gg_presenza_anno', 'gg_assenza_anno', 'rep003', 'disci1', 'disci1_txt',
        'rep2kd', 'rep2ka', 'qua2kd', 'qua2ka', 'st2kas', 'st2kdi', 'dal', 'al', 'gg', 'anno',
        'esperienza_acquisita', 'peso_esperienza_acquisita', 'risultati_ottenuti', 'peso_risultati_ottenuti',
        'arricchimento_professionale', 'peso_arricchimento_professionale', 'impegno', 'peso_impegno',
        'qualita_prestazione', 'peso_qualita_prestazione', 'totale', 'totale_pond',
        'ha_diritto', 'motivo', 'gg_aspettative_pond_in_sede', 'gg_aspettative_pond_fuori_sede',
        'categoria_ecoval', 'posfunval', 'gg_cateco_in_sede', 'gg_cateco_fuori_sede',
        'gg_cateco_posfun_in_sede', 'gg_cateco_posfun_fuori_sede', 'gg_cateco_no_posfun_in_sede', 'gg_cateco_no_posfun_fuori_sede',
        'gg_no_cateco_in_sede', 'gg_no_cateco_fuori_sede', 'gg_no_cateco_posfun_in_sede', 'gg_no_cateco_posfun_fuori_sede',
        'gg_tot_pond', 'asz2ka', 'gg_presenze_in_anno', 'gg_assenze_in_anno', 'ore_assenze_in_anno',
        'vincitore', 'last_data_assunz', 'type',
        'gg_assenza_dalal', 'hh_assenza_dalal', 'gg_presenza_dalal', 'perc_parttimepond_dalal',
        'gg_anno','valutatore_id',
        /*
        'gg_in_sede', 'n_gg_in_sede',
        */
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'id' => 'integer',
            'ente' => 'integer',
            'matr' => 'integer',
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
            'totale_punteggio' => 'float',
            'peso_esperienza_acquisita' => 'float',
            'peso_risultati_ottenuti' => 'float',
            'peso_arricchimento_professionale' => 'float',
            'peso_impegno' => 'float',
            'peso_qualita_prestazione' => 'float',
            'perc_parttime' => 'float',
            'perc_parttimepond' => 'float',
            'gg_parttimevert' => 'integer',
            'gg_tempo_determinato' => 'integer',
            'gg_posiz_1_in_sede' => 'integer',
            'gg_assenza_anno' => 'integer',
            'gg_presenza_anno' => 'integer',
            'gg_ruolo' => 'integer',
            'last_data_assunz' => 'integer',
            'clafun' => 'integer',
            'disci1' => 'integer',
            'gg_assenza_dalal' => 'integer',
            'hh_assenza_anno' => 'float',
            'hh_assenza_dalal' => 'float',
            'gg_parttimevert_anno' => 'integer',
            'perc_parttimepond_anno' => 'float',
            'perc_parttimepond_dalal' => 'float',
            'gg_parttimevert_dalal' => 'integer',
            'gg_presenza_dalal' => 'integer',
            'perc_parttime_dalal' => 'float',
            'perc_parttime_anno' => 'float',
            'gg_anno' => 'float',
        ]);
    }

    /**
     * @return HasMany<IndividualeAssenze, $this>
     */
    public function assenze(): HasMany
    {
        return $this->hasMany(IndividualeAssenze::class, 'anno', 'anno');
    }

    public function listaCodiciAspettative(): string
    {
        return $this->assenze()
            ->get()
            ->map(static fn ($item): string => $item->tipo.'-'.$item->codice)
            ->implode(',');
    }

    /**
     * @return HasMany<Asz00k1, $this>
     */
    public function aszEff(): HasMany
    {
        $lista_codici_aspettative = $this->listaCodiciAspettative();

        $asz = $this->asz()
            ->whereRaw('find_in_set(concat(asztip,"-",aszcod), ?)', [$lista_codici_aspettative]);

        return $asz;
    }

    /**
     * @return HasMany<Asz00k1, $this>
     */
    public function asz(): HasMany
    {
        $tbl = app(Asz00k1::class)->getTable();

        return $this->hasMany(Asz00k1::class, 'matr', 'matr')
            ->where($tbl.'.ente', $this->ente)
            ->where($tbl.'.aszann', '')
            ->where('asz2kd', '>', $this->getDateMin());
    }

    public function getDateMin(): int
    {
        return $this->anno * 10000 + 0101;
    }

    public function getDateMax(): int
    {
        return $this->anno * 10000 + 1231;
    }

    /**
     * @return HasMany<Individuale, $this>
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Individuale::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->where('anno', $this->anno);
    }

    /**
     * @return HasMany<CriteriEsclusione, static>
     */
    public function criteriEsclusione(): HasMany
    {
        // @phpstan-ignore-next-line
        return $this->hasMany(CriteriEsclusione::class, 'anno', 'anno');
    }

    /**
     * @return BelongsTo<CriteriMaggiorazione, static>
     */
    public function criteriMaggiorazione(): BelongsTo
    {
        // @phpstan-ignore-next-line
        return $this->belongsTo(CriteriMaggiorazione::class, 'organizzativa_id');
    }

    /**
     * @return HasMany<CriteriOption, $this>
     */
    public function criteriOptions(): HasMany
    {
        return $this->hasMany(CriteriOption::class, 'anno', 'anno');
    }

    /**
     * @return HasMany<MyLog, static>
     */
    public function mailInviate(): HasMany
    {
        // @phpstan-ignore-next-line
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')
            ->where('tbl', $this->getTable());
    }

    /**
     * @return HasMany<Option, $this>
     */
    public function options(): HasMany
    {
        return $this->hasMany(Option::class, 'anno', 'anno');
    }
}
