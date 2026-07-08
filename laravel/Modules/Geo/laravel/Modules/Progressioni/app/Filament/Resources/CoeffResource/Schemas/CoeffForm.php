<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CoeffResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class CoeffForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'name' => TextInput::make('name')->required(),
            'value' => TextInput::make('value')->required(),
            'anno' => TextInput::make('anno')->numeric(),
        ];
    }
}
