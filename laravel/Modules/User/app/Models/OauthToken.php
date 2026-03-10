<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\Token as PassportToken;

class OauthToken extends PassportToken
{
    /** @var string */
    protected $connection = 'user';

    /**
     * Get the user that the access token belongs to.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        /** @var string|null $userModel */
        $userModel = config('auth.providers.users.model');
        if (null === $userModel) {
            // Fallback to a safe default or return an empty relation
            return $this->belongsTo(self::class, 'id', 'id')->whereRaw('1=0');
        }

        return $this->belongsTo($userModel, 'user_id');
    }
}
