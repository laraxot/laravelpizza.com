<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListSections extends LangBaseListRecords
{
    protected static string $resource = SectionResource::class;

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->sortable()->searchable(),
            'slug' => TextColumn::make('slug')->sortable()->searchable(),
        ];
    }
}
