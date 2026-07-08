<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\DefaultActivityResource\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Incentivi\Filament\Resources\DefaultActivityResource\Actions\DefaultActivitiesSeederAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DefaultActivitiesTable extends XotBaseResourceTable
{
    public function getTableHeaderActions(): array
    {
        $actions = parent::getTableHeaderActions();
        $actions['default_activities_seeder'] = DefaultActivitiesSeederAction::make();

        return $actions;
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'nome' => TextColumn::make('nome')
                ->limit(50)
                ->searchable(),
            'tipo' => TextColumn::make('tipo')
                ->searchable(),
            'appartiene_a_liquidazione_a_fasi' => IconColumn::make('appartiene_a_liquidazione_a_fasi')
                // ->label('A fasi?')
                ->boolean(),
            'liquidazione_fasi' => TextColumn::make('liquidazione_fasi')
                // ->label('Fasi')
                ->searchable(),
            'quota_percentuale' => TextColumn::make('quota_percentuale')
                ->searchable(),
            'importo' => TextColumn::make('importo')
                ->money('EUR')
                ->placeholder('DA ASSEGNARE'),
            'anno_competenza' => TextColumn::make('anno_competenza')
                ->searchable(),
        ];
    }
}
