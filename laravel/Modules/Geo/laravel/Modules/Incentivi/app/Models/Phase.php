<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Modules\Incentivi\Database\Factories\PhaseFactory;
use Modules\Ptv\Models\Profile;

/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $project_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read Profile|null $creator
 * @property-read Project|null $project
 * @property-read Settlement|null $settlement
 * @property-read Profile|null $updater
 * @method static PhaseFactory factory($count = null, $state = [])
 * @method static Builder<static>|Phase newModelQuery()
 * @method static Builder<static>|Phase newQuery()
 * @method static Builder<static>|Phase query()
 * @method static Builder<static>|Phase whereCreatedAt($value)
 * @method static Builder<static>|Phase whereCreatedBy($value)
 * @method static Builder<static>|Phase whereDescription($value)
 * @method static Builder<static>|Phase whereEndDate($value)
 * @method static Builder<static>|Phase whereId($value)
 * @method static Builder<static>|Phase whereName($value)
 * @method static Builder<static>|Phase whereProjectId($value)
 * @method static Builder<static>|Phase whereStartDate($value)
 * @method static Builder<static>|Phase whereUpdatedAt($value)
 * @method static Builder<static>|Phase whereUpdatedBy($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class Phase extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'project_id',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'created_by' => 'string',
            'updated_by' => 'string',
        ];
    }

    public function settlement(): MorphOne
    {
        return $this->morphOne(Settlement::class, 'model');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
