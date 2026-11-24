<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

final class SendRecordsNotificationRecordDummy extends Model
{
    protected $guarded = [];

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
