<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Test model per LogModelUpdatedActionTest.
 *
 * Classe concreta per testing senza usare classi anonime,
 * garantendo piena conformità PSR-4.
 *
 * @property string|null $name
 */
final class LogModelUpdatedActionTestModel extends Model
{
    /** @var string */
    protected $table = 'test_models';

    /** @var list<string> */
    protected $fillable = ['name'];
}
