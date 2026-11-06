<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class LocationForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'main' => Section::make()
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('latitude')->required()->numeric(),
                    TextInput::make('longitude')->required()->numeric(),
                    TextInput::make('street')->maxLength(255),
                    TextInput::make('city')->maxLength(255),
                    TextInput::make('state')->maxLength(255),
                    TextInput::make('zip')->maxLength(255),
                    TextInput::make('formatted_address')->maxLength(1024),
                ]),
        ];
    }
}
