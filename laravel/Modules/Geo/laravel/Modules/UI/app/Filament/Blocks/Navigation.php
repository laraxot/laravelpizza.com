<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

final class Navigation extends XotBaseBlock
{
    /**
     * @return array<int, Component>
     */
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            Repeater::make('items')
                ->label(__('ui::blocks.navigation.fields.items.label'))
                ->schema([
                    TextInput::make('label')
                        ->label(__('ui::blocks.navigation.fields.text.label'))
                        ->required(),
                    TextInput::make('url')
                        ->label(__('ui::blocks.navigation.fields.url.label'))
                        ->url()
                        ->required(),
                ])
                ->columns(2)
                ->minItems(1),
        ];
    }

    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'items' => Repeater::make('items')
                ->label(self::trans('blocks.navigation.fields.items.label'))
                ->schema([
                    TextInput::make('text')
                        ->label(self::trans('blocks.navigation.fields.text.label')),
                    TextInput::make('url')
                        ->label(self::trans('blocks.navigation.fields.url.label')),
                ]),
        ];
    }
}
