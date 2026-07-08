<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MessageResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MessagesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id'),
            'parent_id' => TextColumn::make('parent_id'),
            'type' => TextColumn::make('type'),
            'title' => TextColumn::make('title'),
            // TextColumn::make('txt'),
            'anno' => TextColumn::make('anno'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'anno' => SelectFilter::make('anno')
                ->options([
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                    '2026' => '2026',
                ]),
        ];
    }
}
