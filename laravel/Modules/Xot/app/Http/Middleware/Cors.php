<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $response = $next($request);
        if (! $response instanceof Response) {
            throw new \RuntimeException('Cors middleware expects a Symfony HTTP response instance.');
        }

        $headers = $response->headers;

        $headers->set('Access-Control-Allow-Origin', '*');
        $headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization');

        return $response;
    }
}
