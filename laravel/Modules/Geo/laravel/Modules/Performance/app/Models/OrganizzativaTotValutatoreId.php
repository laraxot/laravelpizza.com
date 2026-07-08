<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Override;

/**
 * Modello per i totali aggregati per valutatore_id.
 * 
 * Regola: questo modello DEVE estendere il BaseModel locale (Modules\Performance\Models\BaseModel) e NON Modules\Xot\Models\BaseModel, secondo la nuova regola architetturale (vedi docs/organizzativa-models.md e Xot/docs/MIGRATION_BASE_RULES.md).
 *
 * @see https://github.com/laraxot/windsurf
 * @property int $id
 * @property int|null $valutatore_id
 * @property string|null $anno
 * @property float|null $tot_budget_assegnato
 * @property float|null $tot_quota_effettiva
 * @property float|null $tot_resti
 * @property float|null $tot_budget_assegnato_min_punteggio
 * @property float|null $tot_quota_effettiva_min_punteggio
 * @property float|null $tot_resti_min_punteggio
 * @property float|null $delta
 * @property float|null $delta_min_punteggio
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @method static Builder<static>|OrganizzativaTotValutatoreId newModelQuery()
 * @method static Builder<static>|OrganizzativaTotValutatoreId newQuery()
 * @method static Builder<static>|OrganizzativaTotValutatoreId query()
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereAnno($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereCreatedAt($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereCreatedBy($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereDeletedAt($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereDeletedBy($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereDelta($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereDeltaMinPunteggio($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereId($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereTotBudgetAssegnato($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereTotBudgetAssegnatoMinPunteggio($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereTotQuotaEffettiva($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereTotQuotaEffettivaMinPunteggio($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereTotResti($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereTotRestiMinPunteggio($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereUpdatedAt($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereUpdatedBy($value)
 * @method static Builder<static>|OrganizzativaTotValutatoreId whereValutatoreId($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class OrganizzativaTotValutatoreId extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'id', 'valutatore_id', 'anno',
        'tot_budget_assegnato', 'tot_quota_effettiva', 'tot_resti',
        'delta', 'delta_min_punteggio',
        'tot_budget_assegnato_min_punteggio', 'tot_quota_effettiva_min_punteggio', 'tot_resti_min_punteggio',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'valutatore_id' => 'integer',
            'tot_budget_assegnato' => 'float',
            'tot_quota_effettiva' => 'float',
            'tot_resti' => 'float',
            'tot_budget_assegnato_min_punteggio' => 'float',
            'tot_quota_effettiva_min_punteggio' => 'float',
            'tot_resti_min_punteggio' => 'float',
            'delta' => 'float',
            'delta_min_punteggio' => 'float',
        ];
    }
}
