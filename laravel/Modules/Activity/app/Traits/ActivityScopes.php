<?php

declare(strict_types=1);

namespace Modules\Activity\Traits;

use Illuminate\Database\Eloquent\Builder;
use Modules\Activity\Models\Activity;

/**
 * Scope query di {@see Activity}.
 *
 * @phpstan-require-extends Activity
 */
trait ActivityScopes
{
    /**
     * Scope activities by batch UUID.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeForBatch(Builder $query, string $batchUuid): Builder
    {
        return $query->where('batch_uuid', $batchUuid);
    }

    /**
     * Scope activities that belong to any batch.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeHasBatch(Builder $query): Builder
    {
        $query->whereNotNull('batch_uuid');

        return $query;
    }
}
