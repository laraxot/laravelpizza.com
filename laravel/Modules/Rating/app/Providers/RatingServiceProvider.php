<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Rating\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class RatingServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Rating';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
