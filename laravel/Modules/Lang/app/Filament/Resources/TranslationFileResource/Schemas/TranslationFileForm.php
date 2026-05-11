<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\TranslationFileResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TranslationFileForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id'),
            'name' => TextInput::make('name'),
            'path' => TextInput::make('path'),
            'content' => KeyValue::make('content'),
        ];
    }
}
