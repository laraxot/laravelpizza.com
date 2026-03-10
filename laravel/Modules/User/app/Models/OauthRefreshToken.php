<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\RefreshToken as PassportRefreshToken;

class OauthRefreshToken extends PassportRefreshToken
{
    /** @var string */
    protected $connection = 'user';
}
