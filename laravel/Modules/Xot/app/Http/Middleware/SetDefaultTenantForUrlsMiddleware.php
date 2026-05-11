<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

/*
 * https://laravel.com/docs/8.x/urls#default-values
 */
use Filament\Facades\Filament;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

/**
 * Class SetDefaultTenantForUrlsMiddleware.
 */
class SetDefaultTenantForUrlsMiddleware
{
    /**
     * Handle the incoming request.
     */
    public function handle(
        Request $request,
        \Closure $next,
    ): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response {
        URL::defaults([
            'tenant' => Filament::getTenant(),
            // 'referrer' => url()->previous(),
        ]);

        $response = $next($request);
        if (! $response instanceof Response && ! $response instanceof JsonResponse && ! $response instanceof \Symfony\Component\HttpFoundation\Response) {
            throw new \RuntimeException('SetDefaultTenantForUrlsMiddleware expects a Symfony HTTP response.');
        }

        return $response;
    }
}
