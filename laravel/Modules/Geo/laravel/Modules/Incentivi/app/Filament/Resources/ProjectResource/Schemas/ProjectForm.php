<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Incentivi\Actions\SpareImportoTotaleAction;
use Modules\Incentivi\Enums\AmbitoIncentivo;
use Modules\Incentivi\Enums\ProjectStatus;
use Modules\Incentivi\Models\Employee;
use Modules\Ptv\Filament\Forms\Components\SelectUserSettore;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ProjectForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Form schema types are inferred by Filament v4
        return [
            'informazioni_group' => Group::make()
                ->schema([
                    Section::make('Informazioni')
                        ->schema([
                            Textarea::make('nome')
                                ->string()
                                ->required()
                                ->columnSpan(3)
                                ->placeholder('Sistemazione e restauro delle coperture laterali del Convitto dell\'ISISS Cerletti di Conegliano.'),
                            Select::make('tipo')
                                ->options(AmbitoIncentivo::class)
                                ->default(AmbitoIncentivo::Lavori)
                                ->live()
                                ->required()
                                ->columnSpan(1),
                            Select::make('stato')
                                ->options(ProjectStatus::class)
                                ->required()
                                ->default('compilazione')
                                ->columnSpan(1),
                            SelectUserSettore::make('department_id')
                                ->required()
                                ->columnSpan(1),
                            DatePicker::make('data_aggiudicazione')
                                ->before('data_inizio_esecuzione')
                                ->required(),
                            DatePicker::make('data_inizio_esecuzione')
                                ->after('data_aggiudicazione')
                                ->required(),
                            DatePicker::make('data_fine_esecuzione')
                                ->after('data_inizio_esecuzione')
                                ->required(),
                            TextInput::make('ente_finanziatore')
                                ->string()
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),
                            TextInput::make('determina')
                                ->string()
                                ->required()
                                ->columnSpan(1)
                                ->placeholder('NR. 1489/69755 del 29/11/2021')
                                ->maxLength(255),
                            Textarea::make('oggetto')
                                ->string()
                                ->required()
                                ->rows(3)
                                ->columnSpan(4)
                                ->placeholder('Fondo incentivante. Costituzione gruppo di lavoro per l\'Emergenza Covid - Sistemazione e restauro delle coperture laterali del Convitto - I.S.I.S.S. "G.B Cerletti" di Conegliano.'),
                            // Forms\Components\TextInput::make('rup')
                            //     ->string()
                            //     ->required()
                            //     ->columnSpan(1)
                            //     ->placeholder('RUP')
                            //     ->maxLength(255),
                            Select::make('rup')
                                ->label('RUP')
                                ->options(Employee::all()->pluck('full_name', 'id'))
                                ->getOptionLabelFromRecordUsing(fn (Employee $record) => "{$record->full_name}")
                                ->searchable(['full_name'])
                                ->required()
                                ->columnSpan(1),

                            Select::make('dec')
                                ->label('DEC')
                                ->options(Employee::all()->pluck('full_name', 'id'))
                                ->getOptionLabelFromRecordUsing(fn (Employee $record) => "{$record->full_name}")
                                ->searchable(['full_name'])
                                ->required()
                                ->columnSpan(1),
                        ])
                        ->columns(6),
                ])
                ->columnSpan(['lg' => 2]),

            'ditta_group' => Group::make()
                ->schema([
                    Section::make('Ditta')
                        ->schema([
                            TextInput::make('ditta_nome')
                                ->string()
                                ->required(),
                            TextInput::make('ditta_sede')
                                ->string()
                                ->required(),
                            TextInput::make('ditta_partitaiva')
                                ->string()
                                ->required(),
                            TextInput::make('ditta_oneri_sicurezza')
                                ->string()
                                ->required(),
                            TextInput::make('ditta_trattativa')
                                ->string()
                                ->required(),

                        ])->columns(5),
                ])
                ->columnSpan(['lg' => 2]),

            'importi_group' => Group::make()
                ->schema([
                    Section::make('Importi e percentuali')
                        ->schema([
                            TextInput::make('importo_totale')
                                ->required()
                                ->numeric()
                                ->columnSpan(1)
                                ->suffix('€')
                                ->live(debounce: 2000)
                                ->afterStateUpdated(function (float $state, Get $get, Set $set) {
                                    app(SpareImportoTotaleAction::class)->execute($state, $get, $set);
                                })
                                ->hidden(fn (Get $get): bool => ! $get('tipo')),

                            TextInput::make('percentuale_fondo')
                                ->required()
                                ->columnSpan(1)
                                ->suffix('%')
                                ->disabled()
                                ->dehydrated(),

                            TextInput::make('importo_effettivo_fondo')
                                ->numeric()->inputMode('decimal')
                                ->columnSpan(1)
                                ->suffix('€')
                                ->required()
                                ->disabled()
                                ->dehydrated(),
                            TextInput::make('componente_incentivante')
                                ->numeric()->inputMode('decimal')
                                ->columnSpan(1)
                                ->suffix('€')
                                ->required()
                                ->disabled()
                                ->dehydrated(),
                            TextInput::make('componente_innovazione')
                                ->numeric()->inputMode('decimal')
                                ->columnSpan(1)
                                ->suffix('€')
                                ->required()
                                ->disabled()
                                ->dehydrated(),
                        ])->columns(5),
                ])->columnSpan(['lg' => 2]),
        ];
        // ->columns(4);
    }
}
