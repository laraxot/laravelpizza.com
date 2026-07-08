<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

final class SendRecordsSafeEloquentCastEmptyStub
{
    public function getStringAttribute(Model $record, string $attribute, string $default = ''): string
    {
        return '';
    }
}
