<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Modules\IndennitaResponsabilita\Models\Traits\FunctionTrait;
use Modules\IndennitaResponsabilita\Models\Traits\RelationshipTrait;
use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Models\Profile;
use Modules\Rating\Models\Traits\HasRatingsTrait;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Wstr01lx;

/**
 * Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $email
 * @property int|null $stabi
 * @property int|null $repar
 * @property string|null $stabi_txt
 * @property string|null $repar_txt
 * @property int|null $rep2kd
 * @property int|null $rep2ka
 * @property int|null $propro
 * @property int|null $posfun
 * @property string|null $despro
 * @property int|null $posiz
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property int|null $tipco
 * @property int|null $codqua
 * @property string|null $qualifica
 * @property int|null $anno
 * @property float|null $perc_p_time_year
 * @property Carbon|null $dal
 * @property Carbon|null $al
 * @property int|null $dalx
 * @property int|null $alx
 * @property string|null $dalf dal retribuzione
 * @property string|null $alf al retribuzione
 * @property string|null $dali
 * @property string|null $ali
 * @property int|null $anno
 * @property int|null $id_quale
 * @property string|null $posizione_lavoro
 * @property int|null $complessita
 * @property int|null $coordinamento
 * @property int|null $responsabilita
 * @property int|null $tot
 * @property string|null $valore_economico_calcolato
 * @property string|null $valore_economico_attribuito
 * @property string|null $archivista_informatico
 * @property string|null $relazioni_pubblico
 * @property string|null $protezione_civile
 * @property string|null $formatore_professionale
 * @property string|null $ha_diritto
 * @property string|null $motivo_escluso
 * @property string|null $datemod
 * @property string|null $handle
 * @property int|null $last_stato
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @property string $categoria_eco
 * @property string $posiz_txt
 * @property string $lang
 * @property int|null $disci1
 * @property int|null $valutatore_id
 * @property Carbon|null $dal
 * @property Carbon|null $al
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
 * @property int|float $gg_p_time_vert_year
 * @property mixed $gg_parttimevert_anno
 * @property int|null $gg_parttimevert
 * @property mixed $last_data_assunz
 * @property int|float $perc_p_time_year
 * @property mixed $perc_parttime_anno
 * @property float|null $perc_parttime
 * @property mixed $titolo_di_studio
 * @property Collection<int, IndennitaResponsabilita> $mails
 * @property int|null $mails_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Message> $messages
 * @property int|null $messages_count
 * @property Collection<int, MyLog> $myLogs
 * @property int|null $my_logs_count
 * @property Collection<int, Qua00f> $qua00f
 * @property int|null $qua00f_count
 * @property Collection<int, Qua00f> $qua00fYear
 * @property int|null $qua00f_year_count
 * @property Collection<int, Qua03f> $qua03f
 * @property int|null $qua03f_count
 * @property Collection<int, Rating> $ratings
 * @property int|null $ratings_count
 * @property Collection<int, Rep00f> $rep00f
 * @property int|null $rep00f_count
 * @property StabiDirigente|null $stabiDirigente
 * @property Collection<int, Sto00f> $sto00f
 * @property int|null $sto00f_count
 * @property StabiDirigente|null $valutatore
 * @property Collection<int, Wstr01lx> $wstr01lx
 * @property int|null $wstr01lx_count
 * @property Collection<int, Wstr01lx> $wstr01lxYear
 * @property int|null $wstr01lx_year_count
 * @method static Builder|IndennitaResponsabilita newModelQuery()
 * @method static Builder|IndennitaResponsabilita newQuery()
 * @method static Builder|IndennitaResponsabilita ofDate(int $date)
 * @method static Builder|IndennitaResponsabilita ofEnteYear(int $ente, int $year)
 * @method static Builder|IndennitaResponsabilita ofQuarter(int $quarter, int $year)
 * @method static Builder|IndennitaResponsabilita ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|IndennitaResponsabilita ofYear(int $year)
 * @method static Builder|IndennitaResponsabilita query()
 * @method static Builder|IndennitaResponsabilita whereAl($value)
 * @method static Builder|IndennitaResponsabilita whereAlf($value)
 * @method static Builder|IndennitaResponsabilita whereAli($value)
 * @method static Builder|IndennitaResponsabilita whereAlx($value)
 * @method static Builder|IndennitaResponsabilita whereAnno($value)
 * @method static Builder|IndennitaResponsabilita whereArchivistaInformatico($value)
 * @method static Builder|IndennitaResponsabilita whereCategoriaEco($value)
 * @method static Builder|IndennitaResponsabilita whereCodqua($value)
 * @method static Builder|IndennitaResponsabilita whereCognome($value)
 * @method static Builder|IndennitaResponsabilita whereComplessita($value)
 * @method static Builder|IndennitaResponsabilita whereCoordinamento($value)
 * @method static Builder|IndennitaResponsabilita whereCreatedAt($value)
 * @method static Builder|IndennitaResponsabilita whereCreatedBy($value)
 * @method static Builder|IndennitaResponsabilita whereCreatedIp($value)
 * @method static Builder|IndennitaResponsabilita whereDal($value)
 * @method static Builder|IndennitaResponsabilita whereDalf($value)
 * @method static Builder|IndennitaResponsabilita whereDali($value)
 * @method static Builder|IndennitaResponsabilita whereDalx($value)
 * @method static Builder|IndennitaResponsabilita whereDatemod($value)
 * @method static Builder|IndennitaResponsabilita whereDeletedAt($value)
 * @method static Builder|IndennitaResponsabilita whereDeletedBy($value)
 * @method static Builder|IndennitaResponsabilita whereDeletedIp($value)
 * @method static Builder|IndennitaResponsabilita whereDespro($value)
 * @method static Builder|IndennitaResponsabilita whereDisci1($value)
 * @method static Builder|IndennitaResponsabilita whereEmail($value)
 * @method static Builder|IndennitaResponsabilita whereEnte($value)
 * @method static Builder|IndennitaResponsabilita whereFormatoreProfessionale($value)
 * @method static Builder|IndennitaResponsabilita whereHaDiritto($value)
 * @method static Builder|IndennitaResponsabilita whereHandle($value)
 * @method static Builder|IndennitaResponsabilita whereId($value)
 * @method static Builder|IndennitaResponsabilita whereIdQuale($value)
 * @method static Builder|IndennitaResponsabilita whereLang($value)
 * @method static Builder|IndennitaResponsabilita whereLastStato($value)
 * @method static Builder|IndennitaResponsabilita whereMatr($value)
 * @method static Builder|IndennitaResponsabilita whereMotivoEscluso($value)
 * @method static Builder|IndennitaResponsabilita whereNome($value)
 * @method static Builder|IndennitaResponsabilita wherePosfun($value)
 * @method static Builder|IndennitaResponsabilita wherePosiz($value)
 * @method static Builder|IndennitaResponsabilita wherePosizTxt($value)
 * @method static Builder|IndennitaResponsabilita wherePosizioneLavoro($value)
 * @method static Builder|IndennitaResponsabilita wherePropro($value)
 * @method static Builder|IndennitaResponsabilita whereProtezioneCivile($value)
 * @method static Builder|IndennitaResponsabilita whereQua2ka($value)
 * @method static Builder|IndennitaResponsabilita whereQua2kd($value)
 * @method static Builder|IndennitaResponsabilita whereQualifica($value)
 * @method static Builder|IndennitaResponsabilita whereRelazioniPubblico($value)
 * @method static Builder|IndennitaResponsabilita whereRep2ka($value)
 * @method static Builder|IndennitaResponsabilita whereRep2kd($value)
 * @method static Builder|IndennitaResponsabilita whereRepar($value)
 * @method static Builder|IndennitaResponsabilita whereReparTxt($value)
 * @method static Builder|IndennitaResponsabilita whereResponsabilita($value)
 * @method static Builder|IndennitaResponsabilita whereStabi($value)
 * @method static Builder|IndennitaResponsabilita whereStabiTxt($value)
 * @method static Builder|IndennitaResponsabilita whereTipco($value)
 * @method static Builder|IndennitaResponsabilita whereTot($value)
 * @method static Builder|IndennitaResponsabilita whereUpdatedAt($value)
 * @method static Builder|IndennitaResponsabilita whereUpdatedBy($value)
 * @method static Builder|IndennitaResponsabilita whereUpdatedIp($value)
 * @method static Builder|IndennitaResponsabilita whereValoreEconomicoAttribuito($value)
 * @method static Builder|IndennitaResponsabilita whereValoreEconomicoCalcolato($value)
 * @method static Builder|IndennitaResponsabilita whereValutatoreId($value)
 * @method static Builder|IndennitaResponsabilita withDays(int $date_min, int $date_max)
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\Rating\Models\Rating, $this> ratings()
 * @property Profile|null $creator
 * @property string|null $codice_fiscale
 * @property string|null $inail
 * @property string|null $sesso
 * @property Collection<int, MyLog> $mailInviate
 * @property int|null $mail_inviate_count
 * @property RatingMorph|null $pivot
 * @property Profile|null $updater
 * @method static Builder<static>|IndennitaResponsabilita isCompiled()
 * @method static Builder<static>|IndennitaResponsabilita isNotCompiled()
 * @method static Builder<static>|IndennitaResponsabilita ofEnte(int $ente)
 * @method static Builder<static>|IndennitaResponsabilita ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method string msg(string $type)
 * @method Collection<int, Rating> getRatings()
 * @method array<string, string> getRatingsRules(string $prefix, string $postfix)
 * @method array<string, string> getRatingsValidationAttributes(string $prefix, string $postfix)
 * @property int|null $has_pdf
 * @property string|null $note
 * @property string|null $calculated_data
 * @property-read Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, \Modules\Progressioni\Models\Scheda> $avversari
 * @property-read int|null $avversari_count
 * @property-read Collection<int, IndennitaResponsabilita> $avversariCategoriaEco
 * @property-read int|null $avversari_categoria_eco_count
 * @property-read Collection<int, IndennitaResponsabilita> $criteriOptions
 * @property-read int|null $criteri_options_count
 * @property-read Profile|null $deleter
 * @property-read int|null $aventi_diritto
 * @property-read int|null $aventi_diritto_eff
 * @property-read string|null $categoria_ecoval
 * @property-read mixed|null $cont
 * @property-read string|null $disci1_txt
 * @property-read float|null $eta
 * @property-read int|null $excellences_count_last3years
 * @property-read string $from_field
 * @property-read int|null $gg_anno
 * @property-read int|null $gg_assenza_anno
 * @property-read int|null $gg_asz
 * @property-read int $gg_asz_cateco
 * @property-read int|null $gg_asz_cateco_fuori_sede
 * @property-read int|null $gg_asz_cateco_in_sede
 * @property-read int|null $gg_asz_cateco_posfun
 * @property-read int|null $gg_asz_cateco_posfun_fuori_sede
 * @property-read int|null $gg_asz_cateco_posfun_in_sede
 * @property-read int|null $gg_asz_fuori_sede
 * @property-read int|null $gg_asz_in_sede
 * @property-read int|null $gg_asz_tip_cod_escluso_subito
 * @property-read int $gg
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
 * @property-read float $gg_cateco_posfun_rapportato_max10_valutatore
 * @property-read int|null $gg_cateco_sup
 * @property-read int|null $gg_cateco_sup_fuori_sede
 * @property-read int|null $gg_cateco_sup_in_sede
 * @property-read int|null $gg_esperienza_no_asz
 * @property-read int|null $gg_fuori_sede
 * @property-read float|null $gg_fuori_sede_no_asz
 * @property-read int|null $gg_in_sede
 * @property-read float $gg_in_sede_no_asz
 * @property-read float|null $gg_integ_params_asz
 * @property-read float|null $gg_no_asz
 * @property-read float|null $gg_parttimevert_dalal
 * @property-read int|null $gg_posiz1_in_sede
 * @property-read int|null $gg_presenza_anno
 * @property-read int $gg_presenza_dalal
 * @property-read int|null $hh_asz
 * @property-read int|null $hh_asz_fuori_sede
 * @property-read int|null $hh_asz_in_sede
 * @property-read float|null $importo_stipendio_annuo
 * @property-read string|null $lista_propro
 * @property-read string|null $lista_propro_sup
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaResponsabilita\Models\Rating> $my_rating
 * @property-read int|float $perc_p_time_daterange
 * @property-read float|null $perc_parttime_dalal
 * @property-read float|null $perc_parttimepond_anno
 * @property-read float|null $perc_parttimepond_dalal
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
 * @property-read int|null $peso_esperienza_acquisita
 * @property-read int|null $posfunval
 * @property-read int $posizione
 * @property-read string|null $posizione_eco
 * @property-read string $post_type
 * @property-read float|null $ptime
 * @property float|null $punt_progressione_finale
 * @property-read float|null $ratings_avg
 * @property-read string $to_field
 * @property-read float $totale_pond
 * @property-read float|null $valore_differenziale_rapportato_pt
 * @property-read string|null $valutatore_txt
 * @property-read \Modules\IndennitaResponsabilita\Models\ImportiCategoria|null $importi
 * @property-read Collection<int, \Modules\Sigma\Models\Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read IndennitaResponsabilita|null $maxCatecoPosfun
 * @property-read Collection<int, \Modules\Performance\Models\Individuale> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @property-read IndennitaResponsabilita|null $pesi
 * @property-read Collection<int, Qua00f> $qua00fDaterange
 * @property-read int|null $qua00f_daterange_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Rating> $ratingObjectives
 * @property-read int|null $rating_objectives_count
 * @property-read Collection<int, \Modules\Sigma\Models\Repart> $reparts
 * @property-read int|null $reparts_count
 * @property-write mixed $motivo
 * @property-read IndennitaResponsabilita|null $stipendioTabellare
 * @property-read \Modules\Sigma\Models\Tqu00f|null $tqu00f
 * @method static \Modules\IndennitaResponsabilita\Database\Factories\IndennitaResponsabilitaFactory factory($count = null, $state = [])
 * @method static Builder<static>|IndennitaResponsabilita whereCalculatedData($value)
 * @method static Builder<static>|IndennitaResponsabilita whereHasPdf($value)
 * @method static Builder<static>|IndennitaResponsabilita whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndennitaResponsabilita withCalculatedData()
 * @method static Builder<static>|IndennitaResponsabilita withRating()
 * @property-read \Modules\IndennitaResponsabilita\Models\ImportiCategoria|null $importo
 * @property-read \Modules\Progressioni\Models\CategoriaPropro|null $categoriaPropro
 * @mixin \Eloquent
 */
class IndennitaResponsabilita extends BaseScheda
{
    use FunctionTrait;
    use HasRatingsTrait;
    use RelationshipTrait;

    protected $connection = 'indennita_responsabilita';

    protected $table = 'indennita_responsabilita';

    protected $fillable = ['id', 'ente', 'matr', 'cognome', 'nome', 'email',
        'stabi', 'repar', 'stabi_txt', 'repar_txt', 'rep2kd', 'rep2ka',
        'propro', 'posfun', 'despro', 'posiz', 'qua2kd', 'qua2ka', 'tipco', 'codqua', 'qualifica',
        'dal', 'al',  'dalf', 'alf', 'dali', 'ali',
        'anno', 'id_quale', 'posizione_lavoro', 'complessita', 'coordinamento', 'responsabilita',
        'tot', 'valore_economico_calcolato', 'valore_economico_attribuito', 'archivista_informatico',
        'relazioni_pubblico', 'protezione_civile', 'formatore_professionale', 'ha_diritto', 'motivo_escluso',
        'datemod', 'handle', 'last_stato', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_at',
        'deleted_by', 'deleted_ip', 'created_ip', 'updated_ip', 'categoria_eco', 'posiz_txt', 'disci1',
        'valutatore_id', 'note',
    ];

    /** @var list<string> */
    protected $dates = ['dal', 'al', 'dalf', 'alf', 'dali', 'ali', 'created_at', 'updated_at'];

    protected $with = ['ratings'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'dal' => 'date',
            'al' => 'date',
        ]);
    }

    /** @SuppressWarnings("PHPMD.CamelCasePropertyName") */
    public string $from_field = 'dal';

    /** @SuppressWarnings("PHPMD.CamelCasePropertyName") */
    public string $to_field = 'al';

    /* on RelationshipTrait
    public function messages():\Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Message::class, 'anno', 'anno');
    }
    */

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<\Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita>  $query
     */
    public function scopeIsCompiled(Builder $query): void
    {
        $query->whereHas('ratings', function ($query) {
            $query->havingRaw('SUM(value) > 0');
        });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<\Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita>  $query
     */
    public function scopeIsNotCompiled(Builder $query): void
    {
        $query->whereDoesntHave('ratings')
            ->orWhereHas('ratings', function ($query) {
                $query->havingRaw('SUM(value) <= 0');
            });
    }

    /**
     * Imposta il flag diritto alla progressione.
     */
    public function setHaDirittoAttribute(?int $value): void
    {
        $this->attributes['ha_diritto'] = $value;
    }

    /**
     * Imposta il motivo di esclusione.
     */
    public function setMotivoAttribute(?string $value): void
    {
        $this->attributes['motivo'] = $value;
    }

    // Note: msg(), getRatingsRules(), getRatingsValidationAttributes() are defined in FunctionTrait
    // and override any methods defined here. The trait versions take parameters.
}
