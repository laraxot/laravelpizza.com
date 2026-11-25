<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\Layout\Component as LayoutComponent;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as FilamentTableWidget;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Filament\Traits\TransTrait;

abstract class XotBaseTableWidget extends FilamentTableWidget
{
    use HasXotTable;
    use InteractsWithPageFilters;
    use TransTrait;

    /**
     * Colonne della tabella: le sottoclassi le dichiarano qui e `HasXotTable::table()` le legge.
     *
     * @return array<int|string, Column|ColumnGroup|LayoutComponent>
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    #[\Override]
    protected function getTableColumns(): array
    {
        return [];
    }

    /**
     * Ascolta evento di aggiornamento filtri.
     *
     * @param  array<string, mixed>  $filters
     */
    #[On('filterUpdate')]
    public function updateFilters(array $filters): void
    {
        // Forza refresh della tabella quando i filtri cambiano
        $this->resetTable();
    }

    /**
     * Restituisce una chiave univoca per ogni record.
     * Usa _id che è l'alias della primary key creato da withAnswersLabel().
     *
     * IMPORTANTE: Non usare mai chiavi hardcoded, altrimenti Livewire
     * pensa che tutti i record siano lo stesso e mostra duplicati.
     */
    public function getTableRecordKey(Model|array $record): string
    {
        if (\is_array($record)) {
            return SafeStringCastAction::cast($record['_id'] ?? $record['id'] ?? '');
        }

        return SafeStringCastAction::cast($record->_id ?? $record->id ?? '');
    }
}
