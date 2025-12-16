<?php

declare(strict_types=1);

namespace Modules\User\Enums;

enum SocialProviderEnum: string
{
    case GOOGLE = 'google';
    case AUTH0 = 'auth0';
}
