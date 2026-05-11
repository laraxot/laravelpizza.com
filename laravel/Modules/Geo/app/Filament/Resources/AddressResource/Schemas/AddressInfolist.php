<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class AddressInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'description' => TextEntry::make('description'),
            'route' => TextEntry::make('route'),
            'street_number' => TextEntry::make('street_number'),
            'locality' => TextEntry::make('locality'),
            'comune' => TextEntry::make('administrative_area_level_3'),
            'provincia' => TextEntry::make('administrative_area_level_2'),
            'regione' => TextEntry::make('administrative_area_level_1'),
            'country' => TextEntry::make('country'),
            'postal_code' => TextEntry::make('postal_code'),
            'latitude' => TextEntry::make('latitude'),
            'longitude' => TextEntry::make('longitude'),
            'type' => TextEntry::make('type'),
            'is_primary' => TextEntry::make('is_primary')->badge(),
        ];
    }
}
