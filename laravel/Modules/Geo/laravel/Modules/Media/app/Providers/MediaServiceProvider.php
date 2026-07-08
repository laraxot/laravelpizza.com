<?php

declare(strict_types=1);

namespace Modules\Media\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class MediaServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Media';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
