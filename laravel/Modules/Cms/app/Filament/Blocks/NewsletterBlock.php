<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

final class NewsletterBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->required()->label(\trans_string('cms::blocks.newsletter.fields.title')),
            Textarea::make('description')->required()->label(\trans_string('cms::blocks.newsletter.fields.description')),
            TextInput::make('button_text')->required()->label(\trans_string('cms::blocks.newsletter.fields.button_text')),
            TextInput::make('placeholder')->required()->label(\trans_string('cms::blocks.newsletter.fields.placeholder')),
            TextInput::make('success_message')->required()->label(\trans_string('cms::blocks.newsletter.fields.success_message')),
            TextInput::make('error_message')->required()->label(\trans_string('cms::blocks.newsletter.fields.error_message')),
        ];
    }

    public static function getBlockLabel(): string
    {
        return \trans_string('cms::blocks.newsletter.label') ?? 'Newsletter';
    }
}
