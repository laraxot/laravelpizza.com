<?php

declare(strict_types=1);

namespace Modules\User\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Route::put('/post/{id}', function (string $id) {
 *   // ...
 * })->middleware(EnsureUserHasRole::class.':editor');
 * Route::put('/post/{id}', function (string $id) {
 *     // ...
 *})->middleware(EnsureUserHasRole::class.':editor,publisher');.
 */
class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request):Response $next
     */
    public function handle(Request $request, \Closure $next, string $role): Response
    {
        $user = $request->user();
        // Check if user has role using Spatie Permission's hasRole method
        if (! $user || ! method_exists($user, 'hasRole') || ! $user->hasRole($role)) {
            // Redirect...
            return redirect()->route('home');
        }

        return $next($request);
    }
}
