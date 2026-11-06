<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Spatie\QueueableAction\QueueableAction;

/**
 * Riduce un percorso alla forma che il router serve: senza segmenti vuoti né punto, `..` risale di un livello.
 *
 * `/it/./auth/login` e `/it//auth/login` sono la pagina di `/it/auth/login`: la policy robots e il canonical
 * devono vedere la stessa cosa, altrimenti basta un segmento in più per aggirare un `noindex`.
 */
final class CollapsePathSegmentsAction
{
    use QueueableAction;

    /** `/it/./faq/` → `it/faq` (senza barre iniziali e finali). */
    public function execute(string $path): string
    {
        return implode('/', $this->segments($path));
    }

    /**
     * @return list<string>
     */
    public function segments(string $path): array
    {
        $segments = [];

        foreach (explode('/', $path) as $segment) {
            if ('' === $segment || '.' === $segment) {
                continue;
            }

            if ('..' === $segment) {
                array_pop($segments);

                continue;
            }

            $segments[] = $segment;
        }

        return $segments;
    }
}
