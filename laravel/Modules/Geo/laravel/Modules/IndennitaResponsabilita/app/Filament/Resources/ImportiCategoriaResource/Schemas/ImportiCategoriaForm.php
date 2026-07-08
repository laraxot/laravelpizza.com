<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\ImportiCategoriaResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ImportiCategoriaForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'main_section' => /** @var Section $section */ Section::make('Informazioni Principali')
                ->columnSpanFull()
                ->schema([
                    'ente_anno_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'ente' => TextInput::make('ente')
                                ->required()
                                ->numeric()
                                ->default(1),

                            'anno' => TextInput::make('anno')
                                ->required()
                                ->numeric()
                                ->default((int) date('Y')),
                        ]),

                    'categoria_lista_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'categoria' => TextInput::make('categoria')
                                ->required()
                                ->maxLength(255),

                            'lista_propro' => Textarea::make('lista_propro')
                                ->required()
                                ->rows(3),
                        ]),

                    'min_max_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'min' => TextInput::make('min')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->step(0.01),

                            'max' => TextInput::make('max')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->step(0.01),
                        ]),
                ]),
        ];
    }
}
