<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\SessionResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class SessionForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('id')->required()->maxLength(255),
            TextInput::make('user_id')->numeric(),
            TextInput::make('ip_address')->maxLength(45),
            TextInput::make('user_agent')->maxLength(255),
            KeyValue::make('payload')->columnSpanFull(),
            TextInput::make('last_activity')->required()->numeric(),
        ];
    }
}
