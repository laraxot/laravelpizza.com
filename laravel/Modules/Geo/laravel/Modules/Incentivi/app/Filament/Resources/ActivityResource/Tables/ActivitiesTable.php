<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ActivitiesTable extends XotBaseResourceTable
{
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
}
