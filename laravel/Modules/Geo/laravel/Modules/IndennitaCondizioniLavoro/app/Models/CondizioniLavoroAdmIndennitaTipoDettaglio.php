<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property-read CondizioniLavoro|null $condizioniLavoro
 * @property-read int|float $tot
 * @property-read int|float $tot_x_ptime
 * @property-read IndennitaTipoDettaglio|null $indennitaTipoDettaglio
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio newModelQuery()
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio newQuery()
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio query()
 * @property int $id
 * @property int|null $condizioni_lavoro_id
 * @property int|null $indennita_tipo_dettaglio_id
 * @property int|null $gg
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio whereCondizioniLavoroId($value)
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio whereCreatedAt($value)
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio whereGg($value)
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio whereId($value)
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio whereIndennitaTipoDettaglioId($value)
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio whereNote($value)
 * @method static Builder<static>|CondizioniLavoroAdmIndennitaTipoDettaglio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CondizioniLavoroAdmIndennitaTipoDettaglio extends CondizioniLavoroIndennitaTipoDettaglioPivot {}
