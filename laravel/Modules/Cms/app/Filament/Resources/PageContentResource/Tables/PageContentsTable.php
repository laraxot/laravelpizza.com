<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PageContentsTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'slug' => TextColumn::make('slug'),
        ];
    }
}
