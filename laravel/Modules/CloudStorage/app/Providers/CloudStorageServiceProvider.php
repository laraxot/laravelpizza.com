<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * Summary of CloudStorageServiceProvider.
 */
class CloudStorageServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'CloudStorage';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public function bootCallback(): void
    {
        // Storage::extend('custom', function ($app, $config) {
        //    return new Filesystem(new CustomAdapter($config));
        // });
    }
}
