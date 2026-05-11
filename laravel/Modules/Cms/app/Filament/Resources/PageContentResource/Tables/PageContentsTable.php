<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PageContentsTable extends XotBaseResourceTable
{
    public static function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'slug' => TextColumn::make('slug'),
        ];
    }
}
