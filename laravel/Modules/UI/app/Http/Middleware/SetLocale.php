<?php

declare(strict_types=1);

namespace Modules\UI\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

final class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // Recupera la lingua dalla sessione o usa quella predefinita
        $locale = Session::get('locale', config('app.locale'));
        if (! is_string($locale)) {
            $locale = Config::string('app.locale');
        }
        // Imposta la lingua
        App::setLocale($locale);

        $response = $next($request);
        if (! ($response instanceof Response)) {
            throw new \RuntimeException('Middleware must return a Response instance');
        }

        return $response;
    }
}
