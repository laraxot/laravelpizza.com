<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

/**
 * Filament Builder Block for header navigation items.
 *
 * Manages primary and secondary nav items stored in
 * config/local/{tenant}/database/content/sections/header.json
 * under sections.primary_nav.items with nav_group field.
 */
final class HeaderNavBlock extends XotBaseBlock
{
    /**
     * @return array<Component>
     */
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('label')
                ->translateLabel()
                ->required(),
            TextInput::make('url')
                ->translateLabel()
                ->required(),
            TextInput::make('data_element')
                ->translateLabel(),
            Select::make('nav_group')
                ->translateLabel()
                ->options([
                    'primary' => 'Primaria',
                    'secondary' => 'Secondaria',
                ])
                ->default('primary')
                ->required(),
            Select::make('type')
                ->translateLabel()
                ->options([
                    'link' => 'Link',
                    'dropdown' => 'Dropdown',
                ])
                ->default('link')
                ->required(),
            TextInput::make('order')
                ->translateLabel()
                ->numeric()
                ->default(10),
            Toggle::make('enabled')
                ->translateLabel()
                ->default(true),
            Toggle::make('visible')
                ->translateLabel()
                ->default(true),
            Repeater::make('active_patterns')
                ->translateLabel()
                ->schema([
                    TextInput::make('pattern')
                        ->translateLabel()
                        ->placeholder('it/servizi*')
                        ->required(),
                ])
                ->defaultItems(0)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => is_string($state['pattern'] ?? null) ? $state['pattern'] : null),
            Repeater::make('children')
                ->translateLabel()
                ->schema([
                    TextInput::make('label')->translateLabel()->required(),
                    TextInput::make('url')->translateLabel()->required(),
                    Select::make('type')
                        ->translateLabel()
                        ->options(['link' => 'Link', 'button' => 'Pulsante'])
                        ->default('link'),
                    Toggle::make('enabled')->translateLabel()->default(true),
                ])
                ->defaultItems(0)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => is_string($state['label'] ?? null) ? $state['label'] : null),
        ];
    }

    public static function getBlockLabel(): string
    {
        return trans_string('cms::blocks.header_nav.label');
    }
}
