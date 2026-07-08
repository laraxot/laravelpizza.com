<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Filament\Resources\ProjectResource\Pages;
use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;
use Override;

class ManageActivityEmployees extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'employees';

    // protected static ?string $slug = 'activity/employees';

    #[Override]
    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            'nome' => TextInput::make('nome')
                ->required()
                ->maxLength(255),
            'tipo' => Select::make('tipo')
                ->required()
                ->options([
                    'Lavori' => 'Lavori',
                    'Servizi' => 'Servizi',
                    'Misti' => 'Misti',
                ]),
            'quota_percentuale' => TextInput::make('quota_percentuale')
                ->required()
                ->suffix('%'),
            'importo' => TextInput::make('importo')
                ->required()
                ->suffix('€')
                ->default(0),
            'anno_competenza' => TextInput::make('anno_competenza')
                ->required()
                ->maxLength(4),
            'project_id' => TextInput::make('project_id')
                ->required()
                ->disabled(),
            'employees' => Select::make('employees')
                ->multiple()
                ->relationship('employees', 'cognome')
                ->required(),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'nome' => TextColumn::make('nome')
                ->limit(50)
                ->searchable(),
            'tipo' => TextColumn::make('tipo')
                ->searchable(),
            'quota_percentuale' => TextColumn::make('quota_percentuale')
                ->searchable(),
            'importo' => TextColumn::make('importo')
                ->money('EUR')
                ->placeholder('DA CALCOLARE'),
            'anno_competenza' => TextColumn::make('anno_competenza')
                ->searchable(),
            'quota_percentuale_sum' => TextColumn::make('quota_percentuale')
                ->summarize(
                    Sum::make()->label('TOTALE %')
                ),
            'employees_cognome' => TextColumn::make('employees.cognome')
                ->placeholder('Nessun componente.'),
        ];
    }

    /*
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            //'activities' => Pages\ManageProjectActivities::route('/{record}/activities'),
            //'employees' => Pages\ManageActivityEmployees::route('/{project}/activities/{record}/employees'),

        ];
    }
    */
}
