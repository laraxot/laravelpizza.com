<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Traits;

use Modules\Lang\Models\Traits\Relationships\PostRelations as ExtractedPostRelations;

/**
 * Backward-compatible trait name for the extracted Post relations.
 */
trait PostRelations
{
    use ExtractedPostRelations;
}
