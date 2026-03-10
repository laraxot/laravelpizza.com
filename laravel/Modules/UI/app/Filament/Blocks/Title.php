<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction;

class Title // extends XotBaseBlock
{public static function make(string $name = 'title', string $context = 'form'): Block
{
    // $view = 'ui::components.blocks.title.v1';
    // $views = app(GetViewsSiblingsAndSelfAction::class)->execute($view);

    $options = app(GetViewBlocksOptionsByTypeAction::class)->execute('title', false);

    return Block::make($name)
        ->schema([
            TextInput::make('text')->required(),
            Select::make('level')
                ->options([
                    'h2' => 'h2',
                    'h3' => 'h3',
                    'h4' => 'h4',
                ])
                ->afterStateHydrated(static function (TextInput $component, mixed $state): void {
                    if (null === $state || '' === $state) {
                        $component->state('h2');
                    }
                }),
            Select::make('view')->options(is_array($options) ? $options : []),
        ])
        ->columns('form' === $context ? 2 : 1);
}
}
