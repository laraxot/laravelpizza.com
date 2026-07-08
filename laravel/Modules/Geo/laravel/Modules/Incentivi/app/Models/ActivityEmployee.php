<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;

/**
 * @property string $id
 * @property int $activity_id
 * @property int $employee_id
 * @property int|null $project_id
 * @property int $percentuale_attivita_dipendente
 * @property string $importo_attivita_dipendente
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Profile|null $creator
 * @property Profile|null $updater
 * @method static Builder|ActivityEmployee newModelQuery()
 * @method static Builder|ActivityEmployee newQuery()
 * @method static Builder|ActivityEmployee query()
 * @method static Builder|ActivityEmployee whereActivityId($value)
 * @method static Builder|ActivityEmployee whereCreatedAt($value)
 * @method static Builder|ActivityEmployee whereCreatedBy($value)
 * @method static Builder|ActivityEmployee whereEmployeeId($value)
 * @method static Builder|ActivityEmployee whereId($value)
 * @method static Builder|ActivityEmployee whereImportoAttivitaDipendente($value)
 * @method static Builder|ActivityEmployee wherePercentualeAttivitaDipendente($value)
 * @method static Builder|ActivityEmployee whereProjectId($value)
 * @method static Builder|ActivityEmployee whereUpdatedAt($value)
 * @method static Builder|ActivityEmployee whereUpdatedBy($value)
 * @property-read Activity $activity
 * @property-read Employee $employee
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class ActivityEmployee extends BasePivot
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'activity_id',
        'employee_id',
        'project_id',
        'percentuale_attivita_dipendente',
        'importo_attivita_dipendente',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
