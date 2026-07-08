<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Incentivi\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListActivities extends XotBaseListRecords
{
    protected static string $resource = ActivityResource::class;

    // public static function route(string $path): string
    // {
    //    return $this->$resource::route('/activities' . $path);
    // }

    #[Override]
    protected function getHeaderActions(): array
    {
        return parent::getHeaderActions();
    }

    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
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
            // 'quota_percentuale_sum' => Tables\Columns\TextColumn::make('quota_percentuale')
            //     ->summarize(Sum::make()->label('TOTALE %')),
            'project_nome' => TextColumn::make('project.nome')
                // ->label('Progetto')
                ->limit(30),
            'employees_cognome' => TextColumn::make('employees.cognome')
                // ->label('Componenti')
                ->placeholder('Nessun componente presente.')
                ->limit(50),
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
        return parent::getTableActions();
    }
}
