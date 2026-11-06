<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Job\Models\ScheduleHistory;

trait ScheduleRelations
{
    /**
     * @phpstan-return HasMany<ScheduleHistory, $this>
     */
    public function histories(): HasMany
    {
        return $this->hasMany(ScheduleHistory::class, 'schedule_id', 'id');
    }
}
