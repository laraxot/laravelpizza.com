<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Modules\Progressioni\Models\RatingMorph;
use Modules\Rating\Filament\Resources\BaseRatingMorphResource;

class RatingMorphResource extends BaseRatingMorphResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = RatingMorph::class;
}
