<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class FeatureSectionsBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->label('Titolo')->required(),
            Repeater::make('sections')
                ->label('Sezioni')
                ->schema([
                    TextInput::make('title')->label('Titolo')->required(),
                    TextInput::make('description')->label('Descrizione')->required(),
                    Select::make('icon')
                        ->label('Icona')
                        ->options([
                            'heroicon-o-shield-check' => 'Scudo',
                            'heroicon-o-heart' => 'Cuore',
                            'heroicon-o-hand-raised' => 'Mano',
                            'heroicon-o-star' => 'Stella',
                            'heroicon-o-lightbulb' => 'Lampadina',
                            'heroicon-o-academic-cap' => 'Laurea',
                            'heroicon-o-clock' => 'Orologio',
                            'heroicon-o-chart-bar' => 'Grafico',
                            'heroicon-o-cog' => 'Ingranaggio',
                            'heroicon-o-users' => 'Utenti',
                        ])
                        ->required(),
                ])
                ->defaultItems(3)
                ->reorderable()
                ->collapsible()
                ->grid(3),
        ];
    }
}
