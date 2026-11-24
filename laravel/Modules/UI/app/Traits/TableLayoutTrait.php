<?php

declare(strict_types=1);

namespace Modules\UI\Traits;

use Illuminate\Support\Facades\Session;
use Modules\UI\Enums\TableLayoutEnum;

/**
 * Layout tabella legacy in sessione (chiave `table_layout`, default GRID) con `refreshTable()` e
 * `resetTable()` per i componenti Livewire.
 *
 * Nessuna classe di `app/` lo usa, in nessun progetto: lo esercitano solo i test del modulo
 * (`UiGapCloser100Test`, `UiHighestMissCoverageTest`). Il trait vivo, usato da `HasTableLayoutPage` e
 * `TableLayoutToggleTableAction`, e' `Modules\UI\Filament\Actions\Table\TableLayoutTrait` (chiave
 * `table_layout_{id}`, default LIST): i due non si fondono senza cambiare chiave di sessione e default.
 *
 * @see Modules/UI/docs/risoluzione-conflitti-tablelayouttrait.md perche' due trait e perche' questo resta
 *
 * @phpstan-ignore trait.unused (API legacy del modulo condiviso, coperta dai test UI: si ritira solo con una decisione esplicita, insieme a quei due blocchi di test, non per chiudere l'errore.)
 */
trait TableLayoutTrait
{
    public function getTableLayout(): TableLayoutEnum
    {
        $value = Session::get('table_layout');

        if ($value instanceof TableLayoutEnum) {
            return $value;
        }

        if (is_string($value) || is_int($value)) {
            return TableLayoutEnum::tryFrom((string) $value) ?? TableLayoutEnum::GRID;
        }

        return TableLayoutEnum::GRID;
    }

    public function setTableLayout(TableLayoutEnum $layout): void
    {
        Session::put('table_layout', $layout->value);
    }

    public function refreshTable(): void
    {
        $this->dispatch('$refresh');
        $this->resetTable();
    }

    public function resetTable(): void
    {
        // Implementazione predefinita - le classi che usano questo trait dovrebbero sovrascrivere questo metodo
        $this->dispatch('reset-table');
    }
}
