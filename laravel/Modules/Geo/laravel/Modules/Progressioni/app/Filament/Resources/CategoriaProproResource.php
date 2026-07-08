<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\CategoriaProproResource\Pages\CreateCategoriaPropro;
use Modules\Progressioni\Filament\Resources\CategoriaProproResource\Pages\EditCategoriaPropro;
use Modules\Progressioni\Filament\Resources\CategoriaProproResource\Pages\ListCategoriaPropros;
use Modules\Progressioni\Models\CategoriaPropro;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class CategoriaProproResource extends XotBaseResource
{
    protected static ?string $model = CategoriaPropro::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'categoria' => TextInput::make('categoria')
                ->maxLength(255),
            'lista_propro' => TextInput::make('lista_propro')
                ->maxLength(255),
            'lista_propro_sup' => TextInput::make('lista_propro_sup')
                ->maxLength(255),
            'posti' => TextInput::make('posti')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCategoriaPropros::route('/'),
            'create' => CreateCategoriaPropro::route('/create'),
            'edit' => EditCategoriaPropro::route('/{record}/edit'),
        ];
    }
}
