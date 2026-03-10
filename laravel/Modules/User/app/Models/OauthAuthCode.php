<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\AuthCode as PassportAuthCode;

/**
 * Class OauthAuthCode.
 *
 * Wrapper for Laravel Passport AuthCode model.
 */
class OauthAuthCode extends PassportAuthCode
{
}
