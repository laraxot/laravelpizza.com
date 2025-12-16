<?php

declare(strict_types=1);

/**
 * @see https://laravel.com/docs/11.x/urls#default-values
 */

namespace Modules\Xot\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Modules\Xot\Contracts\UserContract;
use Symfony\Component\HttpFoundation\Response;

class SetDefaultLocaleForUrls
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $lang = app()->getLocale();
        if ($user instanceof UserContract) {
            // Accesso sicuro alla proprietà lang tramite getAttribute per magic attributes
            $userLang = $user->getAttribute('lang');
            if (is_string($userLang) && $userLang !== '') {
                $lang = $userLang;
            }
        }

        URL::defaults(['lang' => $lang]);

        return $next($request);
    }
}
