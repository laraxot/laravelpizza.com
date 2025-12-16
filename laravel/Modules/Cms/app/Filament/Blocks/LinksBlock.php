<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

final class LinksBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Repeater::make('links')
                ->schema([
                    TextInput::make('label')->required(),
                    TextInput::make('url')->required()->url(),
                    TextInput::make('icon'),
                ])
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => isset($state['label']) && is_string($state['label']) ? $state['label'] : null),
        ];
    }

    public static function getBlockLabel(): string
    {
        return \trans_string('cms::filament.blocks.footer.links.label') ?? 'Links';
    }
}
