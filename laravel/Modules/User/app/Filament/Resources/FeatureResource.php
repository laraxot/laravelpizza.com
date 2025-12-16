<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\User\Filament\Resources\FeatureResource\Pages\CreateFeature;
use Modules\User\Filament\Resources\FeatureResource\Pages\EditFeature;
use Modules\User\Filament\Resources\FeatureResource\Pages\ListFeatures;
use Modules\User\Models\Feature;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * @property Feature $record
 */
class FeatureResource extends XotBaseResource
{
    protected static ?string $model = Feature::class;

    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(255),
            'type' => TextInput::make('type')->required()->maxLength(255),
            'active' => Toggle::make('active')->required(),
        ];
    }

    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListFeatures::route('/'),
            'create' => CreateFeature::route('/create'),
            'edit' => EditFeature::route('/{record}/edit'),
        ];
    }
}
