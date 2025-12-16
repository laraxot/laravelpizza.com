<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

final class SocialBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->required()
                ->label(\trans_string('cms::blocks.social.fields.title')),
            Repeater::make('social_links')
                ->label(\trans_string('cms::blocks.social.fields.social_links'))
                ->schema([
                    Select::make('platform')
                        ->required()
                        ->label(\trans_string('cms::blocks.social.fields.platform'))
                        ->options([
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'instagram' => 'Instagram',
                            'linkedin' => 'LinkedIn',
                            'youtube' => 'YouTube',
                        ]),
                    TextInput::make('url')
                        ->required()
                        ->url()
                        ->label(\trans_string('cms::blocks.social.fields.url')),
                ])
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => isset($state['platform']) && is_string($state['platform']) ? $state['platform'] : null)
                ->defaultItems(1),
        ];
    }

    public static function getBlockLabel(): string
    {
        return \trans_string('cms::blocks.social.label') ?? 'Social';
    }
}
