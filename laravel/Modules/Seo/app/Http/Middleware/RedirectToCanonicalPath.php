<?php

declare(strict_types=1);

namespace Modules\Seo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Seo\Actions\Url\NormalizeLocalizedPathAction;
use Modules\Seo\Actions\Url\ResolvePathAliasAction;
use Modules\Seo\Datas\SeoConfigData;
use Symfony\Component\HttpFoundation\Response;

/**
 * 301 dalle copie di una pagina (lingua maiuscola, doppio slash, slash finale) alla forma canonica, con la query intatta (DCP-288, FO-6-20).
 * Stessa regola per gli alias di pagina dichiarati nelle impostazioni di Seo (`SeoConfigData::pathAliases()`) (`/it/faqs` -> `/it/faq`, stessa lingua).
 * Solo GET e HEAD: un POST non si reindirizza. E' un middleware globale, cosi' agisce prima della ricerca della rotta.
 */
final class RedirectToCanonicalPath
{
    /**
     * @param  Closure(Request):Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethodSafe()) {
            return $next($request);
        }

        $locales = array_map('strval', array_keys((array) config('laravellocalization.supportedLocales', [])));
        $path = $request->getPathInfo();
        $normalized = app(NormalizeLocalizedPathAction::class)->execute($path, $locales);
        // Un solo salto anche quando le due regole si sommano (`/IT/faqs/` -> `/it/faq`): niente catene di redirect.
        $canonical = app(ResolvePathAliasAction::class)->execute($normalized ?? $path, $locales, $this->aliases()) ?? $normalized;
        if ($canonical === null) {
            return $next($request);
        }

        // La query grezza del server: `getQueryString()` riordina i parametri, e il reindirizzamento deve lasciarla com'era.
        $query = $request->server->getString('QUERY_STRING');

        return redirect()->to($canonical.($query !== '' ? '?'.$query : ''), 301);
    }

    /**
     * Alias di pagina => pagina canonica, dalla SettingPage di Seo (`SeoConfigData`).
     *
     * @return array<string, string>
     */
    private function aliases(): array
    {
        return SeoConfigData::make()->pathAliases();
    }
}
