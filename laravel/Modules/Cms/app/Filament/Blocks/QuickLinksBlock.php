<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

final class QuickLinksBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->label(\trans_string('cms::blocks.quick_links.fields.title'))->required(),
            Repeater::make('links')
                ->label(\trans_string('cms::blocks.quick_links.fields.links'))
                ->schema([
                    TextInput::make('label')->label(\trans_string('cms::blocks.quick_links.fields.label'))->required(),
                    TextInput::make('url')->label(\trans_string('cms::blocks.quick_links.fields.url'))->required(),
                    TextInput::make('target')
                        ->label(\trans_string('cms::blocks.quick_links.fields.target'))
                        ->default('_self')
                        ->helperText('Usa "_blank" per aprire in una nuova finestra, "_self" per la stessa finestra'),
                ])
                ->collapsible()
                ->defaultItems(0)
                ->itemLabel(fn (array $state): ?string => isset($state['label']) && is_string($state['label']) ? $state['label'] : null),
        ];
    }

    public static function getBlockLabel(): string
    {
        return \trans_string('cms::blocks.quick_links.label') ?? 'Quick Links';
    }
}
