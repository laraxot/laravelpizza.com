<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\FeatureResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FeaturesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'uuid' => TextColumn::make('uuid'),
            'name' => TextColumn::make('name')->searchable(),
            'scope' => TextColumn::make('scope'),
            'description' => TextColumn::make('description'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            'deleted_at' => TextColumn::make('deleted_at')->dateTime()->toggleable(),
            'updated_by' => TextColumn::make('updated_by')->toggleable(),
            'created_by' => TextColumn::make('created_by')->toggleable(),
            'deleted_by' => TextColumn::make('deleted_by')->toggleable(),
        ];
    }
}
