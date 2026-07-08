<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

class IndennitaResponsabilitaExporter extends Exporter
{
    protected static ?string $model = IndennitaResponsabilita::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('matr'),
            ExportColumn::make('cognome'),
            ExportColumn::make('nome'),
            ExportColumn::make('email'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your indennita responsabilita export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
