<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Stubs;

use Illuminate\Database\Eloquent\Relations\Pivot;

final class XotCovPivot extends Pivot
{
    protected $table = 'cache_cache';

    public $incrementing = true;

    protected $fillable = ['cache_id', 'related_id', 'extra'];
}
