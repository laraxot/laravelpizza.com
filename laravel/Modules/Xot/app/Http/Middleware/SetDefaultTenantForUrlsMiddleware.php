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

use function Safe\parse_url;
use function Safe\preg_match;

/**
 * Class SetDefaultTenantForUrlsMiddleware.
 */
class SetDefaultTenantForUrlsMiddleware
{
    /**
     * Handle the incoming request.
     *
     * @see Modules/Xot/docs/adr/0021-auth-register-livewire-tenant-url-defaults.md
     */
    public function handle(
        Request $request,
        \Closure $next,
    ): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response {
        if ($this->isFrontOfficeRegistrationRequest($request)) {
            // The public registration widget is outside Filament tenancy. Keeping a
            // panel tenant in URL defaults changes the Livewire request context
            // between the initial Folio response and /livewire/update.
            URL::defaults(['tenant' => null]);

            /** @var Response|JsonResponse|\Symfony\Component\HttpFoundation\Response $response */
            $response = $next($request);

            return $response;
        }

        URL::defaults([
            'tenant' => Filament::getTenant(),
            // 'referrer' => url()->previous(),
        ]);

        /** @var Response|JsonResponse|\Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        return $response;
    }

    /**
     * @see Modules/Xot/docs/adr/0021-auth-register-livewire-tenant-url-defaults.md
     */
    private function isFrontOfficeRegistrationRequest(Request $request): bool
    {
        if ($this->isRegistrationPath($request->path())) {
            return true;
        }

        if (! $request->is('livewire/update')) {
            return false;
        }

        $referer = $request->headers->get('referer');
        $refererPath = is_string($referer) ? parse_url($referer, PHP_URL_PATH) : null;

        return is_string($refererPath) && $this->isRegistrationPath($refererPath);
    }

    /**
     * @see Modules/Xot/docs/adr/0021-auth-register-livewire-tenant-url-defaults.md
     */
    private function isRegistrationPath(string $path): bool
    {
        return preg_match('#^/[a-z]{2}(?:-[A-Z]{2})?/auth/register/?$#', $path) === 1;
    }
}
