<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * OAuth Device Code model.
 *
 * ⚠️ NOTE: Laravel\Passport\DeviceCode does not exist in this Passport version.
 * Extending BaseModel instead. This model is rarely used (OAuth2 device flow).
 *
 * @property string      $id
 * @property string|null $user_code
 * @property string|null $device_code
 * @property string|null $client_id
 * @property array|null  $scopes
 * @property bool        $revoked
 * @property Carbon|null $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|OauthDeviceCode newModelQuery()
 * @method static Builder|OauthDeviceCode newQuery()
 * @method static Builder|OauthDeviceCode query()
 *
 * @mixin \Eloquent
 */
class OauthDeviceCode extends BaseModel
{
    /** @var string */
    protected $connection = 'user';

    /*
     * protected $fillable = [
     * 'id', 'user_id', 'name', 'secret', 'provider', 'redirect',
     * 'personal_access_client', 'password_client', 'revoked',
     * ];
     */
}
