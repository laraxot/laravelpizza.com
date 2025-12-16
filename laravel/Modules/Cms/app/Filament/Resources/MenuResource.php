<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Modules\Cms\Models\Menu;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MenuResource extends XotBaseResource
{
    protected static ?string $model = Menu::class;

    /**
     * @return array<int, Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required()->maxLength(2048),
            Repeater::make('items')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')->required()->columnSpan(1),
                        TextInput::make('url')
                            ->required()
                            ->columnSpan(1),
                    ]),
                ]),
            Radio::make('target')
                ->options([
                    '_self' => 'Stessa pagina',
                    '_blank' => 'Nuova finestra',
                ])
                ->default('_self'),
            SpatieMediaLibraryFileUpload::make('icon')
                ->collection('cms-icons')
                ->helperText('Carica un\'icona per il menu'),
        ];
    }
}
