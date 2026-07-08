<?php

declare(strict_types=1);

namespace Modules\Pdnd\Providers;

// use Illuminate\Support\Facades\Notification;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Override;

class PdndServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Pdnd';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[Override]
    public function boot(): void
    {
        parent::boot();
    }
}
