<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

// ---- traits --
/**
 * Modules\IndennitaCondizioniLavoro\Models\CrossCondizioniLavoroIndennitaTipoDettaglio.
 *
 * @property int $id
 * @property int|null $condizioni_lavoro_id
 * @property int|null $indennita_tipo_dettaglio_id
 * @property int|null $gg
 * @property string|null $note
 * @property-read CondizioniLavoro|null $condizioniLavoro
 * @property-read IndennitaTipoDettaglio|null $indennitaTipoDettaglio
 * @method static Builder|CrossCondizioniLavoroIndennitaTipoDettaglio newModelQuery()
 * @method static Builder|CrossCondizioniLavoroIndennitaTipoDettaglio newQuery()
 * @method static Builder|CrossCondizioniLavoroIndennitaTipoDettaglio query()
 * @method static Builder|CrossCondizioniLavoroIndennitaTipoDettaglio whereCondizioniLavoroId($value)
 * @method static Builder|CrossCondizioniLavoroIndennitaTipoDettaglio whereGg($value)
 * @method static Builder|CrossCondizioniLavoroIndennitaTipoDettaglio whereId($value)
 * @method static Builder|CrossCondizioniLavoroIndennitaTipoDettaglio whereIndennitaTipoDettaglioId($value)
 * @method static Builder|CrossCondizioniLavoroIndennitaTipoDettaglio whereNote($value)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|CrossCondizioniLavoroIndennitaTipoDettaglio whereCreatedAt($value)
 * @method static Builder<static>|CrossCondizioniLavoroIndennitaTipoDettaglio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CrossCondizioniLavoroIndennitaTipoDettaglio extends BasePivot
{
    protected $table = 'condizioni_lavoro_x_indennita_tipo_dettaglio';

    protected $fillable = ['condizioni_lavoro_id', 'indennita_tipo_dettaglio_id', 'gg', 'note'];

    // protected $dates=['created_at','updated_at'];

    // --- relationship ---
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro, $this>
     */
    public function condizioniLavoro(): HasOne
    {
        return $this->hasOne(CondizioniLavoro::class, 'id', 'condizioni_lavoro_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio, $this>
     */
    public function indennitaTipoDettaglio(): HasOne
    {
        return $this->hasOne(IndennitaTipoDettaglio::class, 'id', 'indennita_tipo_dettaglio_id');
    }

    // ---- mutators --
    /*
    public function getTotAttribute(): void {
        return 'test';
    }
    */
}
