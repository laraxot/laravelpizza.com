<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class CriteriEsclusioneForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->maxLength(50),
            'field_name' => TextInput::make('field_name')
                ->maxLength(50),
            'op' => TextInput::make('op')
                ->maxLength(50),
            'value' => TextInput::make('value')
                ->maxLength(50),
            'anno' => TextInput::make('anno')
                ->numeric(),
        ];
    }
}
