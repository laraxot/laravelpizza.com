<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Modules\Incentivi\Database\Factories\WorkgroupFactory;
use Modules\Ptv\Models\Profile;

/**
 * @property int $id
 * @property string $denominazione
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read Profile|null $creator
 * @property-read Collection<int, Employee> $employees
 * @property-read int|null $employees_count
 * @property-read Collection<int, Project> $projects
 * @property-read int|null $projects_count
 * @property-read Profile|null $updater
 * @method static WorkgroupFactory factory($count = null, $state = [])
 * @method static Builder|Workgroup newModelQuery()
 * @method static Builder|Workgroup newQuery()
 * @method static Builder|Workgroup query()
 * @method static Builder|Workgroup whereCreatedAt($value)
 * @method static Builder|Workgroup whereCreatedBy($value)
 * @method static Builder|Workgroup whereDenominazione($value)
 * @method static Builder|Workgroup whereId($value)
 * @method static Builder|Workgroup whereUpdatedAt($value)
 * @method static Builder|Workgroup whereUpdatedBy($value)
 * @property-read EmployeeWorkgroup|null $pivot
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class Workgroup extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['denominazione'];

    public function employees(): BelongsToMany
    {
        return $this->belongsToManyX(Employee::class);
    }

    // public function projects(): BelongsToMany
    // {
    //     // return $this->belongsToManyX(Project::class);
    //     return $this->belongsToManyX(Project::class);
    // }
}
