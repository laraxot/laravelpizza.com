<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;

class OauthPersonalAccessClient extends PassportPersonalAccessClient
{
    /** @var string */
    protected $connection = 'user';
}
