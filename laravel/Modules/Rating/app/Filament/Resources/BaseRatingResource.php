<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources;

use Modules\Rating\Models\Rating;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Lo schema del form vive in `RatingResource\Schemas\BaseRatingForm`:
 * XotBaseResource lo risolve da solo, qui non si dichiara.
 */
abstract class BaseRatingResource extends XotBaseResource
{
    protected static ?string $model = Rating::class;
}
