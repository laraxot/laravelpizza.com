<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\DeviceCode as PassportDeviceCode;

/**
 * Class OauthDeviceCode.
 *
 * Wrapper for Laravel Passport DeviceCode model.
 *
 * @property bool $revoked
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthDeviceCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthDeviceCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthDeviceCode query()
 *
 * @mixin \Eloquent
 */
class OauthDeviceCode extends PassportDeviceCode {}
