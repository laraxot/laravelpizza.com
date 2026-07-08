<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\EsclusiExtraResource\Pages\CreateEsclusiExtra;
use Modules\Progressioni\Filament\Resources\EsclusiExtraResource\Pages\EditEsclusiExtra;
use Modules\Progressioni\Filament\Resources\EsclusiExtraResource\Pages\ListEsclusiExtras;
use Modules\Progressioni\Models\EsclusiExtra;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class EsclusiExtraResource extends XotBaseResource
{
    protected static ?string $model = EsclusiExtra::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'ente' => TextInput::make('ente')->numeric()->required(),
            'matr' => TextInput::make('matr')->numeric()->required(),
            'cognome' => TextInput::make('cognome')->required(),
            'nome' => TextInput::make('nome')->required(),
            'motivo' => Textarea::make('motivo')->rows(3)->required(),
            'anno' => TextInput::make('anno')->numeric()->required(),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListEsclusiExtras::route('/'),
            'create' => CreateEsclusiExtra::route('/create'),
            'edit' => EditEsclusiExtra::route('/{record}/edit'),
        ];
    }
}
