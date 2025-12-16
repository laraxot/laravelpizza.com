<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * Base Pivot for Cms module.
 *
 * Extends XotBasePivot which provides all standard properties and casts.
 *
 * @see XotBasePivot
 */
abstract class BasePivot extends XotBasePivot
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'cms';
}
