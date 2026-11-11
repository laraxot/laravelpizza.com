<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Spatie\QueueableAction\QueueableAction;

/**
 * Decide se una pagina pubblica va indicizzata e quale direttiva robots emettere.
 *
 * Una sola fonte per `<meta name="robots">` e per la sitemap: le aree riservate restano raggiungibili
 * (il noindex va letto dal crawler), ma non devono finire nell'indice. `robots.txt` (modulo Seo) ha ancora
 * un proprio elenco di segmenti, che deve restare un sottoinsieme di `HIDDEN_SEGMENTS` (lo verifica un test di Seo).
 */
final class ResolveRobotsPolicyAction
{
    use QueueableAction;

    private const string INDEXABLE = 'index, follow, max-image-preview:large';

    private const string HIDDEN = 'noindex, follow';

    /**
     * Primo segmento di percorso (dopo la lingua) che non si indicizza.
     *
     * @var list<string>
     */
    public const array HIDDEN_SEGMENTS = ['area-personale', 'auth', 'coming-soon', 'dashboard', 'notifications', 'preview-content', 'profile'];

    /**
     * Slug di pagine CMS che non hanno senso come URL indicizzata: servono un parametro personale (`?code`),
     * sono uno schema o sono un alias che reindirizza (in sitemap va solo l'URL finale).
     *
     * @var list<string>
     */
    public const array HIDDEN_SLUGS = ['tickets.confirmation', 'segnalazione-dettaglio', 'segnalazioni.index'];

    /**
     * @param  list<string>  $localeCodes  codici lingua che possono prefissare il percorso (`it`, `en`, ...)
     * @param  bool  $translated  `false` se la pagina non ha contenuto nella lingua corrente (duplicato della lingua di ripiego)
     */
    public function execute(string $path, array $localeCodes, bool $translated = true): string
    {
        return $this->directive($this->isIndexable($path, $localeCodes, $translated));
    }

    /** Direttiva `robots` per un esito già deciso (percorso e regole di pagina insieme). */
    public function directive(bool $indexable): string
    {
        return $indexable ? self::INDEXABLE : self::HIDDEN;
    }

    /**
     * @param  list<string>  $localeCodes
     */
    public function isIndexable(string $path, array $localeCodes, bool $translated = true): bool
    {
        if (! $translated) {
            return false;
        }

        return ! in_array($this->pathSegments($path, $localeCodes)[0] ?? '', self::HIDDEN_SEGMENTS, true);
    }

    /**
     * Regole che dipendono dalla pagina CMS e non dal percorso: pagine di prova, `auth.*`, modello di dettaglio (`*.view`),
     * slug nascosti e pagine dietro il middleware `auth`.
     */
    public function isPageIndexable(string $slug, mixed $middleware): bool
    {
        if ($slug === '' || $slug === 'tests' || str_starts_with($slug, 'tests.') || str_starts_with($slug, 'auth.') || str_ends_with($slug, '.view')) {
            return false;
        }

        if (in_array($slug, self::HIDDEN_SLUGS, true)) {
            return false;
        }

        return ! (is_array($middleware) && in_array('auth', $middleware, true));
    }

    /**
     * Segmenti del percorso come li vede il router: decodificati, in minuscolo, senza segmenti vuoti o punto e senza il prefisso lingua.
     * `/IT/preview-content`, `/it/%61uth` e `/it/./auth` sono lo stesso percorso riservato di `/it/auth`.
     *
     * @param  list<string>  $localeCodes
     * @return list<string>
     */
    public function pathSegments(string $path, array $localeCodes): array
    {
        $segments = (new CollapsePathSegmentsAction)->segments(mb_strtolower(rawurldecode($path)));

        $locales = array_map(mb_strtolower(...), $localeCodes);
        if (isset($segments[0]) && in_array($segments[0], $locales, true)) {
            array_shift($segments);
        }

        return $segments;
    }
}
