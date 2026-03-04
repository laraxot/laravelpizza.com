<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class DemoModel extends Model
{
    protected $table = 'demo_models';

    public $timestamps = false;
}
