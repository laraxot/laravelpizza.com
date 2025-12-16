<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'Gdpr';

    protected string $moduleNamespace = 'Modules\Gdpr\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
