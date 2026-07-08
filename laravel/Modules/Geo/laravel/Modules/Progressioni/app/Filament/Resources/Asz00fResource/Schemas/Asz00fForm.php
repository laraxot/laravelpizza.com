<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\Asz00fResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class Asz00fForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'ente' => TextInput::make('ente')->numeric(),
            'cont' => TextInput::make('cont')->numeric(),
            'matr' => TextInput::make('matr')->numeric(),
            'asztip' => TextInput::make('asztip')->numeric(),
            'aszcod' => TextInput::make('aszcod')->numeric(),
            'aszdal' => TextInput::make('aszdal')->numeric(),
            'aszal' => TextInput::make('aszal')->numeric(),
            'aszini' => TextInput::make('aszini')->maxLength(50),
            'aszfin' => TextInput::make('aszfin')->maxLength(50),
            'aszumi' => TextInput::make('aszumi')->maxLength(2),
            'aszpes' => TextInput::make('aszpes')->maxLength(50),
            'aszdur' => TextInput::make('aszdur')->maxLength(50),
            'aszann' => TextInput::make('aszann')->maxLength(10),
            'asz2kd' => TextInput::make('asz2kd')->numeric(),
            'asz2ka' => TextInput::make('asz2ka')->numeric(),
        ];
    }
}
