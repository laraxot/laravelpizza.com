<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class LogoBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            FileUpload::make('image')->image()->directory('logos'),
            TextInput::make('alt')->required(),
            TextInput::make('text'),
            Select::make('type')
                ->options([
                    'image' => 'Solo Immagine',
                    'text' => 'Solo Testo',
                    'both' => 'Immagine e Testo',
                ])
                ->default('both')
                ->required(),
            TextInput::make('width')->numeric(),
            TextInput::make('height')->numeric(),
            TextInput::make('url')->default('/')->required(),
        ];
    }

    public static function getBlockLabel(): string
    {
        return \trans_string('cms::blocks.logo.label') ?? 'Logo';
    }
}
