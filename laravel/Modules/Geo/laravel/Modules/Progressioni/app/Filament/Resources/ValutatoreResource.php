<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Modules\Progressioni\Filament\Resources\ValutatoreResource\Pages\CreateValutatore;
use Modules\Progressioni\Filament\Resources\ValutatoreResource\Pages\EditValutatore;
use Modules\Progressioni\Filament\Resources\ValutatoreResource\Pages\ListValutatores;
use Modules\Progressioni\Models\Valutatore;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class ValutatoreResource extends XotBaseResource
{
    protected static ?string $model = Valutatore::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'stabi' => TextInput::make('stabi'),
            'repar' => TextInput::make('repar'),
            'nome_stabi' => TextInput::make('nome_stabi'),
            'stabi_txt' => TextInput::make('stabi_txt'),
            'repar_txt' => TextInput::make('repar_txt'),
            'ente' => TextInput::make('ente'),
            'matr' => TextInput::make('matr'),
            'anno' => TextInput::make('anno'),
            'nome_diri' => TextInput::make('nome_diri'),
            'nome_diri_plus' => TextInput::make('nome_diri_plus'),
            'budget' => TextInput::make('budget'),
            'valutatore_id' => TextInput::make('valutatore_id'),
        ];
    }

    /**
     * @return array<class-string<RelationManager>>
     */
    #[Override]
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListValutatores::route('/'),
            'create' => CreateValutatore::route('/create'),
            'edit' => EditValutatore::route('/{record}/edit'),
        ];
    }
}
