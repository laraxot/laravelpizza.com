<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Modules\IndennitaResponsabilita\Filament\Resources\RatingResource\Pages\CreateRating;
use Modules\IndennitaResponsabilita\Filament\Resources\RatingResource\Pages\EditRating;
use Modules\IndennitaResponsabilita\Filament\Resources\RatingResource\Pages\ListRatings;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Rating\Filament\Resources\RatingResource as BaseRatingResource;

class RatingResource extends BaseRatingResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = Rating::class;

    public static function getPages(): array
    {
        return [
            'index' => ListRatings::route('/'),
            'create' => CreateRating::route('/create'),
            'edit' => EditRating::route('/{record}/edit'),
        ];
    }
}
