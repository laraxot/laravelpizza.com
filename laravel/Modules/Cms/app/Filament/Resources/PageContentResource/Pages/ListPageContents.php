<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageContentResource\Pages;

use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListPageContents extends LangBaseListRecords
{
    public function getGridTableColumns(): array
    {
        return [
            Stack::make($this->getTableColumns()),
        ];
    }

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('slug')->sortable()->searchable(),
        ];
    }
}
