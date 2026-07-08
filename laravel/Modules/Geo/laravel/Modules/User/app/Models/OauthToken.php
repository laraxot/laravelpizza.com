<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\Token as PassportToken;

/**
 * @property bool            $revoked
 * @property int|string|null $user_id
 */
class OauthToken extends PassportToken
{
    protected $connection = 'user';
}
