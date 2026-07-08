<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriOptionResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class CriteriOptionForm extends XotBaseResourceForm
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
            'type' => Select::make('type')
                ->options([
                    'string' => 'Stringa',
                    'int' => 'Intero',
                    'date' => 'Data',
                    'list' => 'Lista',
                ])
                ->required(),
            'anno' => TextInput::make('anno')->numeric()->required(),
            'note' => Textarea::make('note')->rows(3),
        ];
    }
}
