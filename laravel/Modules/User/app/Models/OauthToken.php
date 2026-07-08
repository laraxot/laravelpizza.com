<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\Token as PassportToken;
use Modules\User\Database\Factories\OauthAccessTokenFactory;

/**
 * @property string|null $user_id
 * @property bool        $revoked
 */
class OauthToken extends PassportToken
{
    /** @use HasFactory<OauthAccessTokenFactory> */
    use HasFactory;

    /** @var string */
    protected $connection = 'user';

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): OauthAccessTokenFactory
    {
        return OauthAccessTokenFactory::new();
    }
}
