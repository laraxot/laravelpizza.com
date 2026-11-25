<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions;

use Filament\Actions\ExportAction as FilamentExportAction;
use Filament\Resources\Pages\ListRecords;
use Livewire\Component;
use Modules\Xot\Actions\Export\GetExportFileNameAction;
use Modules\Xot\Exports\Jobs\XotPrepareCsvExport;

/**
 * Base class for ExportAction.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's ExportAction to provide a XotBase layer.
 *
 * Serializza negli `options` del job queued `resource`, `tableFilters` e
 * `livewireClass`: senza questo, `Exporter::getCachedColumns()` non vede i
 * filtri e usa un transKey diverso da `ExportXlsAction` (page class). Le
 * colonne rating sparirebbero dal job asincrono pur esistendo in `getXlsFields()`.
 *
 * Nome file: lo stesso `{Pagina}-{filtri}` di `ExportXlsAction`
 * (`GetExportFileNameAction`); il downloader Filament aggiunge `.xlsx`.
 */
abstract class XotBaseExportAction extends FilamentExportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        // CSV intermedio senza escape `\` (vendor): un valore che finisce con `\`
        // inghiottirebbe il resto della riga. Reader: XotCreateXlsxFile (bound
        // in XotServiceProvider). Story Ptv/5.165.
        $this->job(XotPrepareCsvExport::class);

        $this->fileName(static function (Component $livewire): ?string {
            if (! $livewire instanceof ListRecords) {
                return null;
            }

            return app(GetExportFileNameAction::class)->execute($livewire);
        });

        $this->options(static function (): array {
            $livewire = app('livewire')->current();

            if (! $livewire instanceof ListRecords) {
                return [];
            }

            return [
                'resource' => $livewire->getResource(),
                'tableFilters' => $livewire->tableFilters ?? [],
                'livewireClass' => $livewire::class,
            ];
        });
    }
}
