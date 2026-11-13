<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Relationships exposed by the Post model.
 */
trait PostRelations
{
    /**
     * @return MorphTo<Model, $this>
     */
    public function linkable(): MorphTo
    {
        return $this->morphTo('post');
    }
}
