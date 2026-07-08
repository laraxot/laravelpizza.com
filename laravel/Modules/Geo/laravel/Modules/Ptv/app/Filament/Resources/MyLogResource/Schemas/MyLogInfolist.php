<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MyLogResource\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MyLogInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'info_section' => Section::make('Informazioni Generali')
                ->schema([
                    'info_grid' => Grid::make(2)
                        ->schema([
                            'id' => TextEntry::make('id'),

                            'tbl' => TextEntry::make('tbl'),
                        ]),

                    'details_grid' => Grid::make(2)
                        ->schema([
                            'id_tbl' => TextEntry::make('id_tbl'),

                            'act' => TextEntry::make('act'),
                        ]),
                ]),

            'details_section' => Section::make('Dettagli')
                ->schema([
                    'obj' => TextEntry::make('obj')
                        ->columnSpanFull(),

                    'note' => TextEntry::make('note')
                        ->columnSpanFull(),
                ]),

            'data_section' => Section::make('Dati Aggiuntivi')
                ->schema([
                    'data' => KeyValueEntry::make('data')
                        ->columnSpanFull(),
                ]),

            'system_section' => Section::make('Informazioni di Sistema')
                ->schema([
                    'system_grid' => Grid::make(2)
                        ->schema([
                            'created_at' => TextEntry::make('created_at')
                                ->dateTime(),

                            'created_by' => TextEntry::make('created_by'),
                        ]),
                ]),
        ];
    }
}
