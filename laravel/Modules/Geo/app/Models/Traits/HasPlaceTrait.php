<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Models\Place;

/**
 * Modules\Geo\Models\Traits\HasPlaceTrait.
 */
trait HasPlaceTrait
{
    // ----- relationship -----

    public function place(): MorphOne
    {
        return $this->morphOne(Place::class, 'model');
    }

    public function places(): MorphMany
    {
        return $this->morphMany(Place::class, 'model');
    }

    // ----- mutators -----
    // public function getPlaceAttribute(string $value){
    //     return
    // }
}
