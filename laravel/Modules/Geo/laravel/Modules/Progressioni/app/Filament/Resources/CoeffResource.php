<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\CoeffResource\Pages\CreateCoeff;
use Modules\Progressioni\Filament\Resources\CoeffResource\Pages\EditCoeff;
use Modules\Progressioni\Filament\Resources\CoeffResource\Pages\ListCoeffs;
use Modules\Progressioni\Models\Coeff;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class CoeffResource extends XotBaseResource
{
    protected static ?string $model = Coeff::class;

    #[Override]
    /**
     * @return array<int, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'name' => TextInput::make('name')->required(),
            'value' => TextInput::make('value')->required(),
            'anno' => TextInput::make('anno')->numeric(),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCoeffs::route('/'),
            'create' => CreateCoeff::route('/create'),
            'edit' => EditCoeff::route('/{record}/edit'),
        ];
    }
}
