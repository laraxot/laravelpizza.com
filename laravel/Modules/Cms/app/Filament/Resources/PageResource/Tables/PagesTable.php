<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PagesTable extends XotBaseResourceTable
{
    public static function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'slug' => TextColumn::make('slug'),
            'description' => TextColumn::make('description')->limit(50),
            'middleware' => TextColumn::make('middleware'),
        ];
    }
}
