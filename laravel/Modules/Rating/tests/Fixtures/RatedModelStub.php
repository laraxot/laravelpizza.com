<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Host concreto per ownership via attributi Eloquent (niente classe anonima).
 */
final class RatedModelStub extends Model
{
    protected $table = 'rated_stub';
}
