<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_match;

/**
 * Ricorda la pagina a cui tornare dopo il login (CMT-022).
 *
 * Un ospite che legge un articolo e clicca «Accedi per commentare» non passa da un middleware `auth`, quindi Laravel non salva
 * `url.intended` e `LoginWidget::redirectIntended()` lo porterebbe alla dashboard. Il link porta `?redirect=/it/blog/...`: qui il
 * valore diventa `url.intended` solo se e' un percorso interno. Schema, host, `//` e `\` sono rifiutati: il parametro arriva dalla
 * barra degli indirizzi, quindi senza questo controllo il login diventerebbe un redirect aperto verso un sito qualunque.
 */
class StoreIntendedUrlAction
{
    use QueueableAction;

    public function execute(mixed $target): bool
    {
        if (! is_string($target) || ! $this->isInternalPath($target)) {
            return false;
        }

        session()->put('url.intended', url($target));

        return true;
    }

    private function isInternalPath(string $target): bool
    {
        return str_starts_with($target, '/')
            && ! str_starts_with($target, '//')
            && ! str_contains($target, '\\')
            && preg_match('/^[\x21-\x7E]+$/', $target) === 1;
    }
}
