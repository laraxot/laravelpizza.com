<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\DeviceCode as PassportDeviceCode;

/**
 * Class OauthDeviceCode.
 *
 * Wrapper for Laravel Passport DeviceCode model.
 */
class OauthDeviceCode extends PassportDeviceCode
{
}
