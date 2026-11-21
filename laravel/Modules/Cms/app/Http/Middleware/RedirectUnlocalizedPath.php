<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Modules\Cms\Actions\RedirectUnlocalizedPathAction;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware globale: un URL pubblico senza prefisso di lingua (/events) va alla pagina localizzata (/it/events).
 *
 * È globale perché la rotta catch-all di Folio (`laravel-folio`) non ha il gruppo `web` e ce n'è una sola per tutta
 * l'applicazione: una Route::fallback del modulo la sostituirebbe. Interviene SOLO se la richiesta finirebbe in quella
 * catch-all: le rotte vere (pannelli Filament, Livewire, API) non vengono mai toccate.
 * La decisione (lingua, esistenza della pagina) sta in RedirectUnlocalizedPathAction.
 */
class RedirectUnlocalizedPath
{
    public function __construct(
        private readonly Router $router,
    ) {}

    public function handle(Request $request, \Closure $next): Response
    {
        if ($this->fallsBackToFolio($request)) {
            $redirect = app(RedirectUnlocalizedPathAction::class)->execute($request);
            if ($redirect !== null) {
                return $redirect;
            }
        }

        $response = $next($request);
        \assert($response instanceof Response);

        return $response;
    }

    private function fallsBackToFolio(Request $request): bool
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return false;
        }

        try {
            return $this->router->getRoutes()->match($request)->getName() === 'laravel-folio';
        } catch (\Throwable) {
            // Nessuna rotta (404) o metodo non ammesso: decide il normale ciclo della richiesta.
            return false;
        }
    }
}
