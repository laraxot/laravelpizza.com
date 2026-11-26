<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

use Modules\Rating\Models\BaseModel;
use Modules\Rating\Models\Traits\HasRating;

/**
 * Host concreto del trait {@see HasRating} per i test.
 *
 * Non conta come consumer per PHPStan: `phpstan.neon` esclude `./*\/tests/*`, quindi un
 * `use HasRating` qui non evita `trait.unused`. L'àncora per l'analisi statica e'
 * `Modules\Rating\Models\AbstractHasRatingHost` in `app/`. Oggi nessun test usa questo
 * stub (verificato in tutti i cloni): candidato alla rimozione.
 *
 * @see Modules/Rating/docs/wiki/concepts/phpstan-compliance.md
 */
final class HasRatingHostStub extends BaseModel
{
    use HasRating;

    protected $table = 'has_rating_host_stub';
}
