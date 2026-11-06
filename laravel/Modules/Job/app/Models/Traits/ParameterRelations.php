<?php

declare(strict_types=1);

namespace Modules\Job\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Job\Models\Frequency;

trait ParameterRelations
{
    /**
     * @phpstan-return BelongsTo<Frequency, $this>
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Frequency::class);
    }
}
