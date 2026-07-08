<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Ptv\Models\MyLog;

/**
 * Undocumented trait.
 *
 * @phpstan-ignore trait.unused
 */
trait HasMyLogs
{
    /**
     * @phpstan-ignore-next-line missingType.generics
     */
    public function myLogs(): MorphMany
    {
        return $this->morphMany(MyLog::class, 'model');
    }
}
