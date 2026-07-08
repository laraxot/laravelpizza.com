<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Filament\Resources\ActivityResource;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Override;

class ManageProjectActivities extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'activities';

    protected static string $recordTitleAttribute = 'nome';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('nome')
                ->required()
                ->maxLength(255),
            Select::make('tipo')
                ->required()
                ->options([
                    'Lavori' => 'Lavori',
                    'Servizi' => 'Servizi',
                    'Misti' => 'Misti',
                ]),
            TextInput::make('quota_percentuale')
                ->required()
                ->suffix('%'),
            TextInput::make('importo')
                ->required()
                ->suffix('€')
                ->default(0),
            TextInput::make('anno_competenza')
                ->required()
                ->maxLength(4),
            // Forms\Components\TextInput::make('project_id')
            //     ->required()
            //     ->disabled(),
        ];
    }




    /**
     * @return array<Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'nome' => TextColumn::make('nome')
                ->limit(70)
                ->searchable(),
            'quota_percentuale' => TextColumn::make('quota_percentuale')
                ->suffix('%')
                ->searchable(),
            'importo' => TextColumn::make('importo')
                ->money('EUR', decimalPlaces: 2)
                ->suffix('€ ')
                ->placeholder('DA CALCOLARE'),
            'anno_competenza' => TextInputColumn::make('anno_competenza')
                ->type('number')
                ->rules(['required', 'numeric'])
                ->searchable(),
            'quota_percentuale_sum' => TextColumn::make('quota_percentuale')
                ->summarize(Sum::make()->label('TOTALE %')),
            'importo_sum' => TextColumn::make('importo')
                ->summarize(Sum::make()->label('TOTALE €')->money('EUR', decimalPlaces: 2)),
            'employees.full_name' => TextColumn::make('employees.full_name')
                ->placeholder('Nessun componente')
                ->badge(),
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
            'delete' => DeleteAction::make(),
            'handleEmployees' => Action::make('handleEmployees')
                ->label('Componenti')
                ->tooltip('Gestisci Componenti')
                ->icon('heroicon-m-user-group')
                ->url(fn (Model $activity): string => ActivityResource::getUrl('edit', ['record' => $activity]),
                    shouldOpenInNewTab: false),
        ];
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    public function getTablePaginated(): bool
    {
        return false;
    }

    public function canAttach(): bool
    {
        return false;
    }

    public function canCreate(): bool
    {
        return false;
    }

    #[Override]
    public function getTableBulkActions(): array
    {
        return [

        ];
    }
}
