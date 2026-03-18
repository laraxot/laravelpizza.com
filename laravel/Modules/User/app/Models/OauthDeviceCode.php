<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\DeviceCode as PassportDeviceCode;
use Laravel\Passport\Passport;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Class OauthDeviceCode.
 *
 * Wrapper for Laravel Passport DeviceCode model.
 *
 * @property string|null       $user_id
 * @property string            $client_id
 * @property string            $user_code
 * @property OauthClient|null  $client
 * @property UserContract|null $user
 */
class OauthDeviceCode extends PassportDeviceCode
{
    /** @var string */
    protected $connection = 'user';

    /**
     * Get the client that owns the device code.
     *
     * @return BelongsTo<OauthClient, $this>
     */
    public function client(): BelongsTo
    {
        /** @var class-string<OauthClient> $clientModel */
        $clientModel = Passport::clientModel();

        return $this->belongsTo($clientModel);
    }

    /**
     * Get the user that approved the device code (nullable until approved).
     */
    public function user(): BelongsTo
    {
        /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
        $userClass = XotData::make()->getUserClass();

        return $this->belongsTo($userClass, 'user_id');
    }
}
