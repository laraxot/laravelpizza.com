<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;

/**
 * @property string $id
 * @property int $employee_id
 * @property int $workgroup_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Profile|null $creator
 * @property Profile|null $updater
 * @property int|null $project_id
 * @property-read Employee|null $employee
 * @property-read Project|null $project
 * @property-read Workgroup|null $workgroup
 * @method static Builder|EmployeeWorkgroup newModelQuery()
 * @method static Builder|EmployeeWorkgroup newQuery()
 * @method static Builder|EmployeeWorkgroup query()
 * @method static Builder|EmployeeWorkgroup whereCreatedAt($value)
 * @method static Builder|EmployeeWorkgroup whereCreatedBy($value)
 * @method static Builder|EmployeeWorkgroup whereEmployeeId($value)
 * @method static Builder|EmployeeWorkgroup whereId($value)
 * @method static Builder|EmployeeWorkgroup whereProjectId($value)
 * @method static Builder|EmployeeWorkgroup whereUpdatedAt($value)
 * @method static Builder|EmployeeWorkgroup whereUpdatedBy($value)
 * @method static Builder|EmployeeWorkgroup whereWorkgroupId($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class EmployeeWorkgroup extends BasePivot
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['employee_id', 'workgroup_id'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function workgroup(): BelongsTo
    {
        return $this->belongsTo(Workgroup::class, 'workgroup_id');
    }

    // public function project(): BelongsTo
    // {
    //     return $this->belongsTo(Project::class, 'project_id');
    // }
}
