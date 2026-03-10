<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\RefreshToken as PassportRefreshToken;

/**
 * @property string                  $id
 * @property string                  $access_token_id
 * @property bool                    $revoked
 * @property \DateTimeInterface|null $expires_at
 */
class OauthRefreshToken extends PassportRefreshToken
{
    /** @var string */
    protected $connection = 'user';
}
