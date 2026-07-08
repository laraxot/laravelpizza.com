<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Modules\Progressioni\Models\Rating;
use Modules\Rating\Filament\Resources\BaseRatingResource;

class RatingResource extends BaseRatingResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = Rating::class;
}
