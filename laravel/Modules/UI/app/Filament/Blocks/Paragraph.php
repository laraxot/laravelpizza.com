<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
// use Modules\Xot\Actions\View\GetViewsSiblingsAndSelfAction;
use Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction;

final class Paragraph
{
    public static function make(string $name = 'paragraph', string $context = 'form'): Block
    {
        // $view = 'ui::components.blocks.paragraph.v1';
        // $views = app(GetViewsSiblingsAndSelfAction::class)->execute($view);

        $options = app(GetViewBlocksOptionsByTypeAction::class)->execute('paragraph', false);

        return Block::make($name)->schema([
            TextInput::make('title'),
            RichEditor::make('text'),
            Select::make('view')->options($options),
            // RadioImage::make('view')
            //    ->options($options),
        ]);
    }
}
