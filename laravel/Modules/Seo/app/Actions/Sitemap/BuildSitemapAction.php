<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\Sitemap;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Actions\Head\ResolveRobotsPolicyAction;
use Modules\Cms\Actions\Head\ResolveWrittenLocalesAction;
use Modules\Cms\Models\Page;
use Modules\Seo\Contracts\SitemapPathsContract;
use Modules\Seo\Datas\SeoConfigData;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_replace;

/**
 * sitemap.xml delle pagine pubbliche in tutte le lingue (Linee guida di design 4.3.9, DCP-166).
 *
 * Le pagine vengono dal CMS (JSON del tenant). Restano fuori: le pagine di prova (`tests.`), quelle dietro `auth`
 * (non indicizzabili) e quelle che hanno senso solo con un parametro (`tickets.confirmation` usa `?code`, un dato personale;
 * `segnalazione-dettaglio` e' uno schema). Niente `lastmod`: non c'e' una data affidabile per pagina (DCP-167).
 *
 * Le pagine di dettaglio (un articolo, un evento, una segnalazione) non sono pagine del CMS: le elencano i moduli che le possiedono
 * tramite `SitemapPathsContract` (DCP-273), registrati sotto il tag `SitemapPathsContract::TAG`. Seo non conosce i loro modelli.
 */
final class BuildSitemapAction
{
    use QueueableAction;

    /** Risposta HTTP della rotta `/sitemap.xml` (invokable: `route:cache` non ammette closure). */
    public function __invoke(): Response
    {
        return response($this->execute(), 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function execute(): string
    {
        $locales = array_keys(LaravelLocalization::getSupportedLocales());
        $default = LaravelLocalization::getDefaultLocale();
        $default = is_string($default) ? $default : 'it';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        // Stessa regola del <head> (Cms `ResolveRobotsPolicyAction`): una URL `noindex` non va in sitemap e gli hreflang
        // collegano solo le lingue in cui la pagina esiste davvero.
        $policy = app(ResolveRobotsPolicyAction::class);
        foreach ($this->indexableEntries() as $entry) {
            $pageLocales = array_values(array_filter(
                $locales,
                static fn (string $locale): bool => ($entry['written'] === null || in_array($locale, $entry['written'], true))
                    && $policy->isIndexable('/'.$locale.'/'.$entry['path'], $locales),
            ));
            foreach ($pageLocales as $locale) {
                $xml .= "  <url>\n    <loc>".$this->url($locale, $entry['path'])."</loc>\n";
                if (count($pageLocales) > 1) {
                    foreach ($pageLocales as $alternate) {
                        $xml .= '    <xhtml:link rel="alternate" hreflang="'.$alternate.'" href="'.$this->url($alternate, $entry['path'])."\"/>\n";
                    }
                    if (in_array($default, $pageLocales, true)) {
                        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="'.$this->url($default, $entry['path'])."\"/>\n";
                    }
                }
                $xml .= "  </url>\n";
            }
        }

        return $xml.'</urlset>'."\n";
    }

    /**
     * `path`: percorso senza lingua ('' per la home, 'privacy', 'tickets/track', 'blog/{slug}', 'tickets/{id}').
     * `written`: lingue in cui la pagina CMS e' scritta (titolo e contenuto); `null` = nessuna restrizione (URL di dettaglio dei moduli).
     *
     * @return list<array{path: string, written: list<string>|null}>
     */
    private function indexableEntries(): array
    {
        // La chiave comincia con '/': un percorso numerico ('2024') non diventi un indice intero di PHP.
        $entries = [];
        $aliases = SeoConfigData::make()->pathAliases();
        foreach ($this->indexableCmsPages() as $page) {
            $slug = app(SafeStringCastAction::class)->execute($page->getAttribute('slug'));
            // Stessa regola del <head> (pagine di prova, `auth.*`, modello di dettaglio `*.view`, alias che reindirizzano, pagine dietro `auth`).
            if (! app(ResolveRobotsPolicyAction::class)->isPageIndexable($slug, $page->getAttribute('middleware'))) {
                continue;
            }
            $path = $this->pathOf($slug);
            // Un alias risponde 301 alla pagina canonica (`SeoConfigData::pathAliases()`): in sitemap va solo l'URL finale.
            if (array_key_exists($path, $aliases)) {
                continue;
            }
            $entries['/'.$path] = ['path' => $path, 'written' => app(ResolveWrittenLocalesAction::class)->execute($page)];
        }

        foreach (app()->tagged(SitemapPathsContract::TAG) as $source) {
            if ($source instanceof SitemapPathsContract) {
                foreach ($source->execute() as $path) {
                    if (! str_starts_with(trim($path, '/'), 'tests/') && trim($path, '/') !== 'tests') {
                        // Una pagina CMS gia' vista conserva le sue lingue: il modulo che la elenca non ne sa nulla.
                        $entries['/'.$path] ??= ['path' => $path, 'written' => null];
                    }
                }
            }
        }

        ksort($entries, SORT_STRING);

        return array_values($entries);
    }

    /**
     * @return Collection<int, Page>
     */
    private function indexableCmsPages(): Collection
    {
        return Page::query()->get();
    }

    private function pathOf(string $slug): string
    {
        $slug = preg_replace('/\.index$/', '', $slug);

        return $slug === 'home' ? '' : str_replace('.', '/', $slug);
    }

    private function url(string $locale, string $path): string
    {
        return htmlspecialchars(url('/'.$locale.($path === '' ? '' : '/'.$path)), ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
