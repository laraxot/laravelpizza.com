<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mockery\MockInterface;

class FakeQueryableModel extends Model
{
    public static ?Model $findResult = null;

    /**
     * @return Builder<static>
     */
    public static function query(): Builder
    {
        /** @var MockInterface&Builder<static> $builder */
        $builder = \Mockery::mock(Builder::class);
        $builder->allows(['find' => self::$findResult]);

        return $builder;
    }
}
