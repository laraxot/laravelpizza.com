<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Job\Models\Schedule;

trait ScheduleHistoryRelations
{
    /**
     * @phpstan-return BelongsTo<Schedule, $this>
     */
    public function command(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }
}
