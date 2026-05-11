<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MediaTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'file_name' => TextColumn::make('file_name')->searchable()->sortable(),
            'mime_type' => TextColumn::make('mime_type')->searchable()->sortable(),
            'collection_name' => TextColumn::make('collection_name')->searchable()->sortable(),
            'disk' => TextColumn::make('disk')->sortable(),
            'size' => TextColumn::make('size')->sortable(),
            'order_column' => TextColumn::make('order_column')->sortable(),
            'model_type' => TextColumn::make('model_type')->searchable()->sortable(),
            'model_id' => TextColumn::make('model_id')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
