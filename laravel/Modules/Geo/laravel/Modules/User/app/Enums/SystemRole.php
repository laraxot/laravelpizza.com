<?php

declare(strict_types=1);

namespace Modules\User\Enums;

use Modules\Xot\Traits\EnumTrait;

enum SystemRole: string
{
    use EnumTrait;

    case SuperAdmin = '%';
}
