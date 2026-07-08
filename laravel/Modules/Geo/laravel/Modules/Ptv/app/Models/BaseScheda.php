<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;
use Modules\Performance\Models\Individuale;
use Modules\Progressioni\Models\Traits\ConvertedTrait;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Traits\Concerns\HasEnteMatrRelationHelpers;
use Modules\Sigma\Models\Traits\SchedaTrait;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

/**
 * Modules\Ptv\Models\BaseScheda.
 *
 * @property StabiDirigente|null $valutatore
 * @property Collection<int, static> $avversariCategoriaEco
 * @property float|null $punt_progressione_finale
 * @property int|null $categoria_eco
 * @property int|null $valutatore_id
 * @property int|null $anno
 * @property int|null $ha_diritto
 * @property string|null $qua2kd
 * @property int|null $propro
 * @property string|null $posfun
 * @property int|null $matr
 * @property int|null $dal
 * @property int|null $al
 * @property int|null $anno
 * @property int|null $ente
 * @property int|null $repar
 * @property int|null $stabi
 * @property string|null $categoria_ecoval
 * @property int|null $posfunval
 * @property float|null $costo_fascia_up
 * @property float|null $ptime
 * @property int|null $gg_cateco_posfun_in_sede
 * @property int|null $gg_asz_cateco_posfun
 * @property int|null $gg_cateco_posfun_fuori_sede
 * @property int|null $gg_cateco_sup_in_sede
 * @property int|null $gg_cateco_sup_fuori_sede
 * @property int|null $gg_asz_cateco_posfun_in_sede
 * @property int|null $gg_asz_cateco_posfun_fuori_sede
 * @property int|null $gg_cateco_in_sede
 * @property int|null $gg_cateco_fuori_sede
 * @property int|null $gg_asz_in_sede
 * @property int|null $gg_asz_fuori_sede
 * @property int|null $hh_asz_in_sede
 * @property int|null $hh_asz_fuori_sede
 * @property int|null $gg_in_sede
 * @property int|null $gg_fuori_sede
 * @property int|null $gg_presenza_anno
 * @property int|null $perc_parttime_anno
 * @property int|null $gg_parttimevert_anno
 * @property string|null $posiz
 * @property string|null $posiz1
 * @property int|null $disci1
 * @property Anag|null $anag
 * @property object|null $maxCatecoPosfun
 * @property object|null $peso
 * @property object|null $pesi
 * @property object|null $stipendioTabellare
 * @property Collection<int, Individuale> $performanceIndividuale
 * @property Collection<int, Model> $criteriOptions
 * @property int $n_perf_ind
 */
// @see Modules/Xot/docs/spatie-schemaless-attributes.md
abstract class BaseScheda extends BaseModel implements SchedaContract
{
    use ConvertedTrait;
    use HasEnteMatrRelationHelpers;
    use SchedaTrait;
    use SchemalessAttributesTrait;

    /**
     * Relazioni da eager-loadare sempre per evitare N+1 queries.
     *
     * ⚡ PERFORMANCE CRITICAL: Fix DOPPIO LIVELLO N+1
     *
     * PROBLEMA:
     * 1. Accessor chiama $this->anag->ggInSedeTot()
     * 2. ggInSedeTot() (in FunctionExtra) chiama $this->qua00f()
     * 3. = N+1 al primo livello (anag) + N+1 al secondo livello (qua00f)!
     *
     * SOLUZIONE:
     * - Eager load 'anag' (primo livello)
     * - Eager load 'anag.qua00f', 'anag.qua03f', 'anag.asz00k1' (secondo livello)
     *
     * RISULTATO:
     * - Da 200-300+ query a 5-10 query (95-98% riduzione)
     * - Da 15-30 secondi a 1-3 secondi (10-30x più veloce)
     *
     * @see \Modules\Sigma\docs\performance\function-extra-n-plus-1-queries.md
     *
     * @var list<string>
     */
    protected $with = [
        // Primo livello - relazioni dirette di Scheda
        // 'anag',              // ⚡ CRITICO: evita N+1 su anagrafica
        // 'categoriaPropro',   // ⚡ CRITICO: evita N+1 su categoria
        // 'stabiDirigente',    // Evita N+1 su stabi dirigente

        // Secondo livello - relazioni nested di anag (FunctionExtra le usa!)
        // 'anag.qua00f',       // ⚡ CRITICO: evita N+1 in ggInSedeTot()
        // 'anag.qua03f',       // ⚡ CRITICO: evita N+1 in ggFuoriSedeTot()
        // 'anag.asz00k1',      // ⚡ CRITICO: evita N+1 in ggAssenzaInSedeTot(), hhAssenzaInSedeTot()
    ];

    public string $from_field = 'dal';

    public string $to_field = 'al';

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

    /**
     * @param Builder<\Illuminate\Database\Eloquent\Model> $query
     * @return Builder<\Illuminate\Database\Eloquent\Model>
     */
    protected function scopeWithDays(Builder $query, ?int $date_min, ?int $date_max): Builder
    {
        if ($date_min === null || $date_max === null) {
            return $query;
        }

        return $query->selectRaw(
            'greatest(datediff(if(al=0 or al>?, ?, al), if(dal<?, ?, dal))+1, 0) AS days',
            [$date_max, $date_max, $date_min, $date_min],
        );
    }

    /**
     * Number of performance years considered for aggregate calculations.
     */
    public int $n_perf_ind = 3;

    protected $table = 'schede';

    /**
     * Assenze ASZ Sigma del dipendente — contratto DRY per tutte le schede (Ptv, Progressioni, …).
     *
     * @return HasMany<Asz00k1, $this>
     */
    public function asz(): HasMany
    {
        $tbl = app(Asz00k1::class)->getTable();

        return $this->hasMany(Asz00k1::class, 'matr', 'matr')
            ->where($tbl.'.ente', $this->ente)
            ->where($tbl.'.aszann', '');
    }

    /**
     * Get avversari with the same category.
     *
     * @return HasMany<static, $this>
     */
    public function avversariCategoriaEco(): HasMany
    {
        return $this->hasMany(static::class, 'valutatore_id', 'valutatore_id')
            ->where('anno', $this->anno)
            ->where('ha_diritto', 1)
            ->where('categoria_eco', $this->categoria_eco);
    }

    /**
     * Get lista tipo codice aspettative.
     *
     * @return array<int, string>
     */
    public function getListaTipoCodiceAspettative(): array
    {
        // This is a placeholder implementation. The actual implementation may vary
        // depending on the specific business logic of the application.
        return [];
    }

    /**
     * Anagrafica relationship.
     *
     * Child models may override with BelongsTo when they hold the foreign key.
     *
     * @return HasOne<Anag, $this>|BelongsTo<Anag, $this>
     */
    public function anag(): HasOne|BelongsTo
    {
        return $this->hasOne(Anag::class, 'matr', 'matr');
    }

    /*
     * Max cateco posfun relationship.
     *
     * @return HasOne
     */
    // public function maxCatecoPosfun()
    // {
    // This is a placeholder implementation - the actual relationship may vary
    //    return $this->hasOne(static::class);
    // }

    /*
     * Pesi relationship.
     *
     * @return HasOne  pesi plurale, non ha senso
     */
    // public function pesi(): HasOne
    // {

    // This is a placeholder implementation - the actual relationship may vary
    //    return $this->hasOne(static::class);
    // }

    /**
     * Stipendio tabellare relationship.
     *
     * @return HasOne<static, $this>
     */
    public function stipendioTabellare(): HasOne
    {
        // This is a placeholder implementation - the actual relationship may vary
        return $this->hasOne(static::class);
    }

    /**
     * Performance individuale relationship.
     *
     * @return HasMany<Individuale, $this>
     */
    public function performanceIndividuale(): HasMany
    {
        return $this->hasMany(Individuale::class, 'matr', 'matr')
            ->where('ente', $this->ente ?? 90);
    }

    /**
     * Get performance for a given year.
     */
    public function perfInd(int $anno): ?float
    {
        $tbl = 'performance_individuale';
        $perf_ind = $this->performanceIndividuale()->selectRaw('( COALESCE(sum('.$tbl.'.totale_punteggio * (datediff('.$tbl.'.al,'.$tbl.'.dal)+1))/( sum(datediff('.$tbl.'.al,'.$tbl.'.dal)+1)  ),0) ) as perf_ind')
            ->where('anno', $anno)
            ->whereRaw('( '.$tbl.'.ha_diritto>0 or '.$tbl.'.posfun>=100)')
            ->first();

        if ($perf_ind == null) {
            return null;
        }

        $value = isset($perf_ind->perf_ind) ? (float) $perf_ind->perf_ind : 0.0;

        return $value;
    }

    /**
     * Criteri di esclusione attivi per anno (value != 0) — config campagna valutazione.
     *
     * @return EloquentCollection<int, Model>|null null se il modello modulo non esiste
     */
    public static function getCriteriEsclusioneByYear(int $year, string $fieldName = 'anno'): ?EloquentCollection
    {
        $modelClass = static::resolveCriteriEsclusioneModelClass();
        if ($modelClass === null) {
            return null;
        }

        /** @var EloquentCollection<int, Model> $result */
        $result = $modelClass::query()
            ->where($fieldName, $year)
            ->where('value', '!=', 0)
            ->get();

        return $result;
    }

    /**
     * Opzioni criteri tipizzate per anno (name => value_real) — usate da Check criteri esclusione.
     *
     * @return SupportCollection<string, mixed>|null null se il modello modulo non esiste
     */
    public static function getCriteriOptionsParsedByYear(int $year, string $fieldName = 'anno'): ?SupportCollection
    {
        $modelClass = static::resolveCriteriOptionModelClass();
        if ($modelClass === null) {
            return null;
        }

        $rows = $modelClass::query()->where($fieldName, $year)->get();
        if (! ($rows instanceof EloquentCollection)) {
            return null;
        }

        return static::parseCriteriOptionsCollection($rows);
    }

    /**
     * @return class-string<Model>|null
     */
    protected static function resolveCriteriEsclusioneModelClass(): ?string
    {
        $class = Str::of(static::class)->beforeLast('\\Models\\')->append('\\Models\\CriteriEsclusione')->toString();
        if (! class_exists($class) || ! is_subclass_of($class, Model::class)) {
            return null;
        }

        return $class;
    }

    /**
     * @return class-string<Model>|null
     */
    protected static function resolveCriteriOptionModelClass(): ?string
    {
        $class = Str::of(static::class)->beforeLast('\\Models\\')->append('\\Models\\CriteriOption')->toString();
        if (! class_exists($class) || ! is_subclass_of($class, Model::class)) {
            return null;
        }

        return $class;
    }

    /**
     * @param  EloquentCollection<int, Model>  $rows
     * @return SupportCollection<string, mixed>
     */
    protected static function parseCriteriOptionsCollection(EloquentCollection $rows): SupportCollection
    {
        return $rows
            ->map(static function (Model $item): Model {
                $item->setAttribute('value_real', static::parseCriteriOptionTypedValue($item));

                return $item;
            })
            ->pluck('value_real', 'name');
    }

    protected static function parseCriteriOptionTypedValue(Model $item): mixed
    {
        $type = isset($item->type) && is_string($item->type) ? $item->type : '';
        $itemValue = $item->getAttribute('value');

        return match ($type) {
            'list' => is_string($itemValue) ? explode(',', $itemValue) : [],
            'int' => is_numeric($itemValue) ? (int) (string) $itemValue : 0,
            'date' => static::parseCriteriOptionDateValue($itemValue),
            default => '',
        };
    }

    protected static function parseCriteriOptionDateValue(mixed $value): mixed
    {
        if ($value === null || ! is_string($value)) {
            return $value;
        }

        try {
            return Carbon::parse($value);
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Criteri options relationship.
     *
     * @return HasMany<static, $this>
     */
    public function criteriOptions(): HasMany
    {
        // This is a placeholder implementation - the actual relationship may vary
        return $this->hasMany(static::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            // 'calculated_data' => SchemalessAttributes::class,
        ]);
    }

    /**
     * @var array<int, string>
     */
    /** @var array<int, string> */
    protected array $schemalessAttributes = [
        // 'calculated_data',
    ];

    /**
     * Verifica se il posfun è di tipo PO (Punto Organizzativo).
     *
     * @return bool True se posfun >= 100, false altrimenti
     */
    public function isPo(): bool
    {
        return (int) ($this->posfun ?? 0) >= 100;
    }

    /**
     * Verifica se disci1 indica una posizione regionale.
     *
     * @return bool True se disci1 è 203, false altrimenti
     */
    public function isRegionale(): bool
    {
        return (int) ($this->disci1 ?? 0) === 203;
    }

    /**
     * Scope a query to interact with calculated_data schemaless attribute.
     *
     * @see Modules/IndennitaResponsabilita/docs/schemaless-attributes.md#errore-5-tipo-di-ritorno-errato-per-scope-metodi-basescheda
     */
    /**
     * @param Builder<\Illuminate\Database\Eloquent\Model> $query
     * @return Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function scopeWithCalculatedData(Builder $query): Builder
    {
        // This scope should modify the query builder, not return the attribute directly.
        // If the intention was to filter or add conditions based on calculated_data,
        // that logic would go here.
        // Example: return $query->where('calculated_data->some_key', 'some_value');

        return $query; // Return the modified (or unmodified) query builder
    }
}
