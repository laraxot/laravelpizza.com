<?php

declare(strict_types=1);

namespace Modules\Geo\Providers;

// --- bases ---
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

/**
 * Class RouteServiceProvider.
 */
class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'Geo';

    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Geo\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
