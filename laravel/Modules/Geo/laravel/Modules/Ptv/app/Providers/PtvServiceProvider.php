<?php

declare(strict_types=1);

namespace Modules\Ptv\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class PtvServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'Ptv';
}
