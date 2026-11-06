<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Job\Models\Frequency;
use Modules\Job\Models\Result;

trait TaskRelations
{
    /**
     * @phpstan-return HasMany<Frequency, $this>
     */
    public function frequencies(): HasMany
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id')->with('parameters');
    }

    /**
     * @phpstan-return HasMany<Result, $this>
     */
    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'task_id', 'id');
    }
}
