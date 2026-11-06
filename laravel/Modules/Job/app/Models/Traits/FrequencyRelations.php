<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Job\Models\Parameter;
use Modules\Job\Models\Task;

trait FrequencyRelations
{
    /**
     * @phpstan-return BelongsTo<Task, $this>
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @phpstan-return HasMany<Parameter, $this>
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class);
    }
}
