<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Modules\Activity\Models\BaseModel;

/**
 * Test model per BaseModelTest.
 *
 * Classe concreta per testing senza usare classi anonime,
 * garantendo piena conformità PSR-4.
 *
 * @property string|null $name
 */
final class TestBaseModel extends BaseModel
{
    /** @var string */
    protected $table = 'test_models';

    /** @var list<string> */
    protected $fillable = ['name'];
}
