<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Exports;

use Filament\Resources\Pages\ListRecords;

/**
 * Pagina lista fake: serve solo `class_basename` + `tableFilters` a
 * `GetExportFileNameAction`. Nessun mount Livewire, nessuna query.
 */
class ListRecordsStub extends ListRecords
{
    protected static string $resource = ResourceWithXlsFieldsStub::class;
}
