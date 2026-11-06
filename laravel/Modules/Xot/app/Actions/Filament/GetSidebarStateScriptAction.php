<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Spatie\QueueableAction\QueueableAction;

/**
 * Script di avvio per lo store `sidebar` di Filament 5.10.3.
 *
 * Lo store parte con `collapsedGroups = null` e chiama `.includes()` senza
 * controllo: al primo accesso di un browser (chiave assente in localStorage)
 * tutti i gruppi della sidebar falliscono e il menu dei moduli non si vede.
 * Lo script scrive `[]` solo quando il valore manca o e' `null`, cosi' le
 * preferenze gia' salvate dall'utente restano intatte.
 */
class GetSidebarStateScriptAction
{
    use QueueableAction;

    public function execute(): string
    {
        return <<<'HTML'
            <script>
                (function () {
                    try {
                        var stored = window.localStorage.getItem('filament:sidebar:collapsed_groups');
                        if (stored === null || stored === 'null') {
                            window.localStorage.setItem('filament:sidebar:collapsed_groups', '[]');
                        }
                    } catch (error) {
                        // localStorage bloccato (modalita' privata, cookie disabilitati):
                        // lo store non e' persistente e il problema non si presenta.
                    }
                })();
            </script>
            HTML;
    }
}
