<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FakeQueryableModel extends Model
{
    public static ?Model $findResult = null;

    public static function query(): Builder
    {
        $builder = \Mockery::mock(Builder::class);
        $builder->shouldReceive('find')
            ->once()
            ->withAnyArgs()
            ->andReturn(self::$findResult);

        return $builder;
    }
}
