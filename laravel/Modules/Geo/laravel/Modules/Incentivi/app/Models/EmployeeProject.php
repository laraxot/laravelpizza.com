<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Ptv\Models\Profile;

/**
 * @property-read Profile|null $creator
 * @property-read Employee|null $employee
 * @property-read Project|null $project
 * @property-read Profile|null $updater
 * @method static Builder<static>|EmployeeProject newModelQuery()
 * @method static Builder<static>|EmployeeProject newQuery()
 * @method static Builder<static>|EmployeeProject query()
 * @property string $id
 * @property int $employee_id
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read Profile|null $deleter
 * @method static Builder<static>|EmployeeProject whereCreatedAt($value)
 * @method static Builder<static>|EmployeeProject whereCreatedBy($value)
 * @method static Builder<static>|EmployeeProject whereEmployeeId($value)
 * @method static Builder<static>|EmployeeProject whereId($value)
 * @method static Builder<static>|EmployeeProject whereProjectId($value)
 * @method static Builder<static>|EmployeeProject whereUpdatedAt($value)
 * @method static Builder<static>|EmployeeProject whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class EmployeeProject extends BasePivot
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'employee_id',
        'project_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
