<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

final class Navigation extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            Repeater::make('items')
                ->label('Voci di navigazione')
                ->schema([
                    TextInput::make('label')->label('Testo link')->required(),
                    TextInput::make('url')
                        ->label('URL link')
                        ->url()
                        ->required(),
                ])
                ->columns(2)
                ->minItems(1),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            'items' => Repeater::make('items')
                ->label(self::trans('blocks.navigation.fields.items.label'))
                ->schema([
                    TextInput::make('text')->label(self::trans('blocks.navigation.fields.text.label')),
                    TextInput::make('url')->label(self::trans('blocks.navigation.fields.url.label')),
                ]),
        ];
    }
}
