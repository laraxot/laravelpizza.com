<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as FilamentTableWidget;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Modules\Xot\Filament\Traits\HasXotTable;

abstract class XotBaseTableWidget extends FilamentTableWidget
{
    use HasXotTable;
    use InteractsWithPageFilters;

    /**
     * Ascolta evento di aggiornamento filtri.
     */
    #[On('filterUpdate')]
    public function updateFilters(array $filters): void
    {
        $this->resetTable();
    }

    /**
     * Get the record key for the table.
     */
    public function getTableRecordKey(Model|array $record): string
    {
        if (\is_array($record)) {
            return (string) ($record['id'] ?? '');
        }

        return (string) ($record->getKey() ?? '');
    }
}
