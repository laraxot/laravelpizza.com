<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\MyLogResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
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
        // Types are inferred by Filament v4
        return [
            'id_tbl' => TextInput::make('id_tbl')
                ->numeric(),
            'tbl' => TextInput::make('tbl')
                ->maxLength(50),
            'id_approvaz' => TextInput::make('id_approvaz')
                ->numeric(),
            'note' => Textarea::make('note')
                ->columnSpanFull(),
            'data' => Textarea::make('data')
                ->columnSpanFull(),
            'datemod' => DateTimePicker::make('datemod'),
            'handle' => TextInput::make('handle')
                ->maxLength(150),
            'created_by' => TextInput::make('created_by')
                ->maxLength(255),
            'updated_by' => TextInput::make('updated_by')
                ->maxLength(255),

        ];
    }
}
