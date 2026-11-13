<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Traits;

use Modules\Lang\Models\Traits\Mutators\PostMutators as ExtractedPostMutators;

/**
 * Backward-compatible trait name for the extracted Post mutators.
 */
trait PostMutators
{
    use ExtractedPostMutators;
}
