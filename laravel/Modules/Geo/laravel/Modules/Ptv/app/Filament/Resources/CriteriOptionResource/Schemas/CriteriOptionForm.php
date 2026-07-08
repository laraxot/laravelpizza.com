<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriOptionResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

use function Safe\date;

class CriteriOptionForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'name' => TextInput::make('name')
                ->label('Nome')
                ->required()
                ->maxLength(50),
            'value' => TextInput::make('value')
                ->label('Valore')
                ->required()
                ->maxLength(50),
            'anno' => TextInput::make('anno')
                ->label('Anno')
                ->required()
                ->numeric()
                ->default(date('Y')),
            'created_by' => TextInput::make('created_by')
                ->label('Creato da')
                ->maxLength(50)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),
        ];
    }
}
