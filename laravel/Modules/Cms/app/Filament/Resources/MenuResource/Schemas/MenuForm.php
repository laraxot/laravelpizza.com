<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Grid;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MenuForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
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
