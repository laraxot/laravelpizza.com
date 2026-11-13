<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\QueueableAction\QueueableAction;

/**
 * Alternative linguistiche (hreflang) della pagina corrente.
 *
 * Ogni versione deve elencare se stessa e tutte le altre con URL assolute
 * (Google: link reciproci); `x-default` punta alla lingua predefinita.
 */
final class ResolveHreflangAlternatesAction
{
    use QueueableAction;

    public const string X_DEFAULT = 'x-default';

    /**
     * @param  list<string>|null  $onlyLocales  lingue in cui la pagina esiste davvero; `null` = tutte quelle supportate
     * @return array<string, string> codice lingua => URL assoluta
     */
    public function execute(?array $onlyLocales = null): array
    {
        $urls = [];
<<<<<<< .merge_file_tqUmG8
        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $code) {
            $url = LaravelLocalization::getLocalizedURL($code, null, [], true);
            if (is_string($url) && ($onlyLocales === null || in_array((string) $code, $onlyLocales, true))) {
                $urls[(string) $code] = $url;
=======
        $locales = array_map(strval(...), array_keys(LaravelLocalization::getSupportedLocales()));
        // Dal percorso della richiesta corrente e non da getLocalizedURL(): quella usa la richiesta memorizzata nel singleton
        // e in un processo che serve piu' richieste (test, Octane) restituiva la home di ogni lingua (`/de`) o il percorso
        // della richiesta precedente. Stesso criterio di Themes/Sixteen components/layouts/seo-links.
        [$first, $rest] = array_pad(explode('/', trim(request()->path(), '/'), 2), 2, '');
        foreach ($locales as $code) {
            if ($onlyLocales !== null && ! in_array($code, $onlyLocales, true)) {
                continue;
>>>>>>> .merge_file_sehthj
            }
            $urls[$code] = in_array($first, $locales, true)
                ? url('/'.$code.($rest !== '' ? '/'.$rest : ''))
                : LaravelLocalization::getLocalizedURL($code, null, [], true);
        }
        $urls = array_filter($urls, is_string(...));

        // `?page=N` identifica un contenuto diverso (paginazione): resta negli URL dichiarati,
        // altrimenti ogni pagina della serie dichiara le stesse alternative della prima.
        return $this->build($urls, LaravelLocalization::getDefaultLocale(), $this->paginationQuery());
    }

    /**
     * @param  array<string, string>  $localizedUrls  codice lingua => URL della stessa pagina in quella lingua
<<<<<<< .merge_file_tqUmG8
=======
     * @param  string  $query  query da conservare negli URL (es. `?page=2`), senza `?` iniziale
>>>>>>> .merge_file_sehthj
     * @return array<string, string>
     */
    public function build(array $localizedUrls, string $defaultLocale, string $query = ''): array
    {
        $suffix = $query !== '' ? '?'.$query : '';
        $alternates = [];
        foreach ($localizedUrls as $code => $url) {
            $alternates[$code] = $this->withoutQuery($url).$suffix;
        }

        if (count($alternates) < 2) {
            return [];
        }

        if (isset($alternates[$defaultLocale])) {
            $alternates[self::X_DEFAULT] = $alternates[$defaultLocale];
        }

        return $alternates;
    }

    private function withoutQuery(string $url): string
    {
        return explode('#', explode('?', $url, 2)[0], 2)[0];
    }

    /** Solo `page` intero >= 2: e' l'unico parametro che cambia il contenuto di una pagina pubblica. */
    private function paginationQuery(): string
    {
        $page = request()->query('page');

        return is_numeric($page) && (int) $page >= 2 ? 'page='.(int) $page : '';
    }
}
