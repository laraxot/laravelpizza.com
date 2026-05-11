<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AttachmentsTable extends XotBaseResourceTable
{
    public static function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'description' => TextColumn::make('description')->limit(50),
            'slug' => TextColumn::make('slug'),
            'disk' => TextColumn::make('disk'),
        ];
    }
}
