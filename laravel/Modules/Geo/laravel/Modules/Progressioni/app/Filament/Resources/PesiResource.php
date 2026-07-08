<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\PesiResource\Pages\CreatePesi;
use Modules\Progressioni\Filament\Resources\PesiResource\Pages\EditPesi;
use Modules\Progressioni\Filament\Resources\PesiResource\Pages\ListPesis;
use Modules\Progressioni\Models\Pesi;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class PesiResource extends XotBaseResource
{
    protected static ?string $model = Pesi::class;

    #[Override]
    /**
     * @return array
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'lista_propro' => TextInput::make('lista_propro')->required(),
            'descr' => TextInput::make('descr')->required(),
            'peso_esperienza_acquisita' => TextInput::make('peso_esperienza_acquisita')->numeric()->required(),
            'peso_risultati_ottenuti' => TextInput::make('peso_risultati_ottenuti')->numeric()->required(),
            'peso_arricchimento_professionale' => TextInput::make('peso_arricchimento_professionale')->numeric()->required(),
            'peso_impegno' => TextInput::make('peso_impegno')->numeric()->required(),
            'peso_qualita_prestazione' => TextInput::make('peso_qualita_prestazione')->numeric()->required(),
            'anno' => TextInput::make('anno')->numeric()->required(),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPesis::route('/'),
            'create' => CreatePesi::route('/create'),
            'edit' => EditPesi::route('/{record}/edit'),
        ];
    }
}
