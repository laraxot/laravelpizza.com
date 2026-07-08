<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\IndennitaCondizioniLavoro\Models\Traits\MutatorTrait;
use Modules\IndennitaCondizioniLavoro\Models\Traits\RelationshipTrait;
use Modules\Ptv\Models\Profile;
use Modules\Ptv\Models\Traits\HasValutatore;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Repart;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrAnnoMutator;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrDateRangeMutator;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrMutator;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrAnnoRelationship;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrDateRangeRelationship;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;
use Modules\Sigma\Models\Traits\SigmaModelTrait;
use Modules\Sigma\Models\Wstr01lx;
use Illuminate\Support\Facades\DB;
use Modules\Sigma\Models\Contracts\DateRangeFieldsContract;
use Modules\Sigma\Models\Contracts\EnteMatrFieldsContract;

/**
 * Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro.
 *
 * @property int|null $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $email
 * @property string|null $cognome
 * @property string|null $nome
 * @property int|null $trimestre
 * @property int|null $stabi
 * @property string|null $stabi_txt
 * @property int|null $repar
 * @property string|null $repar_txt
 * @property int|null $propro
 * @property int|null $posfun
 * @property string|null $categoria_eco
 * @property int|null $posiz
 * @property string|null $posiz_txt
 * @property int|null $gg_presenza_anno
 * @property int|null $gg_presenza_periodo
 * @property int|null $gg_assenza_anno
 * @property string|null $hh_assenza_anno
 * @property int|null $gg_trasferte_anno
 * @property int|null $anno
 * @property int|null $rep2kd
 * @property int|null $rep2ka
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property \Illuminate\Support\Carbon|null $dal
 * @property \Illuminate\Support\Carbon|null $al
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int $disci1
 * @property string $disci1_txt
 * @property int $codqua
 * @property string $codqua_txt
 * @property int $tot_presenza_periodo_plus_no_timbr
 * @property float|null $tot
 * @property int|null $valutatore_id
 * @property int|null $quadrimestre
 * @property Collection<int, Sto00f> $Sto00fYear
 * @property int|null $sto00f_year_count
 * @property Collection<int, Ana02f> $ana02f
 * @property int|null $ana02f_count
 * @property Ana10f|null $ana10f
 * @property Anag|null $anag
 * @property Collection<int, Asz00f> $asz00f
 * @property-read Collection<int, IndennitaTipoDettaglio> $indennitaTipoDettaglio
 * @property int|null $asz00f_count
 * @property Collection<int, Asz00k1> $asz00k1
 * @property int|null $asz00k1_count
 * @property Collection<int, Asz00k1> $asz00k1Year
 * @property int|null $asz00k1_year_count
 * @property mixed $all_indennita_tipo
 * @property string $from_field
 * @property int|float $gg_p_time_vert_year
 * @property mixed $gg_parttimevert_anno
 * @property int|null $gg_parttimevert
 * @property mixed $gg_parttimevert_dalal
 * @property mixed $gg_presenza_dalal
 * @property \Illuminate\Support\Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio> $indennita_tipo_dettaglio_all
 * @property mixed $last_data_assunz
 * @property int|float $perc_p_time_daterange
 * @property int|float $perc_p_time_year
 * @property mixed $perc_parttime_anno
 * @property float|null $perc_parttime
 * @property mixed $perc_parttime_dalal
 * @property mixed $titolo_di_studio
 * @property string $to_field
 * @property float|null $tot_x_ptime
 * @property Collection<int, IndennitaTipoDettaglio> $indennitaTipoDettaglio
 * @property int|null $indennita_tipo_dettaglio_count
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
 * @property Collection<int, IndennitaTipoDettaglio> $tipoDettaglio
 * @property int|null $tipo_dettaglio_count
 * @property Collection<int, Wstr01lx> $wstr01lx
 * @property int|null $wstr01lx_count
 * @property Collection<int, Wstr01lx> $wstr01lxYear
 * @property int|null $wstr01lx_year_count
 * @method static Builder|CondizioniLavoro newModelQuery()
 * @method static Builder|CondizioniLavoro newQuery()
 * @method static Builder|CondizioniLavoro ofDate(int $date)
 * @method static Builder|CondizioniLavoro ofEnteYear(int $ente, int $year)
 * @method static Builder|CondizioniLavoro ofQuarter(int $quarter, int $year)
 * @method static Builder|CondizioniLavoro ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|CondizioniLavoro ofYear(int $year)
 * @method static Builder|CondizioniLavoro query()
 * @method static Builder|CondizioniLavoro whereAl($value)
 * @method static Builder|CondizioniLavoro whereAnno($value)
 * @method static Builder|CondizioniLavoro whereCategoriaEco($value)
 * @method static Builder|CondizioniLavoro whereCodqua($value)
 * @method static Builder|CondizioniLavoro whereCodquaTxt($value)
 * @method static Builder|CondizioniLavoro whereCognome($value)
 * @method static Builder|CondizioniLavoro whereCreatedAt($value)
 * @method static Builder|CondizioniLavoro whereCreatedBy($value)
 * @method static Builder|CondizioniLavoro whereDal($value)
 * @method static Builder|CondizioniLavoro whereDisci1($value)
 * @method static Builder|CondizioniLavoro whereDisci1Txt($value)
 * @method static Builder|CondizioniLavoro whereEmail($value)
 * @method static Builder|CondizioniLavoro whereEnte($value)
 * @method static Builder|CondizioniLavoro whereGgAssenzaAnno($value)
 * @method static Builder|CondizioniLavoro whereGgPresenzaAnno($value)
 * @method static Builder|CondizioniLavoro whereGgPresenzaPeriodo($value)
 * @method static Builder|CondizioniLavoro whereGgTrasferteAnno($value)
 * @method static Builder|CondizioniLavoro whereHhAssenzaAnno($value)
 * @method static Builder|CondizioniLavoro whereId($value)
 * @method static Builder|CondizioniLavoro whereMatr($value)
 * @method static Builder|CondizioniLavoro whereNome($value)
 * @method static Builder|CondizioniLavoro wherePosfun($value)
 * @method static Builder|CondizioniLavoro wherePosiz($value)
 * @method static Builder|CondizioniLavoro wherePosizTxt($value)
 * @method static Builder|CondizioniLavoro wherePropro($value)
 * @method static Builder|CondizioniLavoro whereQua2ka($value)
 * @method static Builder|CondizioniLavoro whereQua2kd($value)
 * @method static Builder|CondizioniLavoro whereQuadrimestre($value)
 * @method static Builder|CondizioniLavoro whereRep2ka($value)
 * @method static Builder|CondizioniLavoro whereRep2kd($value)
 * @method static Builder|CondizioniLavoro whereRepar($value)
 * @method static Builder|CondizioniLavoro whereReparTxt($value)
 * @method static Builder|CondizioniLavoro whereStabi($value)
 * @method static Builder|CondizioniLavoro whereStabiTxt($value)
 * @method static Builder|CondizioniLavoro whereTot($value)
 * @method static Builder|CondizioniLavoro whereTotPresenzaPeriodoPlusNoTimbr($value)
 * @method static Builder|CondizioniLavoro whereTrimestre($value)
 * @method static Builder|CondizioniLavoro whereUpdatedAt($value)
 * @method static Builder|CondizioniLavoro whereUpdatedBy($value)
 * @method static Builder|CondizioniLavoro whereValutatoreId($value)
 * @method static Builder|CondizioniLavoro withDays(int $date_min, int $date_max)
 * @property-read Profile|null $creator
 * @property-read string|null $codice_fiscale
 * @property-read string|null $inail
 * @property-read string|null $sesso
 * @property-read CondizioniLavoroIndennitaTipoDettaglioPivot|null $pivot
 * @property-read Profile|null $updater
 * @method static Builder<static>|CondizioniLavoro ofEnte(int $ente)
 * @method static Builder<static>|CondizioniLavoro ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @property-read Profile|null $deleter
 * @property-read Collection<int, \Modules\Sigma\Models\Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read \Modules\IndennitaCondizioniLavoro\Models\StabiDirigente|null $valutatore
 * @mixin \Eloquent
 */
class CondizioniLavoro extends BaseModel implements DateRangeFieldsContract, EnteMatrFieldsContract
{
    use EnteMatrMutator;
    use HasValutatore;
    use MutatorTrait, RelationshipTrait, SigmaModelTrait {
        MutatorTrait::getFromFieldAttribute insteadof SigmaModelTrait;
        MutatorTrait::getToFieldAttribute insteadof SigmaModelTrait;
    }
    // use EnteMatrRelationship;
    // use EnteMatrDateRangeRelationship;
    // use EnteMatrDateRangeMutator;
    // use EnteMatrAnnoRelationship;
    // use EnteMatrAnnoMutator;

    /** @var string */
    protected $table = 'condizioni_lavoro';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'ente',
        'matr',
        'cognome',
        'nome',
        'email',
        'stabi',
        'stabi_txt',
        'repar',
        'repar_txt',
        'propro',
        'posfun',
        'categoria_eco',
        'gg_presenza_anno',
        'gg_assenza_anno',
        'gg_trasferte_anno',
        'anno',
        'trimestre',
        'quadrimestre',
        'dal',
        'al',
        'rep2kd',
        'rep2ka',
        'qua2kd',
        'qua2ka',
        'gg_presenza_periodo',
        'tot_presenza_periodo_plus_no_timbr',
        'valutatore_id',
    ];

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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function rangeFromField(): string
    {
        return 'dal';
    }

    public function rangeToField(): string
    {
        return 'al';
    }

    public function annFieldName(): string
    {
        return 'anno';
    }

    public function matrField(): string
    {
        return 'matr';
    }

    public function enteField(): string
    {
        return 'ente';
    }

    public function yearField(): string
    {
        return 'anno';
    }

    // ------ relationship ----------
    /* WIP
    public function indennitaTipo(): void {
    return $this->hasManyThrough(IndennitaTipo::class, CondizioniLavoroIndennitaTipoDettaglioPivot::class);
    }
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio, $this, \Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroIndennitaTipoDettaglioPivot, 'pivot'>
     */
    public function tipoDettaglio(): BelongsToMany
    {
        // /*
        // return $this->hasMany(CondizioniLavoroIndennitaTipoDettaglioPivot::class);
        $cross = 'condizioni_lavoro_x_indennita_tipo_dettaglio';
        $pivot_fields = ['gg'];

        return $this->belongsToMany(IndennitaTipoDettaglio::class, $cross)
            ->using(CondizioniLavoroIndennitaTipoDettaglioPivot::class)
            ->withPivot($pivot_fields);
        // */
        // return $this->belongsToManyX(IndennitaTipoDettaglio::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio, $this, \Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroIndennitaTipoDettaglioPivot, 'pivot'>
     */
    public function indennitaTipoDettaglio(): BelongsToMany
    {
        $cross = 'condizioni_lavoro_x_indennita_tipo_dettaglio';
        $pivot_fields = 'gg';

        return $this->belongsToMany(IndennitaTipoDettaglio::class, $cross)
            ->using(CondizioniLavoroIndennitaTipoDettaglioPivot::class)
            ->withPivot($pivot_fields);
    }

    

    // -------- mutators ------------

    public function getTotAttribute(?float $value): ?float
    {
        $tot = 0;
        foreach ($this->indennitaTipoDettaglio as $indennitumTipoDettaglio) {
            /** @var CondizioniLavoroIndennitaTipoDettaglioPivot|null $pivot */
            $pivot = $indennitumTipoDettaglio->pivot;
            if ($pivot && $indennitumTipoDettaglio->euro_giorno !== null && $pivot->gg !== null) {
                $tot += (float) $indennitumTipoDettaglio->euro_giorno * (int) $pivot->gg;
            }
        }

        $this->tot = $tot;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $tot;
        }

        $this->update([
            'tot' => $tot,
        ]);

        return $tot;
    }

    public function getTotXPtimeAttribute(?float $value): ?float
    {
        $tot = $this->tot;
        $ptime = $this->perc_p_time_daterange;

        return $tot * $ptime;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Sigma\Models\Repart, $this>
     */
    public function reparts(): HasMany
    {
        return $this->hasMany(Repart::class, 'stabi', 'stabi')
            ->where('ente', $this->ente);
    }

    public function getReparTxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        if (! \is_object($this->reparts)) {
            return null;
        }

        $repart = $this->reparts->where('repar', $this->repar)->first();
        if ($repart === null) {
            // dddx($this->stabi.' '.$this->repar);
            return '['.$this->stabi.' '.$this->repar.']';
        }

        return $repart->dest1;
    }

    /**
     * Get disci1 attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    public function getDisci1Attribute(?int $value): ?int
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_int($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculateDisci1();
    }

    /**
     * Calcola disci1.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateDisci1(): ?int
    {
        $qua00f_curr = $this->qua00fDaterange->first();
        if (! \is_object($qua00f_curr)) {
            return null;
        }

        $disci1 = $qua00f_curr->getAttribute('disci1');

        return is_numeric($disci1) ? (int) $disci1 : null;
    }

    /**
     * Get codqua attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    public function getCodquaAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_string($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculateCodqua();
    }

    /**
     * Calcola codqua.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateCodqua(): string
    {
        $qua00f_curr = $this->qua00fDaterange->first();
        if (! $qua00f_curr instanceof Qua00f) {
            return '---';
        }

        $codqua = $qua00f_curr->getAttribute('codqua');

        return is_string($codqua) ? $codqua : (string) $codqua;
    }

    /**
     * Get all_indennita_tipo attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    /**
     * @param  \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipo>|null  $value
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipo>
     */
    public function getAllIndennitaTipoAttribute(?Collection $value): Collection
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if ($value instanceof Collection) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculateAllIndennitaTipo();
    }

    /**
     * Calcola all_indennita_tipo.
     *
     * Metodo separato per il calcolo complesso.
     */
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipo>
     */
    protected function calculateAllIndennitaTipo(): Collection
    {
        return IndennitaTipo::all();
    }

    /**
     * Get tot_presenza_periodo_plus_no_timbr attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    public function getTotPresenzaPeriodoPlusNoTimbrAttribute(?int $value): ?int
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_int($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculateTotPresenzaPeriodoPlusNoTimbr();
    }

    /**
     * Calcola tot_presenza_periodo_plus_no_timbr.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateTotPresenzaPeriodoPlusNoTimbr(): int
    {
        $ggPresenza = $this->gg_presenza_periodo ?? 0;

        return max($ggPresenza, 0);
    }

    /**
     * Get gg_assenza_anno attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE con ActivityLog-Safe
     */
    public function getGgAssenzaAnnoAttribute(?int $value): ?int
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_int($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->calculateGgAssenzaAnno();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($this->getKey() !== null) {
           
                    static::withoutEvents(function () use ($value): void {
                        $this->update(['gg_assenza_anno' => $value]);
                    });
                
                
                
        }

        return $value;
    }

    /**
     * Calcola gg_assenza_anno.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateGgAssenzaAnno(): int
    {
        $asz = $this->asz00k1()->where('aszumi', 'G')
            ->get();

        return (int) $asz->sum('aszdur');
    }

    /**
     * Get hh_assenza_anno attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE con ActivityLog-Safe
     */
    public function getHhAssenzaAnnoAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_string($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->calculateHhAssenzaAnno();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($this->getKey() !== null) {
           
                    static::withoutEvents(function () use ($value): void {
                        $this->update(['hh_assenza_anno' => $value]);
                    });
                
                
                
        }

        return $value;
    }

    /**
     * Calcola hh_assenza_anno.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateHhAssenzaAnno(): string
    {
        $asz = $this->asz00k1()->where('aszumi', 'O')
            ->whereRaw(DB::raw('concat(asztip,"-",aszcod) != "504-13"')) // nelle assenze tolgo le trasferte
            ->get();

        return (string) $asz->sum('aszdur');
    }

    /*
    public function getCognomeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        if ($this->anag == null) {
            return null;
        }

        $value = $this->anag->conome;
        $this->cognome = $value;
        $this->nome = $this->anag->nome;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $value;
        }

        $this->update([
            'cognome' => $value,
            'nome' => $this->anag->nome,
        ]);

        return $value;
    }

    public function getNomeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        if ($this->anag == null) {
            return null;
        }

        $value = $this->anag->nome;
        $this->nome = $value;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return $value;
        }

        $this->update([
            'nome' => $value,
        ]);

        return $value;
    }
    */

    // --------- function -----------

    /**
     * @param array<string, mixed> $params
     */
    public static function populate(array $params): void
    {
        // $params=array_merge(getRouteParameters(),$params);
        $anno = 0;
        $stabi = 0;
        $repar = 0;
        extract($params);

        $sql = '(
    		('.$anno.' between year(rep2kd) and year(rep2ka))
    		or
    		('.$anno.' >= year(rep2kd) and rep2ka=0)
    	)';
        $rows0 = Rep00f::where('repst1', $stabi)->where('repre1', $repar)->whereRaw($sql)->whereRaw('repann=""');
        foreach ($rows0->get() as $row) {
            $rep2kd = \is_object($row->rep2kd) ? $row->rep2kd->format('Ymd') : (string) $row->rep2kd;
            $rep2ka = (\is_object($row->rep2ka)) ? $row->rep2ka->format('Ymd') : (string) $row->rep2ka;
            $parz = ['ente' => $row->ente,
                'matr' => $row->matr,
                'stabi' => $row->repst1,
                'repar' => $row->repre1,
                'rep2kd' => $rep2kd,
                'rep2ka' => $rep2ka,
                'anno' => $anno, ];

            $obj = self::firstOrCreate($parz);
            $obj->rep2kd = $row->rep2kd;
            $obj->rep2ka = $row->rep2ka;
            $obj->anno = $anno;
            if ($obj->dal === null) {
                $obj->dal = Carbon::createFromDate($anno, 1, 1);
            }

            if ($obj->al === null) {
                $obj->al = Carbon::createFromDate($anno, 12, 31);
            }

            if ($obj->propro === 0 || $obj->propro === null) {
                $dalFormatted = $obj->dal instanceof Carbon ? $obj->dal->format('Ymd') : '';
                $alFormatted = $obj->al instanceof Carbon ? $obj->al->format('Ymd') : '';

                $qua00fDateRangeSql = <<<'SQL'
(
    (? between qua2kd and qua2ka )
    or
    (? >= qua2kd and qua2ka=0 )
    or
    (? between qua2kd and qua2ka )
    or
    (? >= qua2kd and qua2ka=0 )
    or
    (qua2kd between ? and ?)
    or
    (qua2ka between ? and ?)
)
SQL;
                $qua00fDateRangeBindings = [
                    $dalFormatted,
                    $dalFormatted,
                    $alFormatted,
                    $alFormatted,
                    $dalFormatted,
                    $alFormatted,
                    $dalFormatted,
                    $alFormatted,
                ];
                if ($obj->anag && method_exists($obj->anag, 'qua00f')) {
                    $qua00f = $obj->anag->qua00f()->select('propro', 'posfun', 'posiz')->distinct()->whereRaw(DB::raw($qua00fDateRangeSql), $qua00fDateRangeBindings);
                    // echo '<br/>'.$qua00f->count().' - '.$qua00f->first()->propro.'  - '.$qua00f->first()->posfun;
                    if ($qua00f->get()->count() === 1) {
                        $first = $qua00f->first();
                        if ($first instanceof Model) {
                            $propro = $first->getAttribute('propro');
                            $posfun = $first->getAttribute('posfun');
                            $posiz = $first->getAttribute('posiz');

                            $obj->propro = is_numeric($propro) ? (int) $propro : null;
                            $obj->posfun = is_numeric($posfun) ? (int) $posfun : null;
                            $obj->posiz = is_numeric($posiz) ? (int) $posiz : null;
                        }
                    } else {
                        echo '<br/>$qua00f->count() : '.$qua00f->count();
                        echo '<br/>ente :'.$obj->ente;
                        echo '<br/>matr :'.$obj->matr;
                        echo "<br/>qualcosa e' andato storto [".__LINE__.']['.__FILE__.']';
                        echo '<pre>';
                        print_r($qua00f->toSql());

                        $qua00f = $obj->anag->qua00f()->whereRaw(DB::raw($qua00fDateRangeSql), $qua00fDateRangeBindings)->orderBy('qua2kd')->get();

                        $al_old = $obj->al;
                        if ($qua00f->count() > 0 && isset($qua00f[0]->qua2kd)) {
                            $value = is_string($qua00f[0]->qua2kd) || is_numeric($qua00f[0]->qua2kd) ? $qua00f[0]->qua2kd : null;
                            if ($value !== null) {
                                $obj->al = Carbon::parse($value);
                            }
                        }
                        $obj->save();

                        if ($qua00f->count() > 1) {
                            $obj1 = $obj->replicate();
                            if (isset($qua00f[1]->qua2kd)) {
                                $value = is_string($qua00f[1]->qua2kd) || is_numeric($qua00f[1]->qua2kd) ? $qua00f[1]->qua2kd : null;
                                if ($value !== null) {
                                    $obj1->dal = Carbon::parse($value);
                                }
                            }
                            // Type narrowing: ensure qua00f[1] exists and is Model
                            if (isset($qua00f[1]) && $qua00f[1] instanceof Model) {
                                $qua2kaValue = $qua00f[1]->getAttribute('qua2ka');
                                if (is_string($qua2kaValue) || is_numeric($qua2kaValue)) {
                                    $obj1->al = $qua2kaValue !== 0 ? Carbon::parse($qua2kaValue) : $al_old;
                                } else {
                                    $obj1->al = $al_old;
                                }
                            }
                        }
                    }
                    if (isset($obj1) && $obj1 instanceof self) {
                        // Replicated models are treated as new records by Eloquent, just save
                        $obj1->save();
                    }
                }
            }

            $obj->save();
        }
    }

    // end function

    /**
     * Undocumented function.
     */
    public function getValutatoreIdAttribute(?int $value): ?int
    {
        if ($value > 100) {
            // dddx($value);

            return $value;
        }

        // dddx($this->attributes['valutatore_id']);

        $stabi_diri = $this->stabiDirigente;
        if (! \is_object($stabi_diri)) {
            return $value;
        }

        $valutatore_id = $stabi_diri->valutatore_id;
        if ($valutatore_id !== null) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            if ($this->getKey() !== null) {
                $this->update(['valutatore_id' => $valutatore_id]);
            }

            return (int) $valutatore_id;
        }

        $stabi = StabiDirigente::firstOrCreate(
            [
                'anno' => $this->anno,
                'stabi' => $this->stabi,
                'repar' => 0,
            ]
        );
        if ($stabi->valutatore_id === null) {
            $stabi->valutatore_id = $stabi->id;
            $stabi->save();
        }

        $valutatore_id = $stabi->valutatore_id;

        // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
        if ($this->getKey() !== null) {
            $this->update(['valutatore_id' => $valutatore_id]);
        }

        return (int) $valutatore_id;
    }

    public function getNextQuadrimestre(): ?CondizioniLavoro
    {
        $where = [
            'quadrimestre' => $this->quadrimestre + 1,
            'anno' => $this->anno,
            'ente' => $this->ente,
            'matr' => $this->matr,
            // 'valutatore_id' => $this->valutatore_id,
        ];
        if ($where['quadrimestre'] >= 4) {
            $where['quadrimestre'] -= 3;
            $where['anno'] += 1;
        }

        

        return CondizioniLavoro::firstWhere($where);
    }
}// end class
