<?php

declare(strict_types=1);

namespace Modules\User\Models\Passport;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;
use Laravel\Passport\Client as PassportClient;
use Modules\User\Models\OauthAuthCode;
use Modules\User\Models\OauthToken;

/**
 * Custom Passport Client model to fix compatibility issues with Laravel 12.
 *
 * @property Collection<int, OauthAuthCode> $authCodes
 * @property int|null $auth_codes_count
 * @property list<string> $grant_types
 * @property User $owner
 * @property string|null $plain_secret
 * @property list<string> $redirect_uris
 * @property string|null $secret
 * @property Collection<int, OauthToken> $tokens
 * @property int|null $tokens_count
 * @property \Modules\User\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client existsIn(array<int, string> $haystack)
 * @method static \Laravel\Passport\Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 *
 * @mixin \Eloquent
 */
class Client extends PassportClient
{
    /**
     * Initialize the trait.
     * Overriding to match Laravel 12 HasUuids trait signature (removing : void).
     */
    public function initializeHasUniqueStringIds(): void
    {
        parent::initializeHasUniqueStringIds();
    }
}
