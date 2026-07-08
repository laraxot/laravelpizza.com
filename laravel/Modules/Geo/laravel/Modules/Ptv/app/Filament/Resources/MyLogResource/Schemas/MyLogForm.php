<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MyLogResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MyLogForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'dettagli_log' => Section::make('Dettagli Log')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('id_tbl')
                                ->numeric()
                                ->disabled(),

                            TextInput::make('tbl')
                                ->maxLength(255)
                                ->disabled(),
                        ]),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('obj')
                                ->maxLength(255)
                                ->disabled(),

                            TextInput::make('act')
                                ->maxLength(255)
                                ->disabled(),
                        ]),

                    Textarea::make('note')
                        ->rows(3)
                        ->columnSpanFull(),

                    KeyValue::make('data')
                        ->columnSpanFull(),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('created_by')
                                ->maxLength(255)
                                ->disabled(),

                            TextInput::make('created_at')
                                ->disabled(),
                        ]),
                ]),
        ];
    }
}
