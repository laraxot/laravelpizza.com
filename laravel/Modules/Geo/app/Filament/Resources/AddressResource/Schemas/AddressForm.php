<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class AddressForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'main' => TextInput::make('name'),
        ];
    }
}
