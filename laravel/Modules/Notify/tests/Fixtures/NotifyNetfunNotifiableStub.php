<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Notifiable con routing Netfun per test channel offline.
 */
final class NotifyNetfunNotifiableStub extends Model
{
    protected $guarded = [];

    public function routeNotificationForNetfun(): string
    {
        return '+393331112233';
    }
}
