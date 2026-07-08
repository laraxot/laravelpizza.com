<?php

declare(strict_types=1);

namespace Modules\Rating\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;

/**
 * Contract for models that have ratings.
 */
interface HasRatingContract
{
    /** @return MorphToMany<Rating, Model, RatingMorph, 'pivot'> */
    public function ratings(): Relation;
}
