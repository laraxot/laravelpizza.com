<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Test model for Activity module tests.
 *
 * @property string|null $name
 */
final class TestModel extends Model
{
    protected $table = 'test_models';

    protected $fillable = ['name'];
}
