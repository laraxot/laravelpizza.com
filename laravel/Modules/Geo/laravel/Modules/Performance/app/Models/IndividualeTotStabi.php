<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;
use Override;

/**
 * Modules\Performance\Models\IndividualeTotStabi.
 *
 * @property int $id
 * @property int|null $stabi
 * @property string|null $tot_budget_assegnato
 * @property string|null $tot_budget_assegnato_min_punteggio
 * @property string|null $tot_quota_effettiva
 * @property string|null $tot_quota_effettiva_min_punteggio
 * @property string|null $tot_resti
 * @property string|null $tot_resti_min_punteggio
 * @property string|null $delta
 * @property string|null $delta_min_punteggio
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int $n_diritto
 * @property float $n_diritto_excellence
 * @property-read Collection<int, Individuale> $individuali
 * @property-read int|null $individuali_count
 * @method static Builder|IndividualeTotStabi newModelQuery()
 * @method static Builder|IndividualeTotStabi newQuery()
 * @method static Builder|IndividualeTotStabi query()
 * @method static Builder|IndividualeTotStabi whereAnno($value)
 * @method static Builder|IndividualeTotStabi whereCreatedAt($value)
 * @method static Builder|IndividualeTotStabi whereCreatedBy($value)
 * @method static Builder|IndividualeTotStabi whereDelta($value)
 * @method static Builder|IndividualeTotStabi whereDeltaMinPunteggio($value)
 * @method static Builder|IndividualeTotStabi whereId($value)
 * @method static Builder|IndividualeTotStabi whereNDiritto($value)
 * @method static Builder|IndividualeTotStabi whereNDirittoExcellence($value)
 * @method static Builder|IndividualeTotStabi whereStabi($value)
 * @method static Builder|IndividualeTotStabi whereTotBudgetAssegnato($value)
 * @method static Builder|IndividualeTotStabi whereTotBudgetAssegnatoMinPunteggio($value)
 * @method static Builder|IndividualeTotStabi whereTotQuotaEffettiva($value)
 * @method static Builder|IndividualeTotStabi whereTotQuotaEffettivaMinPunteggio($value)
 * @method static Builder|IndividualeTotStabi whereTotResti($value)
 * @method static Builder|IndividualeTotStabi whereTotRestiMinPunteggio($value)
 * @method static Builder|IndividualeTotStabi whereUpdatedAt($value)
 * @method static Builder|IndividualeTotStabi whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class IndividualeTotStabi extends BaseModel
{
    use Updater;

    /** @var string */
    protected $table = 'tot_stabi_performance_individuale';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'stabi',
        'tot_budget_assegnato',
        'tot_budget_assegnato_min_punteggio',
        'tot_quota_effettiva',
        'tot_quota_effettiva_min_punteggio',
        'tot_resti',
        'tot_resti_min_punteggio',
        'delta',
        'delta_min_punteggio',
        'n_diritto_excellence',
        'anno',
    ];

    /** @return array<string, string> */
    #[Override]
    public function casts(): array
    {
        return [
            'id' => 'integer',
            'stabi' => 'integer',
            'anno' => 'integer',
            'tot_budget_assegnato' => 'decimal:2',
            'tot_budget_assegnato_min_punteggio' => 'decimal:2',
            'tot_quota_effettiva' => 'decimal:2',
            'tot_quota_effettiva_min_punteggio' => 'decimal:2',
            'tot_resti' => 'decimal:2',
            'tot_resti_min_punteggio' => 'decimal:2',
            'delta' => 'decimal:2',
            'delta_min_punteggio' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'stabi' => ['required', 'integer', 'exists:stabilimento,id'],
            'anno' => ['required', 'integer', 'min:2000', 'max:2100'],
            'tot_budget_assegnato' => ['nullable', 'numeric', 'min:0'],
            'tot_budget_assegnato_min_punteggio' => ['nullable', 'numeric', 'min:0'],
            'tot_quota_effettiva' => ['nullable', 'numeric', 'min:0'],
            'tot_quota_effettiva_min_punteggio' => ['nullable', 'numeric', 'min:0'],
            'tot_resti' => ['nullable', 'numeric', 'min:0'],
            'tot_resti_min_punteggio' => ['nullable', 'numeric', 'min:0'],
            'delta' => ['nullable', 'numeric'],
            'delta_min_punteggio' => ['nullable', 'numeric'],
            'n_diritto_excellence' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Relazione con le schede individuali dello stesso stabilimento e anno.
     *
     * @return HasMany<Individuale, static>
     */
    public function individuali(): HasMany
    {
        // @phpstan-ignore-next-line
        return $this->hasMany(Individuale::class, 'stabi', 'stabi')
            ->where('anno', $this->anno);
    }

    /**
     * Calcola il numero di dipendenti con diritto alla valutazione.
     */
    public function getNDirittoAttribute(): int
    {
        return 0;
        // return $this->schede->where('ha_diritto', 1)->count();
    }

    /**
     * Calcola il numero di dipendenti con diritto all'excellence
     * (arrotondato per eccesso alla decina).
     */
    public function getNDirittoExcellenceAttribute(): float
    {
        return ceil($this->n_diritto / 10);
    }
}
