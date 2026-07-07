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
    public static function getFormSchema(): array
    {
        return [
            'main' => Section::make()
                ->schema([
                    TextInput::make('name'),
                ]),
        ];
    }
}
