<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Folio\FolioManager;
use Laravel\Folio\Router;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\LanguageNegotiator;
use Spatie\QueueableAction\QueueableAction;

/**
 * Un URL pubblico senza prefisso di lingua (es. /events) porta alla stessa pagina nella lingua del visitatore
 * (/it/events): lingua dell'header Accept-Language se supportata, altrimenti quella di default.
 *
 * Le pagine Folio sono montate solo sotto /{lingua}: senza prefisso nessuna rotta corrisponde, quindi il middleware
 * LaravelLocalizationRedirectFilter non entra mai in gioco e l'utente vedeva un 404. Si reindirizza solo se la pagina
 * esiste davvero in una delle cartelle Folio montate per quella lingua; altrimenti resta 404 (niente rimbalzi).
 */
final class RedirectUnlocalizedPathAction
{
    use QueueableAction;

    public function execute(Request $request): ?RedirectResponse
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return null;
        }

        $path = '/'.ltrim($request->path(), '/');
        $first = explode('/', ltrim($path, '/'))[0];
        $locales = array_keys(LaravelLocalization::getSupportedLocales());
        if ($path === '/' || in_array($first, $locales, true)) {
            return null;
        }

        // Si negozia sulla richiesta stessa: getCurrentLocale() può restituire la lingua già fissata da una richiesta
        // precedente nello stesso processo (worker, test). Senza Accept-Language utile vale la lingua di default.
        $default = (string) LaravelLocalization::getDefaultLocale();
        $locale = config('laravellocalization.useAcceptLanguageHeader') === true
            ? (string) (new LanguageNegotiator($default, LaravelLocalization::getSupportedLocales(), $request))->negotiateLanguage()
            : $default;
        if (! in_array($locale, $locales, true)) {
            $locale = $default;
        }

        if (! $this->folioPageExists('/'.$locale, $path)) {
            return null;
        }

        $target = '/'.$locale.$path;
        $query = $request->getQueryString();

        return new RedirectResponse($query !== null && $query !== '' ? $target.'?'.$query : $target, 302);
    }

    private function folioPageExists(string $baseUri, string $path): bool
    {
        foreach (app(FolioManager::class)->mountPaths() as $mountPath) {
            if ($mountPath->baseUri !== $baseUri) {
                continue;
            }
            if ((new Router($mountPath))->match(new Request, $path) !== null) {
                return true;
            }
        }

        return false;
    }
}
