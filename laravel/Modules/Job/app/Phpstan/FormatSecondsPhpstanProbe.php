<?php

declare(strict_types=1);

namespace Modules\Job\Phpstan;

use Modules\Job\Traits\FormatSeconds;

/**
 * PHPStan probe — {@see FormatSeconds} è usato da widget Filament (discovery dinamico).
 */
final class FormatSecondsPhpstanProbe
{
    use FormatSeconds;

    public function exposeFormatSeconds(int $seconds): string
    {
        return $this->formatSeconds($seconds);
    }
}
