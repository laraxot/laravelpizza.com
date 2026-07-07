<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Support;

use Illuminate\Database\Eloquent\Model;

class DummyTestModel extends Model
{
    protected $table = 'dummy_test_models';

    protected $fillable = ['name'];
}
