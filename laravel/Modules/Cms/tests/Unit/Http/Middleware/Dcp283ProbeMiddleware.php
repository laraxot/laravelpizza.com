<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class Dcp283ProbeMiddleware
{
    public static int $calls = 0;

    /** @param Closure(Request): Response $next */
    public function handle(Request $request, Closure $next): Response
    {
        self::$calls++;

        return $next($request);
    }
}
