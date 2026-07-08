<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Modules\Incentivi\Database\Factories\ActivityFactory;
use Modules\Ptv\Models\Profile;

/**
 * @property int $id
 * @property string $nome
 * @property string $tipo
 * @property int $quota_percentuale
 * @property int|null $importo
 * @property string $anno_competenza
 * @property int|null $project_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Profile|null $creator
 * @property ActivityEmployee $pivot
 * @property Collection<int, Employee> $employees
 * @property int|null $employees_count
 * @property Project|null $project
 * @property Profile|null $updater
 * @method static ActivityFactory factory($count = null, $state = [])
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity query()
 * @method static Builder|Activity whereAnnoCompetenza($value)
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereCreatedBy($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereImporto($value)
 * @method static Builder|Activity whereNome($value)
 * @method static Builder|Activity whereProjectId($value)
 * @method static Builder|Activity whereQuotaPercentuale($value)
 * @method static Builder|Activity whereTipo($value)
 * @method static Builder|Activity whereUpdatedAt($value)
 * @method static Builder|Activity whereUpdatedBy($value)
 * @property int $appartiene_a_liquidazione_a_fasi
 * @property string|null $liquidazione_fasi
 * @property-read int|null $workgroup_id
 * @method static Builder<static>|Activity whereAppartieneALiquidazioneAFasi($value)
 * @method static Builder<static>|Activity whereLiquidazioneFasi($value)
 * @property int|null $phase_id
 * @method static Builder<static>|Activity wherePhaseId($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class Activity extends BaseModel
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

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function employees(): BelongsToMany
    {
        /*
        $pivot_class = ActivityEmployee::class;
        $pivot = app($pivot_class);
        $pivot_fields = $pivot->getFillable();

        return $this
            ->belongsToManyX(Employee::class)
            ->using($pivot_class)
            ->withPivot($pivot_fields)
            ->withTimestamps();
            */
        return $this
            ->belongsToManyX(Employee::class);
    }

    // mutators

    public function getWorkgroupIdAttribute(?int $value): ?int
    {
        if ($value != null) {
            return $value;
        }

        // dddx($this->project);
        return $this->project?->workgroup_id;
    }
}
