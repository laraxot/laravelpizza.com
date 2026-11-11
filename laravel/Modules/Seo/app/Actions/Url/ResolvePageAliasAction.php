<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\Url;

use Spatie\QueueableAction\QueueableAction;

/**
 * Due slug per la stessa pagina (`about`/`chi-siamo`, `faq`/`faqs`, `/home` e la home) sono due URL con lo stesso contenuto:
 * il motore di ricerca sceglie da solo quale tenere. La mappa `alias => canonico` (percorsi senza lingua, `''` = home) dice
 * qual e' quello da tenere; l'alias risponde 301 al canonico nella stessa lingua e il file del contenuto resta dov'e'.
 *
 * Una voce che potrebbe fare un giro (alias di se stesso, canonico che e' a sua volta un alias) o che non e' leggibile viene
 * ignorata: la pagina resta servita com'e', mai un ciclo di redirect.
 */
final class ResolvePageAliasAction
{
    use QueueableAction;

    /**
     * Percorso canonico (con lingua) a cui reindirizzare, o null se `$path` non e' un alias.
     *
     * @param  list<string>  $locales  lingue che possono prefissare il percorso
     * @param  array<array-key,mixed>  $aliases  alias => canonico, senza lingua
     */
    public function execute(string $path, array $locales, array $aliases): ?string
    {
        $segments = array_values(array_filter(explode('/', $path), static fn (string $segment): bool => $segment !== ''));
        $language = mb_strtolower($segments[0] ?? '');
        if (! in_array($language, $locales, true)) {
            return null;
        }

        $canonical = $this->canonicalOf(implode('/', array_slice($segments, 1)), $aliases);
        if ($canonical === null) {
            return null;
        }

        return '/'.$language.($canonical === '' ? '' : '/'.$canonical);
    }

    /**
     * `true` se il percorso di pagina (senza lingua: `chi-siamo`, `blog/vecchio`) e' un alias in uso.
     *
     * @param  array<array-key,mixed>  $aliases  alias => canonico, senza lingua
     */
    public function isAlias(string $pagePath, array $aliases): bool
    {
        return $this->canonicalOf(trim($pagePath, '/'), $aliases) !== null;
    }

    /**
     * @param  array<array-key,mixed>  $aliases
     */
    private function canonicalOf(string $pagePath, array $aliases): ?string
    {
        $clean = [];
        foreach ($aliases as $alias => $canonical) {
            $alias = trim((string) $alias, '/');
            if ($alias === '' || ! is_string($canonical)) {
                continue;
            }
            $clean[$alias] = trim($canonical, '/');
        }

        $canonical = $clean[$pagePath] ?? null;
        if ($canonical === null || $canonical === $pagePath || isset($clean[$canonical])) {
            return null;
        }

        return $canonical;
    }
}
