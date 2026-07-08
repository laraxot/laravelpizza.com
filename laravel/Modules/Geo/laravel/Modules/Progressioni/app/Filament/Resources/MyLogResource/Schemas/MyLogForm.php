<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MyLogResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MyLogForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'id_tbl' => TextInput::make('id_tbl')->numeric(),
            'tbl' => TextInput::make('tbl'),
            'id_approvaz' => TextInput::make('id_approvaz')->numeric(),
            'note' => Textarea::make('note')->rows(3),
            'obj' => TextInput::make('obj'),
            'act' => TextInput::make('act'),
            'data' => KeyValue::make('data'),
            'datemod' => TextInput::make('datemod'),
            'handle' => TextInput::make('handle'),
        ];
    }
}
