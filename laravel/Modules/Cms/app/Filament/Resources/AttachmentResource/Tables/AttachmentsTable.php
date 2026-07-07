<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AttachmentsTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'description' => TextColumn::make('description')->limit(50),
            'slug' => TextColumn::make('slug'),
            'disk' => TextColumn::make('disk'),
        ];
    }
}
