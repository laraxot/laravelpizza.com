<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\LogResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class LogForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(255),
            'path' => TextInput::make('path')->required()->maxLength(255),
            'content' => Textarea::make('content')->columnSpanFull(),
        ];
    }
}
