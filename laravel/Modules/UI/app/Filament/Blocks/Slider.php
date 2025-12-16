<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction;

final class Slider
{
    public static function make(string $name = 'slider', string $context = 'form'): Block
    {
        // $view = 'ui::components.blocks.slider.v1';
        // $views = app(GetViewsSiblingsAndSelfAction::class)->execute($view);
        // dddx('a');
        $options = app(GetViewBlocksOptionsByTypeAction::class)->execute('slider', true);

        // dddx($options);
        return Block::make($name)
            ->schema([
                TextInput::make('method')->hint('Inserisci il nome del metodo da richiamare nel tema')->required(),
                // Select::make('_tpl')
                //     ->label('layout')
                //     ->options($options),
                // ->afterStateHydrated(static fn ($state, $set) => $state || $set('level', 'h2')),

                Radio::make('view')->options($options),
            ])
            ->columns(1);
    }

    public static function getFormSchema(): array
    {
        return [
            'layout' => Select::make('layout')
                ->options([
                    'default' => 'Default',
                    'fullscreen' => 'Fullscreen',
                    'minimal' => 'Minimal',
                ])
                ->required(),
        ];
    }
}
