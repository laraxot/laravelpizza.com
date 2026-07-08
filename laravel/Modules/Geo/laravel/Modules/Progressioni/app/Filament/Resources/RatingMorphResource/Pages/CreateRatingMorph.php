<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\RatingMorphResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Progressioni\Filament\Resources\RatingMorphResource;

class CreateRatingMorph extends CreateRecord
{
    protected static string $resource = RatingMorphResource::class;
}
