<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Incentivi\Database\Factories\DefaultActivityFactory;
use Modules\Ptv\Models\Profile;

/**
 * @property int $id
 * @property string $nome
 * @property string $tipo
 * @property int $quota_percentuale
 * @property int|null $importo
 * @property string $anno_competenza
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @method static DefaultActivityFactory factory($count = null, $state = [])
 * @method static Builder|DefaultActivity newModelQuery()
 * @method static Builder|DefaultActivity newQuery()
 * @method static Builder|DefaultActivity query()
 * @method static Builder|DefaultActivity whereAnnoCompetenza($value)
 * @method static Builder|DefaultActivity whereCreatedAt($value)
 * @method static Builder|DefaultActivity whereCreatedBy($value)
 * @method static Builder|DefaultActivity whereId($value)
 * @method static Builder|DefaultActivity whereImporto($value)
 * @method static Builder|DefaultActivity whereNome($value)
 * @method static Builder|DefaultActivity whereQuotaPercentuale($value)
 * @method static Builder|DefaultActivity whereTipo($value)
 * @method static Builder|DefaultActivity whereUpdatedAt($value)
 * @method static Builder|DefaultActivity whereUpdatedBy($value)
 * @property int $appartiene_a_liquidazione_a_fasi
 * @property string|null $liquidazione_fasi
 * @method static Builder<static>|DefaultActivity whereAppartieneALiquidazioneAFasi($value)
 * @method static Builder<static>|DefaultActivity whereLiquidazioneFasi($value)
 * @property int|null $phase_id
 * @method static Builder<static>|DefaultActivity wherePhaseId($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class DefaultActivity extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nome',
        'tipo',
        'quota_percentuale',
        'importo',
        'anno_competenza',
        'appartiene_a_liquidazione_a_fasi',
        'liquidazione_fasi',
        'project_id',
    ];
}
