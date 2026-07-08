<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MessageResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\MessageResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListMessages extends PtvBaseYearListRecords
{
    protected static string $resource = MessageResource::class;

    #[Override]
    /**
     * @return array<string, mixed>
     */
    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'type' => TextColumn::make('type')
                ->searchable()
                ->sortable(),
            'title' => TextColumn::make('title')
                ->searchable()
                ->sortable(),
            'txt' => TextColumn::make('txt')
                ->searchable()
                ->sortable()
                ->wrap(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
