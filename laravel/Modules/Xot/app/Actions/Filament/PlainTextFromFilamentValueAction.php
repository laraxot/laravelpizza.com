<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Spatie\QueueableAction\QueueableAction;

/**
 * Plain text for Filament grid labels — Htmlable, enum HasLabel, scalar.
 */
class PlainTextFromFilamentValueAction
{
    use QueueableAction;

    public function execute(mixed $value, mixed $fallback = ''): string
    {
        if ($value instanceof Htmlable) {
            return strip_tags($value->toHtml());
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_scalar($value) || $value instanceof \Stringable) {
            return (string) $value;
        }

        if ($value instanceof HasLabel) {
            return $this->execute($value->getLabel(), $fallback);
        }

        if (is_scalar($fallback) || $fallback instanceof \Stringable) {
            return (string) $fallback;
        }

        return '';
    }

    public static function cast(mixed $value, mixed $fallback = ''): string
    {
        return app(self::class)->execute($value, $fallback);
    }
}
