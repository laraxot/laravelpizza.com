<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Modules\Xot\Models\BaseMorphPivot;

class TestConcreteMorphPivot extends BaseMorphPivot
{
    protected $table = 'test_morph_pivots';
}
