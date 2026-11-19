<?php

declare(strict_types=1);

namespace Modules\AI\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * Base pivot for AI module, inherits from XotBasePivot.
 */
abstract class BasePivot extends XotBasePivot
{
    protected $connection = 'ai';
}
