<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Geo\Models\Locality;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\Region;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class AddressForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->maxLength(255),
            'country' => TextInput::make('country') // Nazione
                ->maxLength(255)
                ->default('Italia')
                ->visible(false)
                ->columnSpan(2),
            'administrative_area_level_1' => Select::make('administrative_area_level_1')
                ->options(Region::getOptions(...))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(function (Set $set): void {
                    $set('administrative_area_level_2', null);
                    $set('locality', null);
                    $set('postal_code', null);
                    $set('cap', null);
                }),
            'administrative_area_level_2' => Select::make('administrative_area_level_2')
                ->options(Province::getOptions(...))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(function (Set $set): void {
                    $set('cap', null);
                    $set('postal_code', null);
                    $set('locality', null);
                })
                ->disabled(fn (Get $get) => ! $get('administrative_area_level_1'))
                ->placeholder(__('filament-forms::components.select.placeholder')),
            'locality' => Select::make('locality')
                ->options(Locality::getOptions(...))
                ->searchable()
                ->required()
                ->live()
                ->disabled(fn (Get $get) => ! $get('administrative_area_level_1') || ! $get('administrative_area_level_2'))
                ->extraAttributes(['class' => 'h-8 flex items-center'])
                ->afterStateUpdated(function (Set $set): void {
                    $set('postal_code', null);
                })
                ->placeholder(__('filament-forms::components.select.placeholder')),
            'postal_code' => Select::make('postal_code')
                ->options(Locality::getPostalCodeOptions(...))
                ->searchable()
                ->required()
                ->live()
                ->disabled(fn (Get $get) => ! $get('administrative_area_level_1') || ! $get('administrative_area_level_2'))
                ->placeholder(__('filament-forms::components.select.placeholder')),
            'route' => TextInput::make('route')->required()->maxLength(255),
            'street_number' => TextInput::make('street_number')->maxLength(20),
            'is_primary' => Toggle::make('is_primary')->default(false),
        ];
    }
}
