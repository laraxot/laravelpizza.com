<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Laravel\Passport\Client as PassportClient;

class OauthClient extends PassportClient
{
    /** @var string */
    protected $connection = 'user';

    /**
     * Determine if the client should skip the authorization prompt.
     *
     * @return bool
     */
    public function skipsAuthorization()
    {
        return $this->firstParty();
    }
}
