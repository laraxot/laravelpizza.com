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
class EnsureUserHasType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request):Response  $next
     */
    public function handle(Request $request, \Closure $next, string $type): Response
    {
        $userType = $request->user()?->type;

        if ($userType instanceof \BackedEnum && $userType->value === $type) {
            return $next($request);
        }

        if (is_string($userType) && $userType === $type) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
