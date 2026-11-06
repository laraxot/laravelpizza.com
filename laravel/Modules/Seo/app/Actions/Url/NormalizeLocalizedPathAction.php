<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\Url;

use Spatie\QueueableAction\QueueableAction;

/**
 * Forma canonica di un percorso con prefisso lingua (DCP-288, FO-6-20): lingua in minuscolo, nessun doppio slash, nessuno slash finale.
 * Restituisce null se il percorso e' gia' canonico o se non comincia con una lingua nota (asset, Livewire, API non si toccano).
 * Il resto del percorso mantiene le maiuscole: `/it/Blog` e' un'altra pagina (404), non un duplicato.
 */
final class NormalizeLocalizedPathAction
{
    use QueueableAction;

    /**
     * @param  list<string>  $locales
     */
    public function execute(string $path, array $locales): ?string
    {
        $segments = array_values(array_filter(explode('/', $path), static fn (string $segment): bool => $segment !== ''));
        if ($segments === [] || ! in_array(mb_strtolower($segments[0]), $locales, true)) {
            return null;
        }

        $segments[0] = mb_strtolower($segments[0]);
        $canonical = '/'.implode('/', $segments);

        return $canonical === $path ? null : $canonical;
    }
}
