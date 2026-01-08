<?php

declare(strict_types=1);

namespace Modules\User\Models\Passport;

use Laravel\Passport\Client as PassportClient;

/**
 * Custom Passport Client model to fix compatibility issues with Laravel 12.
 */
class Client extends PassportClient
{
}
