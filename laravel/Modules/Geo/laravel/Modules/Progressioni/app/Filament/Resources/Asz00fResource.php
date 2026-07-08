<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Pages\CreateAsz00f;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Pages\EditAsz00f;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Pages\ListAsz00fs;
use Modules\Progressioni\Filament\Resources\Asz00fResource\Widgets\Asz00fStatsOverview;
use Modules\Progressioni\Models\Asz00f;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class Asz00fResource extends XotBaseResource
{
    protected static ?string $model = Asz00f::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'ente' => TextInput::make('ente')->numeric(),
            'cont' => TextInput::make('cont')->numeric(),
            'matr' => TextInput::make('matr')->numeric(),
            'asztip' => TextInput::make('asztip')->numeric(),
            'aszcod' => TextInput::make('aszcod')->numeric(),
            'aszdal' => TextInput::make('aszdal')->numeric(),
            'aszal' => TextInput::make('aszal')->numeric(),
            'aszini' => TextInput::make('aszini')->maxLength(50),
            'aszfin' => TextInput::make('aszfin')->maxLength(50),
            'aszumi' => TextInput::make('aszumi')->maxLength(2),
            'aszpes' => TextInput::make('aszpes')->maxLength(50),
            'aszdur' => TextInput::make('aszdur')->maxLength(50),
            'aszann' => TextInput::make('aszann')->maxLength(10),
            'asz2kd' => TextInput::make('asz2kd')->numeric(),
            'asz2ka' => TextInput::make('asz2ka')->numeric(),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListAsz00fs::route('/'),
            'create' => CreateAsz00f::route('/create'),
            'edit' => EditAsz00f::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<class-string>
     */
    public static function getWidgets(): array
    {
        return [
            Asz00fStatsOverview::class,
        ];
    }
}
