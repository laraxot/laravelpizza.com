<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Imports;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Modules\Progressioni\Models\CedDiff;

class CedDiffImporter extends Importer
{
    protected static ?string $model = CedDiff::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('matricola'),
            ImportColumn::make('cognome'),
            ImportColumn::make('nome'),
            ImportColumn::make('dal'),
            ImportColumn::make('al'),
            ImportColumn::make('importo_forzato'),
            ImportColumn::make('importo_base'),
            ImportColumn::make('voce'),
            ImportColumn::make('descrizione'),
            ImportColumn::make('istituto'),
            ImportColumn::make('tipo'),
            ImportColumn::make('ruolo'),
            ImportColumn::make('ruolo_txt'),
            ImportColumn::make('profilo'),
            ImportColumn::make('profilo_txt'),
            ImportColumn::make('posizione_funzionale'),
            ImportColumn::make('descr_posizione_funzionale'),
            ImportColumn::make('stabilimento'),
            ImportColumn::make('stabi_txt'),
            ImportColumn::make('reparto'),
            ImportColumn::make('repar_txt'),
            //
        ];
    }

    public function resolveRecord(): ?CedDiff
    {
        // return CedDiff::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new CedDiff;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your ced diff import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
