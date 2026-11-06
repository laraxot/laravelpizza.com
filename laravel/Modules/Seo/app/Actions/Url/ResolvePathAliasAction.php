<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\Url;

use Spatie\QueueableAction\QueueableAction;

/**
 * Forma canonica di un alias di pagina: `/it/faqs` e `/it/faq` sono la stessa pagina scritta due volte, e ne resta una sola.
 * La mappa e' `SeoConfigData::pathAliases()` (impostazioni di Seo): percorso senza lingua dell'alias => percorso senza lingua canonico ('' = home).
 * Restituisce null se il percorso non comincia con una lingua nota o non e' un alias. Un solo salto: un alias che punta a un altro
 * alias non si segue (la mappa deve puntare sempre alla pagina finale: `SeoConfigData::pathAliases()` scarta giri e catene).
 */
final class ResolvePathAliasAction
{
    use QueueableAction;

    /**
     * @param  list<string>  $locales
     * @param  array<string, string>  $aliases
     */
    public function execute(string $path, array $locales, array $aliases): ?string
    {
        $segments = array_values(array_filter(explode('/', $path), static fn (string $segment): bool => $segment !== ''));
        if ($segments === [] || ! in_array($segments[0], $locales, true)) {
            return null;
        }

        $locale = array_shift($segments);
        $target = $aliases[implode('/', $segments)] ?? null;
        if ($target === null) {
            return null;
        }

        $target = trim($target, '/');

        return '/'.$locale.($target === '' ? '' : '/'.$target);
    }
}
