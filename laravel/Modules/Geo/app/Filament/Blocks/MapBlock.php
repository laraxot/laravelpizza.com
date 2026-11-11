<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Actions\View\GetViewsSiblingsAndSelfAction;

// use Modules\Blog\Models\Article;

class MapBlock
{
    public static function make(string $name = 'map', string $context = 'form'): Block
    {
        $view = 'geo::components.blocks.map.location-map-table';
        $views = app(GetViewsSiblingsAndSelfAction::class)->execute($view);

        return Block::make($name)
            ->schema([
                /*
                 * Select::make('article_id')
                 * ->label('Article')
                 * ->options(Article::published()->orderBy('title')->pluck('title', 'id'))
                 * ->required(),
                 */
                TextInput::make('text')->label('Link text (optional)'),
                Select::make('_tpl')
                    ->label('layout')
                    ->options($views)
                    ->default('v1')
                    ->required(),
            ])
            ->label('Map')
            ->columns($context === 'form' ? 2 : 1);
    }
}
