<?php

declare(strict_types=1);

namespace Modules\Geo\Providers;

// ---- bases ----
use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * Class GeoServiceProvider.
 */
class GeoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Geo';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
