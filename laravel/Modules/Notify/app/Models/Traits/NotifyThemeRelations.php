<?php

declare(strict_types=1);

namespace Modules\Notify\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

trait NotifyThemeRelations
{
    /**
     * @phpstan-return MorphTo<Model, $this>
     */
    public function linkable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'post_type', 'post_id');
    }
}
