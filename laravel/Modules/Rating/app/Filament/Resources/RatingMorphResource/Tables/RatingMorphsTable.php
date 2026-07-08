<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingMorphResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class RatingMorphsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'rating_id' => TextColumn::make('rating_id')->sortable(),
            'user_id' => TextColumn::make('user_id')->searchable()->sortable(),
            'model_type' => TextColumn::make('model_type')->searchable()->sortable(),
            'model_id' => TextColumn::make('model_id')->searchable()->sortable(),
            'value' => TextColumn::make('value')->sortable(),
            'note' => TextColumn::make('note')->searchable(),
            'is_winner' => TextColumn::make('is_winner')->badge()->sortable(),
            'reward' => TextColumn::make('reward'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
