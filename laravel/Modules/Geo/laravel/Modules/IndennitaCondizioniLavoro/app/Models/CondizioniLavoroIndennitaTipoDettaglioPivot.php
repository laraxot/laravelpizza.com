<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

// ---- traits --
/**
 * Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroIndennitaTipoDettaglioPivot.
 *
 * @property int $id
 * @property int|null $condizioni_lavoro_id
 * @property int|null $indennita_tipo_dettaglio_id
 * @property int|null $gg
 * @property string|null $note
 * @property-read CondizioniLavoro|null $condizioniLavoro
 * @property-read int|float $tot
 * @property-read int|float $tot_x_ptime
 * @property-read IndennitaTipoDettaglio|null $indennitaTipoDettaglio
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot newModelQuery()
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot newQuery()
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot query()
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereCondizioniLavoroId($value)
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereGg($value)
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereId($value)
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereIndennitaTipoDettaglioId($value)
 * @method static Builder|CondizioniLavoroIndennitaTipoDettaglioPivot whereNote($value)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|CondizioniLavoroIndennitaTipoDettaglioPivot whereCreatedAt($value)
 * @method static Builder<static>|CondizioniLavoroIndennitaTipoDettaglioPivot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CondizioniLavoroIndennitaTipoDettaglioPivot extends BasePivot
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
    
    /**
     * Get tot attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * Calcola il totale (gg * euro_giorno).
     * Questo è un calcolo puro, non necessita di persistenza.
     */
    public function getTotAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculateTot();
    }

    /**
     * Calcola il totale (gg * euro_giorno).
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateTot(): ?float
    {
        $gg = $this->gg ?? 0;
        $euroGiorno = $this->indennitaTipoDettaglio->euro_giorno ?? 0;

        if ($gg === 0 || $euroGiorno === 0) {
            return 0.0;
        }

        return (float) $gg * (float) $euroGiorno;
    }

    /**
     * Get tot_x_ptime attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * Calcola il totale per part-time (tot * perc_p_time).
     * Questo è un calcolo puro, non necessita di persistenza.
     */
    public function getTotXPtimeAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculateTotXPtime();
    }

    /**
     * Calcola il totale per part-time (tot * perc_p_time).
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateTotXPtime(): ?float
    {
        $tot = $this->tot;
        $ptime = $this->condizioniLavoro->perc_p_time_daterange ?? 0;

        if ($tot === 0.0 || $ptime === 0.0) {
            return 0.0;
        }

        return (float) $tot * (float) $ptime;
    }
}
