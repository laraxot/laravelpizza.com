<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\Token as PassportToken;

class OauthToken extends PassportToken
{
    /** @var string */
    protected $connection = 'user';
}
