<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class CtaBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->label('Titolo')->required(),
            Textarea::make('description')->label('Descrizione')->required(),
            TextInput::make('button_text')->label('Testo Pulsante')->required(),
            TextInput::make('button_link')
                ->label('Link Pulsante')
                ->required()
                ->url(),
        ];
    }
}
