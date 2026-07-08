<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources;

use Modules\Rating\Models\RatingMorph;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class BaseRatingMorphResource extends XotBaseResource
{
    protected static ?string $model = RatingMorph::class;

    public static function getFormSchema(): array
    {
        return [
            // Campi del form
        ];
    }
}
