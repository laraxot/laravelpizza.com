<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\User\Models\Team;

/**
 * Eloquent relationships for Profile.
 */
trait ProfileRelationsTrait
{
    /**
     * Get the teams that the profile belongs to.
     *
     * @return BelongsToMany<Team, $this, Pivot, 'pivot'>
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToManyX(Team::class);
    }
}
