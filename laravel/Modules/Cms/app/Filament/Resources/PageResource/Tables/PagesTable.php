<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PagesTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'slug' => TextColumn::make('slug'),
            'description' => TextColumn::make('description')->limit(50),
            'middleware' => TextColumn::make('middleware'),
        ];
    }
}
