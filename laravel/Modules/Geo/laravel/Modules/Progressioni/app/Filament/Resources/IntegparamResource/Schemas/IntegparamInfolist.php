<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\IntegparamResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class IntegparamInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'dati_anagrafici' => Section::make('Dati Anagrafici')
                ->schema([
                    TextEntry::make('ente'),
                    TextEntry::make('matr'),
                    TextEntry::make('conome'),
                    TextEntry::make('nome'),
                ])
                ->columns(2),

            'validita_temporale' => Section::make('Validità Temporale')
                ->schema([
                    TextEntry::make('anv2kd')
                        ->date(),
                    TextEntry::make('anv2ka')
                        ->date(),
                    TextEntry::make('anvist'),
                ])
                ->columns(3),

            'parametri' => Section::make('Parametri')
                ->schema([
                    TextEntry::make('anvpar'),
                    TextEntry::make('anvimp')
                        ->numeric(),
                    TextEntry::make('anvqta')
                        ->numeric(),
                    TextEntry::make('anvvoc'),
                    TextEntry::make('anvdes'),
                ])
                ->columns(2),
        ];
    }
}
