<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

final class SendRecordsSafeEloquentCastStub
{
    public function getStringAttribute(Model $record, string $attribute, string $default = ''): string
    {
        $value = $record->getAttribute($attribute);

        return is_string($value) ? $value : $default;
    }
}
