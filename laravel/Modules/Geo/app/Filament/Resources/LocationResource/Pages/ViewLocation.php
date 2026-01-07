<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Pages;

use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLocation extends XotBaseViewRecord
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'location_info' => Section::make('Informazioni Location')->schema([
                'location_grid' => Grid::make(['default' => 2])->schema([
                    'name' => TextEntry::make('name'),
                    'formatted_address' => TextEntry::make('formatted_address'),
                    'street' => TextEntry::make('street'),
                    'city' => TextEntry::make('city'),
                    'state' => TextEntry::make('state'),
                    'zip' => TextEntry::make('zip'),
                    'lat' => TextEntry::make('lat'),
                    'lng' => TextEntry::make('lng'),
                ]),
            ]),
        ];
    }
}
