<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzaResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class AssenzaForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'tipo' => TextInput::make('tipo')->numeric(),
            'codice' => TextInput::make('codice')->numeric(),
            'descr' => TextInput::make('descr')->maxLength(250),
            'anno' => TextInput::make('anno')->numeric(),
            'umi' => TextInput::make('umi')->maxLength(2),
            'dur' => TextInput::make('dur')->maxLength(50),
        ];
    }
}
