<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource\Pages;

use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListIndennitaTipos extends XotBaseListRecords
{
    protected static string $resource = IndennitaTipoResource::class;

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
            'nome' => TextColumn::make('nome')
                ->label('Nome')
                ->sortable()
                ->searchable(),
            'descrizione' => TextColumn::make('descrizione')
                ->label('Descrizione')
                ->limit(50)
                ->searchable(),
            'attivo' => BooleanColumn::make('attivo')
                ->label('Attivo')
                ->sortable(),
            'updated_at' => TextColumn::make('updated_at')
                ->label('Ultima Modifica')
                ->dateTime()
                ->sortable(),
        ];
    }
}
