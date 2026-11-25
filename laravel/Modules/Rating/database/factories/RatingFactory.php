<?php

declare(strict_types=1);

namespace Modules\Rating\Database\Factories;

use Modules\Rating\Models\Rating;

/**
 * La forma del dato sta in {@see BaseRatingFactory}, nel modulo che possiede il concetto.
 * Qui si dichiara **solo** il modello: e' quello che porta con se' la connection.
 *
 * @extends BaseRatingFactory<Rating>
 */
class RatingFactory extends BaseRatingFactory
{
    /** @var class-string<Rating> */
    protected $model = Rating::class;
}
