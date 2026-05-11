<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\TemporaryUploadResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TemporaryUploadsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'session_id' => TextColumn::make('session_id')->searchable()->sortable(),
            'user_id' => TextColumn::make('user_id')->searchable()->sortable(),
            'file_name' => TextColumn::make('file_name')->searchable(),
            'file_size' => TextColumn::make('file_size')->sortable(),
            'mime_type' => TextColumn::make('mime_type')->searchable(),
            'status' => TextColumn::make('status')->badge()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
