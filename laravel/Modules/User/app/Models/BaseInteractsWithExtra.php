<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\Xot\Models\Traits\HasExtraTrait;

/**
 * Class BaseInteractsWithExtra.
 */
abstract class BaseInteractsWithExtra extends BaseModel
{
    use HasExtraTrait;
}
