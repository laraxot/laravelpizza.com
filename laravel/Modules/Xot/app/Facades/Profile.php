<?php

/**
 * per vedere come registra la facade.
 *
 * @see https://github.com/spatie/laravel-menu/tree/main/src
 */

declare(strict_types=1);

namespace Modules\Xot\Facades;

use Illuminate\Support\Facades\Facade;

class Profile extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'profile';
    }
}
