<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

final class ListLogActivitiesActionTestRecord extends Model
{
    /** @var string */
    protected $table = 'test_records';

    public $timestamps = false;

    protected $keyType = 'string';

    public $incrementing = false;

    /** @var array<string, string> */
    protected $attributes = [
        'id' => 'test-record-key',
    ];
}
