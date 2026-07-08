<?php

declare(strict_types=1);

namespace Modules\AI\Providers;

// --- bases ---
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'AI';

    protected string $moduleNamespace = 'Modules\AI\Http\Controllers';
}
