<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\User\Models\Traits\InteractsWithTenant;

/**
 * Class BaseInteractsWithTenant.
 */
abstract class BaseInteractsWithTenant extends BaseModel
{
    use InteractsWithTenant;
}
