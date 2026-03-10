<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\AuthCode as PassportAuthCode;

class OauthAuthCode extends PassportAuthCode
{
    /** @var string */
    protected $connection = 'user';
}
