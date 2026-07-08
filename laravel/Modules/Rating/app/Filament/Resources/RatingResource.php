<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources;

use Modules\Rating\Models\Rating;

class RatingResource extends BaseRatingResource
{
    protected static ?string $model = Rating::class;
}
