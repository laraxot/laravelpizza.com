<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Modules\Xot\Models\XotBaseMorphPivot;

/**
 * Class BaseMorphPivot.
 */
abstract class BaseMorphPivot extends XotBaseMorphPivot
{
    protected $connection = 'gdpr';
}
