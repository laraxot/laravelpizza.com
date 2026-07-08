<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Override;

/**
 * Modello aggregato per i totali individuali per valutatore_id.
 * 
 * Regola: questo modello DEVE estendere il BaseModel locale (Modules\Performance\Models\BaseModel) e NON Modules\Xot\Models\BaseModel, secondo la nuova regola architetturale (vedi docs/individuale-money-pipeline.md e Xot/docs/MIGRATION_BASE_RULES.md).
 *
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
 * @property string $type
 * @property float $tot_importo_totale
 * @property float $tot_totale_punteggio
 * @property float $tot_importo_totale_min_punteggio
 * @property float $tot_totale_punteggio_min_punteggio
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Valutatore|null $valutatore
 * @method static Builder<static>|IndividualeTotValutatoreId newModelQuery()
 * @method static Builder<static>|IndividualeTotValutatoreId newQuery()
 * @method static Builder<static>|IndividualeTotValutatoreId query()
 * @method static Builder<static>|IndividualeTotValutatoreId whereAnno($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereCreatedAt($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereCreatedBy($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereDeletedAt($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereDeletedBy($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereDelta($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereDeltaMinPunteggio($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereId($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotBudgetAssegnato($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotBudgetAssegnatoMinPunteggio($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotImportoTotale($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotImportoTotaleMinPunteggio($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotQuotaEffettiva($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotQuotaEffettivaMinPunteggio($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotResti($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotRestiMinPunteggio($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotTotalePunteggio($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereTotTotalePunteggioMinPunteggio($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereType($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereUpdatedAt($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereUpdatedBy($value)
 * @method static Builder<static>|IndividualeTotValutatoreId whereValutatoreId($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class IndividualeTotValutatoreId extends BaseModel
{
    /**
     * Nome tabella esplicito per evitare errori di pluralizzazione Laravel.
     * Regola: i modelli aggregati devono sempre specificare il nome tabella se non segue la convenzione standard.
     */
    protected $table = 'individuale_tot_valutatore_id';

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

    /**
     * @return BelongsTo<Valutatore, $this>
     */
    public function valutatore(): BelongsTo
    {
        return $this->belongsTo(Valutatore::class);
    }
}
