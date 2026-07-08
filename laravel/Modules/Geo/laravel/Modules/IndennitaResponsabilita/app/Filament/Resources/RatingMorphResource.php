<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Modules\IndennitaResponsabilita\Models\RatingMorph;
use Modules\Rating\Filament\Resources\RatingMorphResource as BaseRatingMorphResource;

class RatingMorphResource extends BaseRatingMorphResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = RatingMorph::class;
}
