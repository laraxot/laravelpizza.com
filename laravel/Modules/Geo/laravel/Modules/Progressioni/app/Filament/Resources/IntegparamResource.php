<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Modules\Sigma\Models\Integparam;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class IntegparamResource extends XotBaseResource
{
    protected static ?string $model = Integparam::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'dati_anagrafici' => Section::make('Dati Anagrafici')
                ->schema([
                    'ente' => TextInput::make('ente')
                        ->required()
                        ->maxLength(10),

                    'matr' => TextInput::make('matr')
                        ->required()
                        ->maxLength(10),

                    'conome' => TextInput::make('conome')
                        ->required()
                        ->maxLength(50),

                    'nome' => TextInput::make('nome')
                        ->required()
                        ->maxLength(50),
                ])
                ->columns(2),

            'validita_temporale' => Section::make('Validità Temporale')
                ->schema([
                    'anv2kd' => DatePicker::make('anv2kd')
                        ->required(),

                    'anv2ka' => DatePicker::make('anv2ka')
                        ->required()
                        ->after('anv2kd'),

                    'anvist' => Toggle::make('anvist')
                        ->default(0),
                ])
                ->columns(3),

            'parametri' => Section::make('Parametri')
                ->schema([
                    'anvpar' => TextInput::make('anvpar')
                        ->required()
                        ->maxLength(20),

                    'anvimp' => TextInput::make('anvimp')
                        ->numeric()
                        ->required()
                        ->step(0.00001),

                    'anvqta' => TextInput::make('anvqta')
                        ->numeric()
                        ->default(0.00)
                        ->step(0.01),

                    'anvvoc' => TextInput::make('anvvoc')
                        ->required()
                        ->maxLength(10),

                    'anvdes' => Textarea::make('anvdes')
                        ->required()
                        ->maxLength(100)
                        ->rows(3),
                ])
                ->columns(2),
        ];
    }
}
