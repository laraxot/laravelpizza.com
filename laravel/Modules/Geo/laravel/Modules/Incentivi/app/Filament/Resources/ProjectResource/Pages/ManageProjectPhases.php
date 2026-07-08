<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Components\Component;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Filament\Resources\PhaseResource;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Xot\Filament\Resources\XotBaseResource\Pages\XotBaseManageRelatedRecords;
use Override;

class ManageProjectPhases extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'phases';

    // protected static ?string $navigationIcon = 'heroicon-m-newspaper';
    /**
     * Define the form schema for managing related records.
     *
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),

            'description' => TextInput::make('description')
                ->label('Description')
                ->required()
                ->maxLength(255),

            'start_date' => DatePicker::make('start_date')
                ->label('Start Date')
                ->required(),

            'end_date' => DatePicker::make('end_date')
                ->label('End Date')
                ->required(),
        ];
    }

    /**
     * Define the table columns for displaying related records.
     *
     * @return array<TextColumn>
     */
    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'name' => TextColumn::make('name')
                ->label('Name')
                ->sortable()
                ->searchable(),

            'description' => TextColumn::make('description')
                ->label('Description')
                ->sortable()
                ->searchable(),

            'start_date' => TextColumn::make('start_date')
                ->label('Start Date')
                ->dateTime('d/m/Y')
                ->sortable(),

            'end_date' => TextColumn::make('end_date')
                ->label('End Date')
                ->dateTime('d/m/Y')
                ->sortable(),
            TextColumn::make('settlement.denominazione')
                ->label('Denominazione'),
            TextColumn::make('settlement.importo')
                ->label('Importo')
                ->numeric(
                    decimalPlaces: 2,
                    decimalSeparator: ',',
                    thousandsSeparator: '.'
                )
                ->prefix('€ '),
        ];
    }

    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
            'Nuova fase' => CreateAction::make('nuova-fase')
                ->label('Nuova Fase')
                ->disableCreateAnother(),
        ];
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    #[Override]
    public function getTableActions(): array
    {
        return [
            'handleSettlement' => Action::make('handleSettlement')
                ->label('Gestisci Liquidazione')
                ->tooltip('Gestisci Liquidazione')
                ->icon('heroicon-o-document-currency-euro')
                ->url(fn (Model $phase): string => PhaseResource::getUrl('edit', ['record' => $phase]),
                    shouldOpenInNewTab: false),
        ];
    }
}
