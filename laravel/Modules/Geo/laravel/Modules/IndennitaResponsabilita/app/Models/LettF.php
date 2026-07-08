<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\IndennitaResponsabilita\Models\Traits\FunctionTrait;
use Modules\IndennitaResponsabilita\Models\Traits\RelationshipTrait;
use Modules\Ptv\Models\BaseScheda;
use Modules\Rating\Models\Traits\HasRatingsTrait;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Codici;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Rep00f;
use Validator;

/**
 * @property Carbon|null $dalf
 * @property Carbon|null $alf
 * @property ImportiCategoria|null $importi
 * @property int $id
 * @property int|null $valutatore_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Qua00f> $qua00fRetribuzioneDateRange
 * @property-read int|null $qua00f_retribuzione_date_range_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Rep00f> $rep00fByAnno
 * @property-read int|null $rep00f_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Sto00f> $Sto00fYear
 * @property-read int|null $sto00f_year_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Ana02f> $ana02f
 * @property-read int|null $ana02f_count
 * @property-read \Modules\Sigma\Models\Ana10f|null $ana10f
 * @property-read Anag|null $anag
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Asz00f> $asz00f
 * @property-read int|null $asz00f_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Asz00k1> $asz00k1
 * @property-read int|null $asz00k1_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Asz00k1> $asz00k1Year
 * @property-read int|null $asz00k1_year_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Progressioni\Models\Scheda> $avversari
 * @property-read int|null $avversari_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, LettF> $avversariCategoriaEco
 * @property-read int|null $avversari_categoria_eco_count
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, LettF> $criteriOptions
 * @property-read int|null $criteri_options_count
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read int|null $aventi_diritto
 * @property-read int|null $aventi_diritto_eff
 * @property-read string|null $categoria_eco
 * @property-read string|null $categoria_ecoval
 * @property-read string|null $codice_fiscale
 * @property-read string|null $codqua
 * @property-read string|null $cognome
 * @property-read mixed|null $cont
 * @property-read int|null $disci1
 * @property-read string|null $disci1_txt
 * @property-read string|null $email
 * @property-read int|null $ente
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
 * @property-read string|null $nome
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
 * @property-read int|null $posiz
 * @property-read string|null $posiz_txt
 * @property-read int $posizione
 * @property-read string|null $posizione_eco
 * @property-read string $post_type
 * @property-read int|null $propro
 * @property-read float|null $ptime
 * @property float|null $punt_progressione_finale
 * @property-read float|null $ratings_avg
 * @property-read int|null $ratings_count
 * @property-read string|null $repar_txt
 * @property-read string|null $sesso
 * @property-read string|null $stabi_txt
 * @property-read mixed|null $tipco
 * @property-read string|null $titolo_di_studio
 * @property-read string $to_field
 * @property-read float $tot
 * @property-read float $totale_pond
 * @property-read float|null $valore_differenziale_rapportato_pt
 * @property-read float $valore_economico_attribuito
 * @property-read float $valore_economico_calcolato
 * @property-read float $valore_economico_effettivo
 * @property-read string|null $valutatore_txt
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaResponsabilita\Models\MyLog> $mailInviate
 * @property-read int|null $mail_inviate_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita> $mails
 * @property-read int|null $mails_count
 * @property-read LettF|null $maxCatecoPosfun
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaResponsabilita\Models\MyLog> $myLogs
 * @property-read int|null $my_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Performance\Models\Individuale> $performanceIndividuale
 * @property-read int|null $performance_individuale_count
 * @property-read LettF|null $pesi
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Qua00f> $qua00fDaterange
 * @property-read int|null $qua00f_daterange_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Qua00f> $qua00fYear
 * @property-read int|null $qua00f_year_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Qua03f> $qua03f
 * @property-read int|null $qua03f_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaResponsabilita\Models\Rating> $ratingObjectives
 * @property-read int|null $rating_objectives_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Repart> $reparts
 * @property-read int|null $reparts_count
 * @property-read \Modules\IndennitaResponsabilita\Models\StabiDirigente|null $stabiDirigente
 * @property-read LettF|null $stipendioTabellare
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Sto00f> $sto00f
 * @property-read int|null $sto00f_count
 * @property-read \Modules\Sigma\Models\Tqu00f|null $tqu00f
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @property-read \Modules\IndennitaResponsabilita\Models\StabiDirigente|null $valutatore
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Sigma\Models\Wstr01lx> $wstr01lxYear
 * @property-read int|null $wstr01lx_year_count
 * @method static \Modules\IndennitaResponsabilita\Database\Factories\LettFFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF ofDate(int $date)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF ofEnte(int $ente)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF ofEnteYear(int $ente, int $year)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF ofQuarter(int $quarter, int $year)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF ofRangeDate(int $date_start, int $date_end)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF ofYear(int $year)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF whereValutatoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF withCalculatedData()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF withDays(int $date_min, int $date_max)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LettF withRating()
 * @property-read \Modules\IndennitaResponsabilita\Models\ImportiCategoria|null $importo
 * @property-read \Modules\Progressioni\Models\CategoriaPropro|null $categoriaPropro
 * @mixin \Eloquent
 */
class LettF extends BaseScheda
{
    use FunctionTrait;
    use HasRatingsTrait;
    use RelationshipTrait;

    /** @var class-string */
    public static $logModel = MyLog::class;

    public string $from_field = 'dal';

    public string $to_field = 'al';

    protected $table = 'indennita_responsabilita';

    /** @var list<string> */
    protected $fillable = [
        'id', 'ente', 'matr', 'stabi', 'repar', 'rep2kd', 'rep2ka', 'anno',
        'email', 'posizione_lavoro',
        'complessita', 'coordinamento', 'responsabilita',
        'tot', 'valore_economico_calcolato', 'valore_economico_attribuito',
        'propro', 'posfun', 'categoria_eco', 'posiz', 'posiz_txt',
        'cognome', 'nome',
        'dal', 'al', 'dalf', 'alf', 'dali', 'ali',
    ];

    /** @var array<string, string> */
    public array $rules = [
        'posizione_lavoro' => 'required',
        'email' => 'required',
        'complessita' => 'required|numeric|min:0|max:40',
        'coordinamento' => 'required|numeric|min:0|max:30',
        'responsabilita' => 'required|numeric|min:0|max:30',
    ];

    /** @var list<string> */
    public array $xls_fields = [
        'ente', 'matr',
        'cognome', 'nome',
        'email',
        'stabi', 'stabi_txt',
        'repar', 'repar_txt',
        'propro',
        'posfun', 'categoria_eco',
        'dalf', 'alf',
        'posizione_lavoro',
        'complessita',
        'coordinamento',
        'responsabilita',
        'tot',
        'valore_economico_calcolato',
        'valore_economico_attribuito',
    ];

    /** @var array<string, string> */
    public array $messages = [
        'posizione_lavoro.required' => 'campo obbligatorio, non lasciare vuoto',
        'complessita.numeric.max' => 'deve essere compreso fra 0 e 40',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dalf' => 'date:Y-m-d',
            'alf' => 'date:Y-m-d',
            'dal' => 'datetime',
            'al' => 'datetime',
            'dali' => 'datetime',
            'ali' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function validate(array $data): void
    {
        $validator = Validator::make($data, $this->rules, $this->messages);
        $validator->validate();
    }

    /* REMOVED: Redundant with RelationshipTrait and fixed to avoid SQL errors during static analysis.
    public function importi(): ?HasOne
    {
        ...
    }
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaResponsabilita\Models\StabiDirigente, $this>
     */
    public function stabiDirigente(): HasOne
    {
        /** @var int|string|null $repar */
        $repar = $this->repar ?? null;
        /** @var int|null $anno */
        $anno = $this->anno ?? null;
        $query = $this->hasOne(StabiDirigente::class, 'stabi', 'stabi');
        if ($repar !== null) {
            $query = $query->where('repar', $repar);
        }
        if ($anno !== null) {
            $query = $query->where('anno', $anno);
        }

        return $query;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\IndennitaResponsabilita\Models\MyLog, $this>
     */
    public function mailInviate(): HasMany
    {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')
            ->where('tbl', $this->getTable())
            ->where('note', 'sendMailLettF');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Sigma\Models\Rep00f, $this>
     */
    public function rep00fByAnno(): HasMany
    {
        /** @var int|null $anno */
        $anno = $this->anno ?? null;
        if ($anno === null) {
            /** @var HasMany<Rep00f, $this> $relation */
            $relation = $this->hasMany(Rep00f::class, 'matr', 'matr')
                ->where('ente', $this->ente)
                ->whereRaw('repann=""')
                ->whereRaw('1=0');

            return $relation;
        }

        /** @var HasMany<Rep00f, $this> $relation */
        $relation = $this->hasMany(Rep00f::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->whereRaw('repann=""')
            ->ofYear($anno);

        return $relation;
    }

    /**
     * Qua00f nel range retribuzione (dalf/alf).
     *
     * Distinto da {@see qua00fDaterange()} (trait Sigma, campi dal/al).
     * Nome non `qua00fDateRange`: in PHP collide con `qua00fDaterange`.
     *
     * @return HasMany<Qua00f, LettF>
     */
    public function qua00fRetribuzioneDateRange(): HasMany
    {
        [$dalYmd, $alYmd] = $this->retribuzioneRangeYmd();

        /** @var HasMany<Qua00f, LettF> $relation */
        $relation = $this->hasMany(Qua00f::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->whereRaw('quaann=""')
            ->ofRangeDate($dalYmd, $alYmd);

        return $relation;
    }

    /**
     * @return array{0: int, 1: int}
     */
    protected function retribuzioneRangeYmd(): array
    {
        if ($this->dalf === null) {
            $this->dalf = Carbon::createFromDate((int) $this->anno, 1, 1);
        }

        if ($this->alf === null) {
            $this->alf = Carbon::createFromDate((int) $this->anno, 12, 31);
        }

        return [
            (int) $this->dalf->format('Ymd'),
            (int) $this->alf->format('Ymd'),
        ];
    }

    /**
     * @param  Carbon|string|null  $value
     */
    public function setDalfAttribute($value): void
    {
        if (\is_string($value)) {
            $value = Carbon::createFromFormat('d/m/Y', $value);
            if (! ($value instanceof Carbon)) {
                return;
            }
        }
        $this->attributes['dalf'] = $value;
    }

    /**
     * @param  Carbon|string|null  $value
     */
    public function setAlfAttribute($value): void
    {
        if (\is_string($value)) {
            $value = Carbon::createFromFormat('d/m/Y', $value);
            if (! ($value instanceof Carbon)) {
                return;
            }
        }
        $this->attributes['alf'] = $value;
    }

    /**
     * Get tot attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE con ActivityLog-Safe
     */
    public function getTotAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->calculateTot();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($this->getKey() !== null) {
           
                    self::withoutEvents(function () use ($value): void {
                        $this->update(['tot' => $value]);
                    });
                
                
                
        }

        return $value;
    }

    /**
     * Calcola il totale (complessita + coordinamento + responsabilita).
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateTot(): float
    {
        $complessita = $this->complessita ?? 0;
        $coordinamento = $this->coordinamento ?? 0;
        $responsabilita = $this->responsabilita ?? 0;

        $complessitaNum = is_numeric($complessita) ? (float) $complessita : 0.0;
        $coordinamentoNum = is_numeric($coordinamento) ? (float) $coordinamento : 0.0;
        $responsabilitaNum = is_numeric($responsabilita) ? (float) $responsabilita : 0.0;

        return $complessitaNum + $coordinamentoNum + $responsabilitaNum;
    }

    /**
     * Get valore_economico_calcolato attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE con ActivityLog-Safe
     */
    public function getValoreEconomicoCalcolatoAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->calculateValoreEconomicoCalcolato();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($this->getKey() !== null) {
            
                    self::withoutEvents(function () use ($value): void {
                        $this->update(['valore_economico_calcolato' => $value]);
                    });
                
                
                
        }

        return $value;
    }

    /**
     * Calcola il valore economico calcolato.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateValoreEconomicoCalcolato(): float
    {
        $importi = $this->importi;
        if ($importi === null) {
            return 0.0;
        }

        $importoMax = $importi->max ?? 0;
        $importoMaxNum = is_numeric($importoMax) ? (float) $importoMax : 0.0;
        $tot = $this->tot ?? 0.0;
        $totNum = is_numeric($tot) ? (float) $tot : 0.0;

        return $totNum * $importoMaxNum / 100;
    }

    public function getValoreEconomicoEffettivoAttribute(): float
    {
        /** @var Carbon|null $alf */
        $alf = $this->alf;
        /** @var Carbon|null $dalf */
        $dalf = $this->dalf;
        if ($alf === null || $dalf === null) {
            return 0.0;
        }
        $gg = $alf->diffInDays($dalf, true) + 1;
        /** @var float|int $valoreEconomicoAttribuito */
        $valoreEconomicoAttribuito = $this->valore_economico_attribuito ?? 0.0;

        return round($valoreEconomicoAttribuito * $gg / 365, 2);
    }

    /**
     * Get valore_economico_attribuito attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE con ActivityLog-Safe
     */
    public function getValoreEconomicoAttribuitoAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->calculateValoreEconomicoAttribuito();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($this->getKey() !== null) {
            
                    self::withoutEvents(function () use ($value): void {
                        $this->update(['valore_economico_attribuito' => $value]);
                    });
                
                
                
        }

        return $value;
    }

    /**
     * Calcola il valore economico attribuito (max tra valore e importoMin).
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateValoreEconomicoAttribuito(): float
    {
        $importi = $this->importi;
        if ($importi === null) {
            return 0.0;
        }

        $importoMin = $importi->min ?? 0;
        $importoMinNum = is_numeric($importoMin) ? (float) $importoMin : 0.0;

        // Il valore corrente è già nel DB o calcolato
        $value = $this->attributes['valore_economico_attribuito'] ?? 0.0;
        $valueFloat = is_numeric($value) ? (float) $value : 0.0;

        return max($valueFloat, $importoMinNum);
    }

    public function getPosizTxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() === null) {
            return null;
        }

        /** @var int|string|null $posiz */
        $posiz = $this->posiz ?? null;
        if ($posiz === null) {
            return null;
        }

        /** @var Codici|null $row */
        $row = Codici::where('tipo', 19)->where('codice', $posiz)->first();
        if ($row === null) {
            return null;
        }

        /** @var string|null $desc1 */
        $desc1 = $row->desc1 ?? null;
        if ($desc1 === null) {
            return null;
        }

        /** @var int|string|null $primaryKey */
        $primaryKey = $this->getKey();
        if ($primaryKey === null) {
            /** @var string|null $result */
            $result = $this->attributes['posiz_txt'] ?? $desc1;

            return is_string($result) ? $result : null;
        }

        $this->update(['posiz_txt' => $desc1]);

        /** @var string|null $result */
        $result = $this->attributes['posiz_txt'] ?? $desc1;

        return is_string($result) ? $result : null;
    }

    public function getEmailAttribute(?string $value): ?string
    {
        if ($value !== null && $value !== '') {
            return $value;
        }

        /** @var Anag|null $anag */
        $anag = $this->anag;
        if ($anag instanceof Anag) {
            /** @var string|null $emailFromAnag */
            $emailFromAnag = $anag->email ?? null;
            if ($emailFromAnag !== null && $emailFromAnag !== '') {
                $this->attributes['email'] = $emailFromAnag;

                return $emailFromAnag;
            }
        }

        return '';
    }

    // ... [resto del codice] ...
}
