<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Fields;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class AddressField extends Section
{
    // protected string $optionValueProperty = 'id';

    protected function setUp(): void
    {
        parent::setUp();
        $this// ->description('The items you have selected for purchase')
            ->icon('heroicon-o-map-pin')
            // ->label(__('geo::place.fields.address'))
            ->relationship('place')
            ->schema([
                TextInput::make('route')->label(__('geo::place.fields.route')), // via
                TextInput::make('street_number')->label(__('geo::place.fields.street_number')), // civico
                TextInput::make('postal_code')->label(__('geo::place.fields.postal_code')), // 20124
                TextInput::make('locality')->label(__('geo::place.fields.locality')), // citta
                TextInput::make('administrative_area_level_2')->label(__(
                    'geo::place.fields.administrative_area_level_2',
                )), // provincia
                // TextInput::make('administrative_area_level_1')->label(__('geo::place.fields.administrative_area_level_1')), //regione
                TextInput::make('country')->label(__('geo::place.fields.country')), // italia
            ])
            ->columns(2);
    }
}
