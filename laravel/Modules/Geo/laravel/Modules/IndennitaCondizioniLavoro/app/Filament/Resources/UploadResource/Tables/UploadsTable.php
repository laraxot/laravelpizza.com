<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Tables;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class UploadsTable extends XotBaseResourceTable
{
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
            'user_id' => TextColumn::make('user_id')
                ->label('Utente')
                ->sortable()
                ->searchable(),
            'path' => TextColumn::make('path')
                ->label('Percorso File')
                ->limit(50)
                ->searchable(),
            'note' => TextColumn::make('note')
                ->label('Note')
                ->limit(100)
                ->searchable(),
            'quadrimestre' => TextColumn::make('quadrimestre')
                ->label('Quadrimestre')
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->label('Anno')
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->label('Data Creazione')
                ->dateTime()
                ->sortable(),
            'created_by' => TextColumn::make('created_by')
                ->label('Creato da')
                ->searchable(),
        ];
    }
}
