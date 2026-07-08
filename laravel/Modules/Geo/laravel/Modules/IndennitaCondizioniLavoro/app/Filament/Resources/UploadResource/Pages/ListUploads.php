<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListUploads extends XotBaseListRecords
{
    protected static string $resource = UploadResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        // Multiple @var tags removed - types inferred by Filament v4
        return [
            'create' => CreateAction::make(),
        ];
    }

    #[Override]
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
