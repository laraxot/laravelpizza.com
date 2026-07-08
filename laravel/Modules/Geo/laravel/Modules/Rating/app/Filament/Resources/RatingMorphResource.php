<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources;

use Modules\Rating\Models\RatingMorph;

class RatingMorphResource extends BaseRatingMorphResource
{
    protected static ?string $model = RatingMorph::class;
}
