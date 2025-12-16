<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\User\Models\Traits\IsTenant;

/**
 * Class BaseIsTenant.
 */
abstract class BaseIsTenant extends BaseModel
{
    use IsTenant;
}
