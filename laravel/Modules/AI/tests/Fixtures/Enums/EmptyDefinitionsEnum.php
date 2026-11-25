<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Enums;

use Modules\Xot\Traits\EnumTrait;

enum EmptyDefinitionsEnum: string
{
    use EnumTrait;

    case ONE = 'one';
}
