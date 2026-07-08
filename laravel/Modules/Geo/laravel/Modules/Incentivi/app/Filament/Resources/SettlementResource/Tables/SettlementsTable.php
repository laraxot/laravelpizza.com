<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\SettlementResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SettlementsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'denominazione' => TextColumn::make('denominazione')
                // ->label('Denominazione')
                ->searchable(),
            'project_nome' => TextColumn::make('project.nome')
                // ->label('Progetto')
                ->sortable(),
            // Tables\Columns\TextColumn::make('tipologia')
            //     ->label('Tipo di liquidazione')
            //     ->searchable(),
            'created_at' => TextColumn::make('created_at')
                // ->label('Creata')
                ->dateTime()
                ->sortable(),
            'updated_at' => TextColumn::make('updated_at')
            // ->label('Aggiornata')
                ->dateTime()
                ->sortable(),
        ];
    }
}
