<?php

declare(strict_types=1);

namespace Modules\User\Enums;

use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum SocialProviderEnum: string implements HasLabel
{
    use EnumTrait;
    case GOOGLE = 'google';
    case AUTH0 = 'auth0';
}
