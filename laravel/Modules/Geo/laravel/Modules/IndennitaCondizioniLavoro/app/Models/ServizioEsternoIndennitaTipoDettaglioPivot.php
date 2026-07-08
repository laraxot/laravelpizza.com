<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

// ---- traits --
/**
 * Modules\IndennitaCondizioniLavoro\Models\ServizioEsternoIndennitaTipoDettaglioPivot.
 *
 * @property int $id
 * @property int|null $servizio_esterno_id
 * @property int|null $indennita_tipo_dettaglio_id
 * @property int|null $gg
 * @property string|null $note
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read float|null $tot
 * @property-read float|null $tot_x_ptime
 * @property-read IndennitaTipoDettaglio|null $indennitaTipoDettaglio
 * @property-read ServizioEsterno|null $servizioEsterno
 * @property-read CondizioniLavoro|null $condizioniLavoro
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot newModelQuery()
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot newQuery()
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot query()
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereCreatedAt($value)
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereCreatedBy($value)
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereGg($value)
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereId($value)
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereIndennitaTipoDettaglioId($value)
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereNote($value)
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereServizioEsternoId($value)
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereUpdatedAt($value)
 * @method static Builder|ServizioEsternoIndennitaTipoDettaglioPivot whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class ServizioEsternoIndennitaTipoDettaglioPivot extends BasePivot
{
    protected $table = 'servizio_esterno_x_indennita_tipo_dettaglio';

    protected $fillable = ['servizio_esterno_id', 'indennita_tipo_dettaglio_id', 'gg', 'note'];

    // protected $dates=['created_at','updated_at'];

    // --- relationship ---

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaCondizioniLavoro\Models\ServizioEsterno, $this>
     */
    public function servizioEsterno(): HasOne
    {
        return $this->hasOne(ServizioEsterno::class, 'id', 'servizio_esterno_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio, $this>
     */
    public function indennitaTipoDettaglio(): HasOne
    {
        return $this->hasOne(IndennitaTipoDettaglio::class, 'id', 'indennita_tipo_dettaglio_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro, $this>
     */
    public function condizioniLavoro(): HasOne
    {
        return $this->hasOne(CondizioniLavoro::class, 'matr', 'servizio_esterno_id');
    }

    // ---- mutators --
    public function getTotAttribute(?float $value): ?float
    {
        if (! $this->indennitaTipoDettaglio instanceof IndennitaTipoDettaglio) {
            return null;
        }

        if ($this->gg === null) {
            return null;
        }

        if ($this->indennitaTipoDettaglio->euro_giorno === null) {
            return null;
        }

        return $this->gg * (float) $this->indennitaTipoDettaglio->euro_giorno;
    }

    public function getTotXPtimeAttribute(?float $value): ?float
    {
        $tot = $this->tot;

        $condizioniLavoro = $this->condizioniLavoro;
        $ptime = null;
        // Type narrowing: ensure condizioniLavoro is not null and is CondizioniLavoro
        if ($condizioniLavoro !== null && $condizioniLavoro instanceof CondizioniLavoro) {
            $ptime = $condizioniLavoro->getAttribute('perc_p_time_daterange');
        }

        if ($ptime === null || ! is_numeric($ptime)) {
            return $tot;
        }

        return $tot * (float) $ptime;
    }
}
