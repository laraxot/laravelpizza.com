<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingMorphResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * RatingMorphTable Schema - XotBaseResourceTable Zen Pattern.
 *
 * Columns derived from RatingMorph model ($fillable) and migration:
 *
 * @see Modules\Rating\Models\RatingMorph
 * @see database/migrations/2023_01_01_000005_create_rating_morph_table.php
 */
class RatingMorphTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'rating_id' => TextColumn::make('rating_id')->sortable(),
            'model_type' => TextColumn::make('model_type')->searchable(),
            'model_id' => TextColumn::make('model_id')->sortable(),
            'user_id' => TextColumn::make('user_id')->sortable(),
            'value' => TextColumn::make('value')->numeric()->sortable(),
            'note' => TextColumn::make('note')->limit(50),
            'is_winner' => TextColumn::make('is_winner')->badge(),
            'reward' => TextColumn::make('reward')->numeric()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
