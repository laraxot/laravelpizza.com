<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * Class BasePivot.
 */
abstract class BasePivot extends XotBasePivot
{
    protected $connection = 'gdpr';
}
