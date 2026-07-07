<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ExtraResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
<<<<<<< HEAD
use Filament\Schemas\Components\Component as SchemaComponent;
=======
use Filament\Schemas\Components\Component;
>>>>>>> 40b96bcd6 (.)
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ExtraForm extends XotBaseResourceForm
{
    /**
<<<<<<< HEAD
     * @return array<int|string, SchemaComponent>
=======
     * @return array<int|string, Component>
>>>>>>> 40b96bcd6 (.)
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->required()->maxLength(36),
            'post_type' => TextInput::make('post_type')->required()->maxLength(255),
            'post_id' => TextInput::make('post_id')->required()->numeric(),
            'value' => KeyValue::make('value')
                ->keyLabel('Chiave')
                ->valueLabel('Valore')
                ->reorderable()
                ->columnSpanFull(),
        ];
    }
}
