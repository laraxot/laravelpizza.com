<?php

declare(strict_types=1);

namespace Modules\Rating\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Rating\Models\Rating;

/** Contract for models that expose the shared ratings relation. */
interface HasRatingContract
{
    /**
     * @return MorphToMany<Rating, Model, MorphPivot, 'pivot'>
     *
     * @phpstan-return MorphToMany<Rating, Model, MorphPivot, 'pivot'>
     */
    public function ratings(): MorphToMany;
}
