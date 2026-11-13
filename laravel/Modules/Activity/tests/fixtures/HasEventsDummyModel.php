<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Traits\HasEvents;

/**
 * Modello concreto per testare il trait HasEvents.
 */
final class HasEventsDummyModel extends Model
{
    use HasEvents;

    /** @var string */
    protected $table = 'activity_dummy_models';

    public $timestamps = false;
}
