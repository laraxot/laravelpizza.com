<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\VenueResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Usato anche dal form evento per creare un venue senza uscire dalla pagina (createOptionForm).
 */
class VenueForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(191),
            'address' => TextInput::make('address')->maxLength(191),
            'city' => TextInput::make('city')->required()->maxLength(191),
            'country' => TextInput::make('country')->maxLength(191)->default('Italia'),
            'capacity' => TextInput::make('capacity')->numeric()->integer()->minValue(1),
            'website' => TextInput::make('website')->url()->maxLength(191),
            'phone' => TextInput::make('phone')->tel()->maxLength(191),
            'latitude' => TextInput::make('latitude')->numeric()->minValue(-90)->maxValue(90),
            'longitude' => TextInput::make('longitude')->numeric()->minValue(-180)->maxValue(180),
            'description' => Textarea::make('description')->rows(3)->columnSpanFull(),
        ];
    }
}
