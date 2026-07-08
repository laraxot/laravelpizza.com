<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\Traits\HasExtraTrait;

class TestModelHasExtra extends Model
{
    use HasExtraTrait;

    protected $table = 'test_models';

    protected $fillable = ['id', 'name'];

    public function getExtraClass(): string
    {
        return ExtraModelTest::class;
    }
}
