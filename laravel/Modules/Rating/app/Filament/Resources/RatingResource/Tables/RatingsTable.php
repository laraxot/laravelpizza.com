<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class RatingsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'slug' => TextColumn::make('slug')->searchable()->sortable(),
            'rule' => TextColumn::make('rule')->badge()->sortable(),
            'is_disabled' => TextColumn::make('is_disabled')->badge()->sortable(),
            'is_readonly' => TextColumn::make('is_readonly')->badge()->sortable(),
            'order_column' => TextColumn::make('order_column')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
