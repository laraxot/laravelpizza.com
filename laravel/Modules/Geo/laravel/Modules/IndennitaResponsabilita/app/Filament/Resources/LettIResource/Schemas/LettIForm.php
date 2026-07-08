<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettIResource\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class LettIForm extends XotBaseResourceForm
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
                    'ente_matr_anno_grid' => /** @var Grid $grid */ Grid::make(3)
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
                                ->email(),
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

                    'dali_ali_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'dali' => DatePicker::make('dali')
                                ->native(false),

                            'ali' => DatePicker::make('ali')
                                ->native(false),
                        ]),
                ]),

            'section_indennita' => /** @var Section $section */ Section::make('Indennità')
                ->columnSpanFull()
                ->schema([
                    'indennita_checkboxes_grid_1' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'archivista_informatico' => Checkbox::make('archivista_informatico')
                                ->inline(false),

                            'relazioni_pubblico' => Checkbox::make('relazioni_pubblico')
                                ->inline(false),
                        ]),

                    'indennita_checkboxes_grid_2' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'protezione_civile' => Checkbox::make('protezione_civile')
                                ->inline(false),

                            'formatore_professionale' => Checkbox::make('formatore_professionale')
                                ->inline(false),
                        ]),
                ]),
        ];
    }
}
