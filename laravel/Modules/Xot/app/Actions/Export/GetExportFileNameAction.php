<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Export;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Arr;
use Spatie\QueueableAction\QueueableAction;

/**
 * Nome file (senza estensione) dell'export di una lista: `{Pagina}-{filtri}`.
 *
 * Unico punto per i due canali export (`ExportXlsAction` custom e
 * `XotBaseExportAction` nativa): stessa lista, stessi filtri, stesso nome file.
 * L'estensione la aggiunge il chiamante (`.xlsx` in `ExportXlsAction`) o il
 * downloader Filament.
 */
class GetExportFileNameAction
{
    use QueueableAction;

    public function execute(ListRecords $livewire): string
    {
        $parts = array_map(
            static fn (mixed $value): string => is_scalar($value) ? (string) $value : '',
            Arr::flatten($livewire->tableFilters ?? []),
        );

        return class_basename($livewire).'-'.implode('-', $parts);
    }
}
