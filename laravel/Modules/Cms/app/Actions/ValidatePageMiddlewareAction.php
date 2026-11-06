<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Spatie\QueueableAction\QueueableAction;

/**
 * Verifica che i middleware dichiarati dal JSON di una pagina siano in allowlist (DCP-283, C-03).
 *
 * Il nome della classe arriva da dati modificabili: senza elenco, chi edita un JSON farebbe eseguire
 * qualunque classe con un metodo `handle`. Il confronto e' sul nome prima dei due punti.
 */
final class ValidatePageMiddlewareAction
{
    use QueueableAction;

    /**
     * Gruppi gia' applicati dallo stack Folio: una voce `web` nel JSON non ha effetto (D17, 2026-10-13).
     *
     * @var list<string>
     */
    public const array FOLIO_APPLIED_GROUPS = ['web'];

    /**
     * @param  list<string>  $declared
     * @return list<string>
     *
     * @throws \InvalidArgumentException al primo middleware non ammesso
     */
    public function execute(array $declared): array
    {
        $allowed = $this->allowedNames();

        foreach ($declared as $entry) {
            $name = explode(':', $entry, 2)[0];

            if (\in_array($name, self::FOLIO_APPLIED_GROUPS, true) || \in_array($name, $allowed, true)) {
                continue;
            }

            throw new \InvalidArgumentException(sprintf("Middleware CMS '%s' non ammesso dal JSON della pagina: ammessi %s (cms.config.page_middleware_allowlist).", $entry, implode(', ', $allowed) ?: 'nessuno'));
        }

        return $declared;
    }

    /**
     * @return list<string>
     */
    private function allowedNames(): array
    {
        $configured = config('cms.config.page_middleware_allowlist');
        if (! \is_array($configured)) {
            return [];
        }

        return array_values(array_filter($configured, static fn (mixed $name): bool => \is_string($name) && $name !== ''));
    }
}
