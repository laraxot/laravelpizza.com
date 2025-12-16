<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class HeroBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            TextInput::make('subtitle'),
            FileUpload::make('image')->image()->directory('hero-images'),
            TextInput::make('cta_text'),
            TextInput::make('cta_link'),
            ColorPicker::make('background_color')->default('#ffffff'),
            ColorPicker::make('text_color')->default('#000000'),
            ColorPicker::make('cta_color')->default('#4f46e5'),
        ];
    }
}
