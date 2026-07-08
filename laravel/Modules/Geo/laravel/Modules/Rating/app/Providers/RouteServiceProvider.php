<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Rating\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'Rating';

    protected string $moduleNamespace = 'Modules\Rating\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
