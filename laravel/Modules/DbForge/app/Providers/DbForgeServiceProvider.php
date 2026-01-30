<?php

declare(strict_types=1);

namespace Modules\DbForge\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class DbForgeServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'DbForge';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
