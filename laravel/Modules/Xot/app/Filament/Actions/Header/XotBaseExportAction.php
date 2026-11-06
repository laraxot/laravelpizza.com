<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions\Header;

use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

/**
 * `ExportAction` nativa Filament 5 che serializza negli `options` dell'export il
 * Resource e i `tableFilters` correnti: il job queued li usa per ricostruire le
 * colonne dinamiche (es. una colonna per rating con `title` come intestazione)
 * in `XotBaseExporter::getCachedColumns()`.
 */
class XotBaseExportAction extends ExportAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(static function (): array {
            $livewire = app('livewire')->current();

            if (! $livewire instanceof ListRecords) {
                return [];
            }

            return [
                'resource' => $livewire->getResource(),
                'tableFilters' => $livewire->tableFilters ?? [],
            ];
        });
    }
}
