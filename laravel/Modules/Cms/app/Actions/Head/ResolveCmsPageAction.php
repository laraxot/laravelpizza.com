<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Modules\Cms\Models\Page;
use Spatie\QueueableAction\QueueableAction;

/**
 * La pagina CMS che corrisponde a un percorso della richiesta, per il `<head>`.
 *
 * Si parte dal percorso e non dai parametri di rotta: è l'inverso di ciò che fa la sitemap (`a/b` <-> slug `a.b`, `x` <-> `x.index`,
 * radice <-> `home`), quindi head e sitemap concordano per costruzione. Le pagine di dettaglio (`blog/{slug}`) hanno parametri di
 * rotta diversi da `container0`/`slug0` e con i soli parametri non si trovavano: perdevano la regola delle lingue scritte.
 */
final class ResolveCmsPageAction
{
    use QueueableAction;

    /**
     * @param list<string> $localeCodes
     */
    public function execute(string $path, array $localeCodes, ?string $routeName = null): ?Page
    {
        foreach ($this->candidateSlugs($path, $localeCodes, $routeName) as $slug) {
            try {
                $page = Page::findUniqueBySlug($slug);
            } catch (\RuntimeException $exception) {
                // Slug duplicato: il middleware risponde 503 sulle pagine protette; il <head> non deve rompere la pagina.
                report($exception);

                continue;
            }

            if ($page instanceof Page) {
                return $page;
            }
        }

        return null;
    }

    /**
     * @param list<string> $localeCodes
     *
     * @return list<string>
     */
    public function candidateSlugs(string $path, array $localeCodes, ?string $routeName = null): array
    {
        $segments = (new ResolveRobotsPolicyAction())->pathSegments($path, $localeCodes);
        $slug = [] === $segments ? 'home' : implode('.', $segments);
        $candidates = [$slug, $slug.'.index'];

        if (null !== $routeName && ! in_array($routeName, ['', 'container0', 'container0.view'], true)) {
            $candidates[] = $routeName;
        }

        return array_values(array_unique($candidates));
    }
}
