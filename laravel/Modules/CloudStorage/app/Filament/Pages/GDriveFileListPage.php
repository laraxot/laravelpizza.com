<?php

declare(strict_types=1);
// File: Laravel/Modules/CloudStorage/Filament/Pages/GDriveFileListPage.php

namespace Modules\CloudStorage\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class GDriveFileListPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cloud';

    protected static ?string $navigationLabel = 'File di Google Drive';

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('Nome File')->sortable()->searchable(),
            TextColumn::make('mimeType')->label('Tipo'),
            TextColumn::make('modifiedTime')->label('Modificato')->dateTime(),
            TextColumn::make('size')
                ->label('Dimensione')
                ->formatStateUsing(fn ($state) => is_numeric($state) ? number_format((float) $state / 1024, 2).' KB' : 'N/A'),
        ];
    }
    /*
    public function getTableRecords(): LengthAwarePaginator
    {
        $driveService = app(GoogleDriveService::class);
        $files = collect($driveService->getFiles());

        // Paginazione manuale (10 risultati per pagina)
        $perPage = 10;
        $currentPage = request()->input('page', 1);

        // Creazione di un paginatore manuale
        return new LengthAwarePaginator(
            $files->forPage($currentPage, $perPage),
            $files->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function getTable(): Tables\Table
    {
        // Passiamo `$this` come argomento a `Table::make()`
        return Tables\Table::make($this)
            ->columns($this->getTableColumns())
            ->query(fn () => $this->getTableRecords()); // Impostiamo la query per la tabella
    }
    */
}
