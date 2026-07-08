<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\EmployeeResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Incentivi\Filament\Resources\EmployeeResource;
use Modules\Incentivi\Filament\Resources\EmployeeResource\Actions\UploadEmpoyeesAction;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListEmployees extends XotBaseListRecords
{
    protected static string $resource = EmployeeResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            // ...parent::getHeaderActions(),
            'Carica/Aggiorna Dipendenti' => UploadEmpoyeesAction::make('Carica/Aggiorna Dipendenti')
                ->visible(fn () => auth()->check() && auth()->user()?->isSuperAdmin()),
        ];
    }

    #[Override]
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
     * Undocumented function.
     *
     * @return array<Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            // ...parent::getTableActions(),
        ];
    }
    
}
