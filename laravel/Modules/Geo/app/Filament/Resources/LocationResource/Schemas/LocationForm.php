<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Geo\Models\Location;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class LocationForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(255),
            'latitude' => TextInput::make('latitude')->required()->numeric(),
            'longitude' => TextInput::make('longitude')->required()->numeric(),
            'street' => TextInput::make('street')->maxLength(255),
            'city' => TextInput::make('city')->maxLength(255),
            'state' => TextInput::make('state')->maxLength(255),
            'zip' => TextInput::make('zip')->maxLength(255),
            'formatted_address' => TextInput::make('formatted_address')->maxLength(1024),
            // Temporaneamente commentato per compatibilità Filament 4.x
            // Map::make('location')
            //     ->reactive()
            //     ->afterStateUpdated(function (array $state, callable $set, callable $_get) {
            //         $set('lat', $state['lat']);
            //         $set('lng', $state['lng']);
            //     })
            //     ->drawingControl()
            //     ->defaultLocation([39.526610, -107.727261])
            //     ->mapControls([
            //         'zoomControl' => true,
            //     ])
            //     ->debug()
            //     ->clickable()
            //     ->autocomplete('formatted_address')
            //     ->autocompleteReverse()
            //     ->reverseGeocode([
            //         'city' => '%L',
            //         'zip' => '%z',
            //         'state' => '%A1',
            //         'street' => '%n %S',
            //     ])
            //     ->geolocate()
            //     ->columnSpan(2),
        ];
    }
}
