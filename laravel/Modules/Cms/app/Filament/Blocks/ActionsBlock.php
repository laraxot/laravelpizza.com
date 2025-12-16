<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class ActionsBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            Repeater::make('items')
                ->schema([
                    TextInput::make('label')->required(),
                    TextInput::make('url')->required(),
                    Select::make('style')
                        ->options([
                            'primary' => 'Primario',
                            'secondary' => 'Secondario',
                            'outline' => 'Outline',
                            'link' => 'Link',
                        ])
                        ->required(),
                    Select::make('icon')->options([
                        'search' => 'Ricerca',
                        'user' => 'Utente',
                        'cart' => 'Carrello',
                        'menu' => 'Menu',
                        'settings' => 'Impostazioni',
                        'notification' => 'Notifiche',
                        'language' => 'Lingua',
                    ]),
                    Select::make('size')
                        ->options([
                            'xs' => 'Extra Small',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                        ])
                        ->default('md'),
                ])
                ->collapsible(),
            Select::make('alignment')
                ->options([
                    'start' => 'Sinistra',
                    'center' => 'Centro',
                    'end' => 'Destra',
                ])
                ->default('end'),
            Select::make('gap')
                ->options([
                    'xs' => 'Extra Small',
                    'sm' => 'Small',
                    'md' => 'Medium',
                    'lg' => 'Large',
                ])
                ->default('md'),
        ];
    }
}
