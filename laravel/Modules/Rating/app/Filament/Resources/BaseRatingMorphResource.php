<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources;

use Modules\Rating\Models\RatingMorph;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Lo schema del form vive in `RatingMorphResource\Schemas\RatingMorphForm`:
 * XotBaseResource lo risolve da solo, qui non si dichiara.
 */
abstract class BaseRatingMorphResource extends XotBaseResource
{
    protected static ?string $model = RatingMorph::class;
}
