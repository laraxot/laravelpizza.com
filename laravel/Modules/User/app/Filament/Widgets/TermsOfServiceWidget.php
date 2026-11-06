<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Illuminate\Contracts\View\View;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * TermsOfServiceWidget: widget per visualizzare i termini di servizio nel panel.
 *
 * Sostituisce il vecchio Livewire `Modules\User\Http\Livewire\TermsOfService`.
 * Equivalenza verificata (story 10.4, parte TermsOfService): il vecchio componente
 * leggeva `config('terms-of-service.text')` — nessun file `config/terms-of-service.php`
 * esiste nel repo, quindi in produzione il testo era sempre assente. Qui manteniamo
 * la stessa lettura di config (nessuna regressione se la config viene aggiunta in
 * futuro), senza portare il checkbox `wire:click="testfunction"` -> `dddx('wip')`
 * del vecchio componente: era codice morto/debug, mai raggiungibile (il blocco che lo
 * conteneva era condizionato allo stesso testo sempre assente).
 */
final class TermsOfServiceWidget extends XotBaseWidget
{
    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'user::filament.widgets.terms-of-service';

        $terms = config('terms-of-service.text');

        return view($viewName, [
            'terms' => is_string($terms) ? $terms : '',
        ]);
    }
}
