<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MenusTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'parent_id' => TextColumn::make('parent_id'),
        ];
    }
}
