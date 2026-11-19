<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pannelli Filament nella lingua preferita dell'utente (colonna `users.lang`).
 *
 * I pannelli non hanno il prefisso di lingua negli URL: senza questo middleware restano sempre in `app.locale`.
 * Si applica solo se la lingua è tra quelle supportate (`laravellocalization.supportedLocales`, oppure
 * `app.locale` e `app.fallback_locale` se il pacchetto non c'è); altrimenti non cambia niente.
 * Registrato come auth middleware persistente in XotBasePanelProvider e XotBaseMainPanelProvider, così vale
 * anche per le richieste Livewire (azioni di tabella, modali).
 */
class SetPanelLocaleFromUserMiddleware
{
    /** @param  Closure(Request): Response  $next */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->user()?->getAttribute('lang');

        if (\is_string($locale) && \in_array($locale, $this->supportedLocales(), true)) {
            app()->setLocale($locale);
            Carbon::setLocale($locale);
        }

        return $next($request);
    }

    /** @return list<string> */
    private function supportedLocales(): array
    {
        $configured = config('laravellocalization.supportedLocales');
        if (\is_array($configured) && $configured !== []) {
            return array_values(array_filter(array_keys($configured), \is_string(...)));
        }

        return array_values(array_filter([config('app.locale'), config('app.fallback_locale')], \is_string(...)));
    }
}
