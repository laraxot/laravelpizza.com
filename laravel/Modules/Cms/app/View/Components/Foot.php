<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Xot\Datas\MetatagData;

/**
 * La coda del documento front office: script e stack a fine body.
 *
 * Simmetrico a {@see Head}: la vista emette il blocco finale del body e i layout non lo duplicano.
 * NON emette `</body>`/`</html>`: i tag di chiusura del documento appartengono al layout,
 * che ha aperto `<html>`/`<body>` — un componente non deve chiudere elementi che non ha aperto.
 * Contiene gli script e gli stack che devono vivere a fine body:
 * notifiche Filament/Livewire, script Filament, bundle JS del tema attivo (lo stesso `pub_theme`
 * risolto da `MetatagData`, esattamente come il CSS in `cms::components.head`), gli stack `scripts`
 * riempiti dai componenti via `@push('scripts')` e lo yield Folio `scripts`.
 *
 * `@livewireScripts` non serve: `config('livewire.inject_assets')` è `true` e Livewire inietta i propri
 * asset automaticamente prima di `</body>`.
 */
final class Foot extends Component
{
    public function render(): ViewContract
    {
        return view('cms::components.foot', [
            'pubTheme' => MetatagData::make()->getPubTheme(),
        ]);
    }
}
