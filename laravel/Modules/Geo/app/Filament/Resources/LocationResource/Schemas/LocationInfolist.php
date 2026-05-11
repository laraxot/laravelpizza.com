<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class LocationInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'lat' => TextEntry::make('lat'),
            'lng' => TextEntry::make('lng'),
            'street' => TextEntry::make('street'),
            'city' => TextEntry::make('city'),
            'state' => TextEntry::make('state'),
            'zip' => TextEntry::make('zip'),
            'formatted_address' => TextEntry::make('formatted_address'),
            'processed' => TextEntry::make('processed')->badge(),
            'description' => TextEntry::make('description'),
        ];
    }
}
