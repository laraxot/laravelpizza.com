<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class Dcp283ReturnsNothingMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        return null;
    }
}
