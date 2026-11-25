<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

use Modules\Rating\Models\BaseModel;
use Modules\Rating\Models\Traits\HasRating;

/**
 * Host concreto del trait {@see HasRating}: senza un consumer reale PHPStan non
 * analizza il corpo del trait (errori di tipo nascosti). Vive nei fixture di test,
 * non in `app/Models`, per non comparire nel discovery dei model applicativi.
 */
final class HasRatingHostStub extends BaseModel
{
    use HasRating;

    protected $table = 'has_rating_host_stub';
}
