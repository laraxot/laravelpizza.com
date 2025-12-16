<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\CacheResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Actions\Header\ArtisanHeaderAction;
use Modules\Xot\Filament\Resources\CacheResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

/**
 * @see CacheResource
 */
class ListCaches extends XotBaseListRecords
{
    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;

    protected static string $resource = CacheResource::class;

    public function getHeaderWidgets(): array
    {
        return [
            // Clock::make(),
        ];
    }

    #[Override]
    public function getTableColumns(): array
    {
        return [
            'key' => TextColumn::make('key')
                ->searchable()
                ->sortable()
                ->wrap()
                ->label('Key'),
            'value' => TextColumn::make('value')
                ->searchable()
                ->wrap()
                ->label('Value'),
            'expiration' => TextColumn::make('expiration')
                ->dateTime()
                ->sortable()
                ->label('Expiration'),
        ];
    }

    #[Override]
    public function getGridTableColumns(): array
    {
        return [
            Stack::make($this->getTableColumns()),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
            'route_list' => ArtisanHeaderAction::make('route:list'),
            'icons_cache' => ArtisanHeaderAction::make('icons:cache'),
            'filament_cache_components' => ArtisanHeaderAction::make('filament:cache-components'),
            'filament_clear_cached_components' => ArtisanHeaderAction::make('filament:clear-cached-components'),
        ];
    }
}
