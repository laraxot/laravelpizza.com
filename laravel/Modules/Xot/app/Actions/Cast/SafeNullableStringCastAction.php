<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Cast;

final class SafeNullableStringCastAction
{
    public function execute(mixed $value): ?string
    {
        $stringValue = SafeStringCastAction::cast($value);

        return '' !== $stringValue ? $stringValue : null;
    }

    public static function cast(mixed $value): ?string
    {
        return app(self::class)->execute($value);
    }
}
