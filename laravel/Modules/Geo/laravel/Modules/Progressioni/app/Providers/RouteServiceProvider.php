<?php

declare(strict_types=1);

namespace Modules\Progressioni\Providers;

// --- bases ---
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'Progressioni';

    protected string $moduleNamespace = 'Modules\Progressioni\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
