<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\PhaseResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class PhaseForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Form schema types are inferred by Filament v4
        return [
            'informazioni_section' => Section::make('Informazioni')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                    TextInput::make('description')
                        ->label('Descrizione')
                        ->required()
                        ->columnSpan(2),
                    DatePicker::make('start_date')
                        ->label('Data di inizio')
                        ->required(),
                    DatePicker::make('end_date')
                        ->label('Data di fine')
                        ->required(),

                ])->columns(4),
            'liquidazione_section' => Section::make('Liquidazione')
                ->relationship('settlement')
                ->schema([
                    TextInput::make('denominazione'),
                    TextInput::make('importo')
                        ->required()
                        ->numeric()
                        ->suffix('€'),
                ])->columns(2),
        ];
    }
}
