<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Pages;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListPages extends LangBaseListRecords
{
    protected static string $resource = PageResource::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'lang' => TextColumn::make('lang')->searchable()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->sortable()->dateTime(),
        ];
    }
}
