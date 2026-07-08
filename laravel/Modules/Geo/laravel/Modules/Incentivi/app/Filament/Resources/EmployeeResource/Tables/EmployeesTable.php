<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\EmployeeResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Modules\Incentivi\Filament\Resources\EmployeeResource\Actions\UploadEmpoyeesAction;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class EmployeesTable extends XotBaseResourceTable
{
    public function getTableHeaderActions(): array
    {
        return [
            // ...parent::getTableHeaderActions(),
            'Carica/Aggiorna Dipendenti' => UploadEmpoyeesAction::make('Carica/Aggiorna Dipendenti')
                ->visible(fn () => auth()->check() && auth()->user()?->isSuperAdmin()),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'matricola' => TextColumn::make('matricola')
                ->searchable()
                ->sortable(),
            'full_name' => TextColumn::make('full_name')
                ->searchable(['nome', 'cognome'])
                ->sortable(['nome', 'cognome']),
            'tipologia' => TextColumn::make('tipologia'),
            // 'sesso' => TextColumn::make('sesso'),
            'codice_fiscale' => TextColumn::make('codice_fiscale'),
            'posizione_inail' => TextColumn::make('posizione_inail'),
            /*
            Tables\Columns\TextColumn::make('tqu00f_desc1'),
            Tables\Columns\TextColumn::make('tqu00f_desc2'),
            */
            'tqu00f' => GroupColumn::make('tqu00f')->schema([
                'tqu00f_desc1' => TextColumn::make('tqu00f_desc1'),
                'tqu00f_desc2' => TextColumn::make('tqu00f_desc2'),
            ]),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        return [
            // ...parent::getTableActions(),
        ];
    }
}
