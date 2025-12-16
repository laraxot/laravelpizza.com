<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class StatsBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->label('Titolo')->required(),
            Repeater::make('stats')
                ->label('Statistiche')
                ->schema([
                    TextInput::make('number')->label('Numero')->required(),
                    TextInput::make('label')->label('Etichetta')->required(),
                ])
                ->defaultItems(3)
                ->reorderable()
                ->collapsible()
                ->grid(3)
                ->maxItems(6),
        ];
    }
}
