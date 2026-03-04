<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Modules\Xot\Models\XotBaseModel;

class TestConcreteXotBaseModel extends XotBaseModel
{
    protected $table = 'test_xot_table';
}
