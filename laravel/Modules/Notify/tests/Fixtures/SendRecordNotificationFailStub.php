<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

final class SendRecordNotificationFailStub
{
    /**
     * @param  array<int, string>  $channels
     */
    public function execute(Model $record, string $templateSlug, array $channels): void
    {
        if ((bool) $record->getAttribute('should_fail')) {
            throw new \Exception('bulk failure');
        }
    }
}
