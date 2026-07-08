<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MessageResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Ptv\Filament\Resources\MessageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Traits\HasXotTable;
use Override;

abstract class BaseListMessages extends XotBaseListRecords
{
    use HasXotTable;

    protected static string $resource = MessageResource::class;

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'parent_id' => TextColumn::make('parent_id'),
            'type' => TextColumn::make('type'),
            'title' => TextColumn::make('title'),
            'anno' => TextColumn::make('anno'),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno')
                ->options([
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                    '2026' => '2026',
                ]),
        ];
    }
}
