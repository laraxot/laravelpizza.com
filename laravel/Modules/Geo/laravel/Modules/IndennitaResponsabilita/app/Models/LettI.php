<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use LogicException;
use Modules\IndennitaResponsabilita\Models\Traits\FunctionTrait;
use Modules\IndennitaResponsabilita\Models\Traits\RelationshipTrait;
// ---- traits ---
use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Models\Profile;
// --- services --
use Modules\Rating\Models\Traits\HasRatingsTrait;
// ---- external models ----
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Rep00f;
use Modules\Xot\Services\HtmlService;
use RuntimeException;

/**
 * Modules\IndennitaResponsabilita\Models\LettI.
 *
 * @property int|null $id
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
 * @property int|null $dalx
 * @property int|null $alx
 * @property Carbon|null $dalf dal retribuzione
 * @property Carbon|null $alf al retribuzione
 * @property Carbon|null $dali
 * @property Carbon|null $ali
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
 * @property string $dali_ali
 * @property Collection<int, MyLog> $mailInviate
 * @property int|null $mail_inviate_count
 * @property Collection<int, IndennitaResponsabilita> $mails
 * @property int|null $mails_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Message> $messages
 * @property int|null $messages_count
 * @property Collection<int, MyLog> $myLogs
 * @property int|null $my_logs_count
 * @property Collection<int, Rating> $ratings
 * @property int|null $ratings_count
 * @property StabiDirigente|null $stabiDirigente
 * @method static Builder|LettI newModelQuery()
 * @method static Builder|LettI newQuery()
 * @method static Builder|LettI ofDate(int $date)
 * @method static Builder|LettI ofEnteYear(int $ente, int $year)
 * @method static Builder|LettI ofQuarter(int $quarter, int $year)
 * @method static Builder|LettI ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|LettI ofYear(int $year)
 * @method static Builder|LettI query()
 * @method static Builder|LettI whereAl($value)
 * @method static Builder|LettI whereAlf($value)
 * @method static Builder|LettI whereAli($value)
 * @method static Builder|LettI whereAlx($value)
 * @method static Builder|LettI whereAnno($value)
 * @method static Builder|LettI whereArchivistaInformatico($value)
 * @method static Builder|LettI whereCategoriaEco($value)
 * @method static Builder|LettI whereCodqua($value)
 * @method static Builder|LettI whereCognome($value)
 * @method static Builder|LettI whereComplessita($value)
 * @method static Builder|LettI whereCoordinamento($value)
 * @method static Builder|LettI whereCreatedAt($value)
 * @method static Builder|LettI whereCreatedBy($value)
 * @method static Builder|LettI whereCreatedIp($value)
 * @method static Builder|LettI whereDal($value)
 * @method static Builder|LettI whereDalf($value)
 * @method static Builder|LettI whereDali($value)
 * @method static Builder|LettI whereDalx($value)
 * @method static Builder|LettI whereDatemod($value)
 * @method static Builder|LettI whereDeletedAt($value)
 * @method static Builder|LettI whereDeletedBy($value)
 * @method static Builder|LettI whereDeletedIp($value)
 * @method static Builder|LettI whereDespro($value)
 * @method static Builder|LettI whereDisci1($value)
 * @method static Builder|LettI whereEmail($value)
 * @method static Builder|LettI whereEnte($value)
 * @method static Builder|LettI whereFormatoreProfessionale($value)
 * @method static Builder|LettI whereHaDiritto($value)
 * @method static Builder|LettI whereHandle($value)
 * @method static Builder|LettI whereId($value)
 * @method static Builder|LettI whereIdQuale($value)
 * @method static Builder|LettI whereLang($value)
 * @method static Builder|LettI whereLastStato($value)
 * @method static Builder|LettI whereMatr($value)
 * @method static Builder|LettI whereMotivoEscluso($value)
 * @method static Builder|LettI whereNome($value)
 * @method static Builder|LettI wherePosfun($value)
 * @method static Builder|LettI wherePosiz($value)
 * @method static Builder|LettI wherePosizTxt($value)
 * @method static Builder|LettI wherePosizioneLavoro($value)
 * @method static Builder|LettI wherePropro($value)
 * @method static Builder|LettI whereProtezioneCivile($value)
 * @method static Builder|LettI whereQua2ka($value)
 * @method static Builder|LettI whereQua2kd($value)
 * @method static Builder|LettI whereQualifica($value)
 * @method static Builder|LettI whereRelazioniPubblico($value)
 * @method static Builder|LettI whereRep2ka($value)
 * @method static Builder|LettI whereRep2kd($value)
 * @method static Builder|LettI whereRepar($value)
 * @method static Builder|LettI whereReparTxt($value)
 * @method static Builder|LettI whereResponsabilita($value)
 * @method static Builder|LettI whereStabi($value)
 * @method static Builder|LettI whereStabiTxt($value)
 * @method static Builder|LettI whereTipco($value)
 * @method static Builder|LettI whereTot($value)
 * @method static Builder|LettI whereUpdatedAt($value)
 * @method static Builder|LettI whereUpdatedBy($value)
 * @method static Builder|LettI whereUpdatedIp($value)
 * @method static Builder|LettI whereValoreEconomicoAttribuito($value)
 * @method static Builder|LettI whereValoreEconomicoCalcolato($value)
 * @method static Builder|LettI whereValutatoreId($value)
 * @method static Builder|LettI withDays(int $date_min, int $date_max)
 * @property Profile|null $creator
 * @property RatingMorph|null $pivot
 * @property Profile|null $updater
 * @method static Builder<static>|LettI ofEnte(int $ente)
 * @method static Builder<static>|LettI ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @property-read Collection<int, \Modules\Sigma\Models\Sto00f> $Sto00fYear
 * @property-read int|null $sto00f_year_count
 * @property-read Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, \Modules\Sigma\Models\Ana02f> $ana02f
 * @property-read int|null $ana02f_count
 * @property-read \Modules\Sigma\Models\Ana10f|null $ana10f
 * @property-read Anag|null $anag
 * @property-read Collection<int, \Modules\Sigma\Models\Asz00f> $asz00f
 * @property-read int|null $asz00f_count
 * @property-read Collection<int, \Modules\Sigma\Models\Asz00k1> $asz00k1
 * @property-read int|null $asz00k1_count
 * @property-read Collection<int, \Modules\Sigma\Models\Asz00k1> $asz00k1Year
 * @property-read int|null $asz00k1_year_count
 * @property-read Collection<int, \Modules\Progressioni\Models\Scheda> $avversari
 * @property-read int|null $avversari_count
 * @property-read Collection<int, LettI> $avversariCategoriaEco
 * @property-read int|null $avversari_categoria_eco_count
 * @property-read Collection<int, LettI> $criteriOptions
 * @property-read int|null $criteri_options_count
 * @property-read Profile|null $deleter
 * @property-read int|null $aventi_diritto
 * @property-read int|null $aventi_diritto_eff
 * @property-read string|null $categoria_ecoval
 * @property-read string|null $codice_fiscale
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
 * @property-read int|float $gg_p_time_vert_year
 * @property-read float|null $gg_parttimevert_anno
 * @property-read int|null $gg_parttimevert
 * @property-read float|null $gg_parttimevert_dalal
 * @property-read int|null $gg_posiz1_in_sede
 * @property-read int|null $gg_presenza_anno
 * @property-read int $gg_presenza_dalal
 * @property-read int|null $hh_asz
 * @property-read int|null $hh_asz_fuori_sede
 * @property-read int|null $hh_asz_in_sede
 * @property-read float|null $importo_stipendio_annuo
 * @property-read string|null $inail
 * @property-read string|null $last_data_assunz
 * @property-read string|null $lista_propro
 * @property-read string|null $lista_propro_sup
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaResponsabilita\Models\Rating> $my_rating
 * @property-read int|float $perc_p_time_daterange
 * @property-read int|float $perc_p_time_year
 * @property-read float|null $perc_parttime_anno
 * @property-read float|null $perc_parttime
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
 * @property-read string|null $sesso
 * @property-read string|null $titolo_di_studio
 * @property-read string $to_field
 * @property-read float $totale_pond
 * @property-read float|null $valore_differenziale_rapportato_pt
 * @property-read string|null $valutatore_txt
 * @property-read Collection<int, \Modules\Sigma\Models\Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read LettI|null $maxCatecoPosfun
 * @property-read Collection<int, \Modules\Performance\Models\Individuale> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @property-read LettI|null $pesi
 * @property-read Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 * @property-read Collection<int, Qua00f> $qua00fDaterange
 * @property-read int|null $qua00f_daterange_count
 * @property-read Collection<int, Qua00f> $qua00fYear
 * @property-read int|null $qua00f_year_count
 * @property-read Collection<int, \Modules\Sigma\Models\Qua03f> $qua03f
 * @property-read int|null $qua03f_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Rating> $ratingObjectives
 * @property-read int|null $rating_objectives_count
 * @property-read Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 * @property-read Collection<int, \Modules\Sigma\Models\Repart> $reparts
 * @property-read int|null $reparts_count
 * @property-read LettI|null $stipendioTabellare
 * @property-read Collection<int, \Modules\Sigma\Models\Sto00f> $sto00f
 * @property-read int|null $sto00f_count
 * @property-read \Modules\Sigma\Models\Tqu00f|null $tqu00f
 * @property-read \Modules\IndennitaResponsabilita\Models\StabiDirigente|null $valutatore
 * @property-read Collection<int, \Modules\Sigma\Models\Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 * @property-read Collection<int, \Modules\Sigma\Models\Wstr01lx> $wstr01lxYear
 * @property-read int|null $wstr01lx_year_count
 * @method static \Modules\IndennitaResponsabilita\Database\Factories\LettIFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettI withCalculatedData()
 * @method static Builder<static>|LettI withRating()
 * @property-read \Modules\IndennitaResponsabilita\Models\ImportiCategoria|null $importo
 * @property-read \Modules\Progressioni\Models\CategoriaPropro|null $categoriaPropro
 * @property-read \Modules\IndennitaResponsabilita\Models\ImportiCategoria|null $importi
 * @mixin \Eloquent
 */
class LettI extends BaseScheda
{
    use FunctionTrait;
    use HasRatingsTrait;
    use RelationshipTrait;

    public string $from_field = 'dal';

    public string $to_field = 'al';

    protected $table = 'indennita_responsabilita';

    /** @var list<string> */
    protected $fillable = [
        'id', 'ente', 'matr', 'stabi', 'repar', 'anno', 'dal', 'al', 'dalf', 'alf', 'dali', 'ali',
        'archivista_informatico', 'relazioni_pubblico', 'protezione_civile', 'formatore_professionale',
    ];

    protected $appends = ['dali__ali'];

    /** @var list<string> */
    public array $xls_fields = ['ente', 'matr', 'cognome', 'nome', 'email', 'propro', 'posfun',
        'categoria_eco', 'dal', 'al', 'archivista_informatico', 'relazioni_pubblico',
        'protezione_civile', 'formatore_professionale', ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dal' => 'datetime',
            'al' => 'datetime',
            'dalf' => 'datetime',
            'alf' => 'datetime',
            'dali' => 'datetime',
            'ali' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // --------- relationship ----------
    /* REMOVED: Redundant with RelationshipTrait and fixed to avoid SQL errors during static analysis.
    public function importi(): ?object
    {
        ...
    }
    */

    /*
    public function anag(): HasOne {
        return $this->hasOne(Anag::class, 'matr', 'matr')->where('ente', $this->ente);
    }
    */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaResponsabilita\Models\StabiDirigente, $this>
     */
    public function stabiDirigente(): HasOne
    {
        return $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('anno', $this->anno);
    }

    // -------------------------------------------------------------------------------------
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\IndennitaResponsabilita\Models\MyLog, $this>
     */
    public function mailInviate(): HasMany
    {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')->where('tbl', $this->getTable())->where('note', 'sendMailLettI');
    }

    // --------- mutators ---------
    /**
     * @param  mixed  $value
     */
    public function getDaliAttribute($value): ?Carbon
    {
        /** @var int|null $anno */
        $anno = $this->anno;
        if ($value === null && $anno !== null) {
            $value = Carbon::createFromDate($anno, 1, 1);
        }

        if (\is_string($value)) {
            $value = Carbon::parse($value);
        }

        if ($value instanceof Carbon && $this->getKey() !== null) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            $this->update(['dali' => $value]);
        }

        return $value instanceof Carbon ? $value : null;
    }

    /**
     * @param  mixed  $value
     */
    public function getAliAttribute($value): ?Carbon
    {
        /** @var int|null $anno */
        $anno = $this->anno;
        if ($value === null && $anno !== null) {
            $value = Carbon::createFromDate($anno, 12, 31);
        }

        if (\is_string($value)) {
            $value = Carbon::parse($value);
        }

        if ($value instanceof Carbon && $this->getKey() !== null) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            $this->update(['ali' => $value]);
        }

        return $value instanceof Carbon ? $value : null;
    }

    /**
     * @param  mixed  $value
     */
    public function getDaliAliAttribute($value): string
    {
        /** @var Carbon|null $ali */
        $ali = $this->ali;
        /** @var Carbon|null $dali */
        $dali = $this->dali;
        if ($ali === null || $dali === null) {
            return '';
        }

        return $ali->format('d/m/Y').' - '.$dali->format('d/m/Y');
    }

    public function setDaliAliAttribute(mixed $value): never
    {
        throw new LogicException('Cannot set dali_ali attribute directly. This is a computed property.');
    }

    /**
     * @param  Carbon|string|null  $value
     */
    public function setDaliAttribute($value): void
    {
        if (\is_string($value)) {
            $value = Carbon::createFromFormat('d/m/Y', $value);
            if (! ($value instanceof Carbon)) {
                return;
            }
        }

        // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
        if ($this->getKey() !== null) {
            $this->update(['dali' => $value]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected static function getRouteParameters(): array
    {
        if (app()->runningInConsole()) {
            return [];
        }

        $route = Request::route();
        if (! $route instanceof IlluminateRoute) {
            return [];
        }

        $params = $route->parameters();
        if (! is_array($params)) {
            return [];
        }

        /** @var array<string, mixed> $result */
        $result = [];
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @param  Carbon|string|null  $value
     */
    public function setAliAttribute($value): void
    {
        if (\is_string($value)) {
            $value = Carbon::createFromFormat('d/m/Y', $value);
            if (! ($value instanceof Carbon)) {
                return;
            }
        }

        $this->attributes['ali'] = $value;
    }

    public function getEmailAttribute(?string $value): ?string
    {
        if ($value !== null && $value !== '') {
            return $value;
        }

        /** @var Anag|null $anag */
        $anag = $this->anag;
        if ($anag === null) {
            return '';
        }

        /** @var string|null $emailFromAnag */
        $emailFromAnag = $anag->email ?? null;
        if ($emailFromAnag === null || $emailFromAnag === '') {
            return '';
        }

        // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
        if ($this->getKey() !== null) {
            $this->update(['email' => $emailFromAnag]);
        }

        return $emailFromAnag;
    }

    // ---------------------------------------
    // --------- functions ---------
    /**
     * @param  array<string, mixed>  $params
     */
    public static function updateFields(array $params = []): void
    {
        $routeParams = self::getRouteParameters();
        $params = array_merge($routeParams, $params);
        /** @var int|string|null $annoRaw */
        $annoRaw = $params['anno'] ?? date('Y');
        $anno = is_numeric($annoRaw) ? (int) $annoRaw : (int) date('Y');
        /** @var int|string|null $stabi */
        $stabi = $params['stabi'] ?? null;
        /** @var int|string|null $repar */
        $repar = $params['repar'] ?? null;
        if ($stabi === null || $repar === null) {
            return;
        }
        $rows0 = Rep00f::where('repst1', $stabi)->where('repre1', $repar)
            ->ofYear($anno)
            ->whereRaw('repann=""');
        foreach ($rows0->get() as $row) {
            $parz = ['ente' => $row->ente,
                'matr' => $row->matr,
                'stabi' => $row->repst1,
                'repar' => $row->repre1,
                'rep2kd' => $row->rep2kd,
                'rep2ka' => $row->rep2ka,
                'anno' => $anno, ];

            $obj = self::firstOrCreate($parz);
            $obj->rep2kd = $row->rep2kd;
            $obj->rep2ka = $row->rep2ka;
            if ($obj->dali === null) {
                $obj->dali = Carbon::createFromDate($anno, 1, 1);
            }

            if ($obj->ali === null) {
                $obj->ali = Carbon::createFromDate($anno, 12, 31);
            }

            if ($obj->dalf === null) {
                $obj->dalf = Carbon::createFromDate($anno, 1, 1);
            }

            if ($obj->alf === null) {
                $obj->alf = Carbon::createFromDate($anno, 12, 31);
            }

            if ($obj->propro === 0 || $obj->propro === null) {
                $dalfInt = (int) $obj->dalf->format('Ymd');
                $alfInt = (int) $obj->alf->format('Ymd');
                /** @var Anag|null $anag */
                $anag = $obj->anag;
                if ($anag === null) {
                    continue;
                }
                /** @var Builder<Qua00f> $qua00fQuery */
                $qua00fQuery = $anag->qua00f();
                /** @var Builder<Qua00f> $qua00fQuery */
                $qua00fQuery = $qua00fQuery
                    ->select('propro', 'posfun', 'posiz')
                    ->distinct()
                    ->ofRangeDate($dalfInt, $alfInt);
                /** @var Collection<int, Qua00f> $qua00fCollection */
                $qua00fCollection = $qua00fQuery->get();
                // echo '<br/>'.$qua00f->count().' - '.$qua00f->first()->propro.'  - '.$qua00f->first()->posfun;
                if ($qua00fCollection->count() === 1) {
                    /** @var Qua00f|null $firstQua00f */
                    $firstQua00f = $qua00fCollection->first();
                    if ($firstQua00f !== null) {
                        $obj->propro = $firstQua00f->propro;
                        $obj->posfun = $firstQua00f->posfun;
                        $obj->posiz = $firstQua00f->posiz;
                    }
                } else {
                    echo '<br/>$qua00f->count() : '.$qua00fCollection->count();
                    echo '<br/>ente :'.$obj->ente;
                    echo '<br/>matr :'.$obj->matr;
                    echo "<br/>qualcosa e' andato storto [".__LINE__.']['.__FILE__.']';
                    echo '<pre>';
                    print_r($qua00fQuery->toSql());
                    /** @var Builder<Qua00f> $qua00fQuery2 */
                    $qua00fQuery2 = $anag->qua00f();
                    /** @var Builder<Qua00f> $qua00fQuery2 */
                    $qua00fQuery2 = $qua00fQuery2
                        ->ofRangeDate($dalfInt, $alfInt)
                        ->orderBy('qua2kd');
                    /** @var Collection<int, Qua00f> $qua00f */
                    $qua00f = $qua00fQuery2->get();

                    // foreach($qua00f as $v_qua00f){
                    if ($qua00f->count() < 2) {
                        continue;
                    }
                    /** @var Qua00f|null $firstQua00f */
                    $firstQua00f = $qua00f->get(0);
                    /** @var Qua00f|null $secondQua00f */
                    $secondQua00f = $qua00f->get(1);
                    if ($firstQua00f === null || $secondQua00f === null) {
                        continue;
                    }

                    // Preserve original $obj->al BEFORE any modification (critical for replicate)
                    /** @var Carbon|null $alOld */
                    $alOld = $obj->al;

                    /** @var int|string|null $qua2kd */
                    $qua2kd = $secondQua00f->qua2kd;
                    if ($alOld === null || $qua2kd === null) {
                        continue;
                    }

                    // Update original object
                    $obj->al = Carbon::parse((string) $qua2kd);
                    $obj->save();

                    // Create replicated object with second qualification
                    $obj1 = $obj->replicate();
                    /** @var int|string|null $secondQua2kd */
                    $secondQua2kd = $secondQua00f->qua2kd;
                    if ($secondQua2kd !== null) {
                        $obj1->dal = Carbon::parse((string) $secondQua2kd);
                    }
                    /** @var int|string|null $secondQua2ka */
                    $secondQua2ka = $secondQua00f->qua2ka ?? null;
                    if ($secondQua2ka !== null && $secondQua2ka !== 0) {
                        $obj1->al = Carbon::parse((string) $secondQua2ka);
                    } elseif ($alOld instanceof Carbon) {
                        // Use preserved original value (type-safe check)
                        $obj1->al = $alOld;
                    }
                    // Note: id will be auto-generated on save
                    $obj1->save();
                }
            }

            $obj->save();
        }

        $obj = new self;
        $table = $obj->getTable();
        $conn = $obj->getConnection();
        $where = $table.'.anno="'.$anno.'" ';
        // Anag::massUpdateCognomeNome(['conn' => $conn, 'table' => $table, 'where' => $where]);
        // Anag::massUpdateCategoriaEco(['conn' => $conn, 'table' => $table, 'where' => $where]);
        // Anag::massUpdatePosizTxt(['conn' => $conn, 'table' => $table, 'where' => $where]);
        // Anag::massUpdateStabiTxtReparTxt(['conn' => $conn, 'table' => $table, 'where' => $where]);
    }

    /**
     * Generate PDF content from a view.
     */
    public function content_PDF(string $view): string
    {
        // $view='admin.performance.individuale.pdf';
        /** @var int|null $anno */
        $anno = $this->anno;
        /** @var view-string $viewString */
        $viewString = $view;
        /** @var string $content */
        $content = view($viewString, ['row' => $this, 'anno' => $anno])->render();

        /** @var int|null $id */
        $id = $this->id;
        if ($id === null) {
            throw new RuntimeException('Cannot generate PDF for record without ID');
        }

        /** @var string $result */
        $result = HtmlService::toPdf($content, 'content_PDF', 'L', (string) $id);

        return $result;
    }

    // end content_PDF
}
