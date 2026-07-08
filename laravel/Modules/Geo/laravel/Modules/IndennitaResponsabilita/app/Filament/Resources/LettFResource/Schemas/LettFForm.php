<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class LettFForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'section_anagrafica' => /** @var Section $section */ Section::make('Anagrafica')
                ->columnSpanFull()
                ->schema([
                    'ente_anno_matr_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'ente' => TextInput::make('ente')
                                ->numeric()
                                ->required()
                                ->default(1),

                            'matr' => TextInput::make('matr')
                                ->required(),

                            'anno' => TextInput::make('anno')
                                ->numeric()
                                ->required()
                                ->minValue(2000)
                                ->maxValue(2100)
                                ->default((int) date('Y')),
                        ]),

                    'cognome_nome_email_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'cognome' => TextInput::make('cognome')
                                ->maxLength(255),

                            'nome' => TextInput::make('nome')
                                ->maxLength(255),

                            'email' => TextInput::make('email')
                                ->email()
                                ->required(),
                        ]),

                    'stabi_repar_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'stabi' => TextInput::make('stabi')
                                ->numeric(),

                            'repar' => TextInput::make('repar')
                                ->numeric(),
                        ]),
                ]),

            'section_periodo' => /** @var Section $section */ Section::make('Periodo')
                ->columnSpanFull()
                ->schema([
                    'dal_al_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'dal' => DatePicker::make('dal')
                                ->required()
                                ->native(false),

                            'al' => DatePicker::make('al')
                                ->required()
                                ->native(false),
                        ]),

                    'dalf_alf_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'dalf' => DatePicker::make('dalf')
                                ->native(false),

                            'alf' => DatePicker::make('alf')
                                ->native(false),
                        ]),
                ]),

            'section_valutazione' => /** @var Section $section */ Section::make('Valutazione')
                ->columnSpanFull()
                ->schema([
                    'posizione_lavoro' => Textarea::make('posizione_lavoro')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),

                    'valutazione_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'complessita' => TextInput::make('complessita')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->maxValue(40)
                                ->step(1)
                                ->default(0),

                            'coordinamento' => TextInput::make('coordinamento')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->maxValue(30)
                                ->step(1)
                                ->default(0),

                            'responsabilita' => TextInput::make('responsabilita')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->maxValue(30)
                                ->step(1)
                                ->default(0),
                        ]),
                ]),

            'section_importi' => /** @var Section $section */ Section::make('Importi')
                ->columnSpanFull()
                ->schema([
                    'importi_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'tot' => TextInput::make('tot')
                                ->numeric()
                                ->disabled(),

                            'valore_economico_calcolato' => TextInput::make('valore_economico_calcolato')
                                ->numeric()
                                ->disabled()
                                ->step(0.01),

                            'valore_economico_attribuito' => TextInput::make('valore_economico_attribuito')
                                ->numeric()
                                ->disabled()
                                ->step(0.01),
                        ]),
                ]),

            'section_classificazione' => /** @var Section $section */ Section::make('Classificazione')
                ->columnSpanFull()
                ->schema([
                    'classificazione_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'propro' => TextInput::make('propro')
                                ->numeric(),

                            'posfun' => TextInput::make('posfun')
                                ->numeric(),

                            'categoria_eco' => TextInput::make('categoria_eco')
                                ->maxLength(255),
                        ]),
                ]),
        ];
    }
}
