<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Socialite;

use Psr\Log\AbstractLogger;

final class NotConfiguredRecordingLogger extends AbstractLogger
{
    /** @var list<array{string, string}> */
    private array $records = [];

    public function log(mixed $level, string|\Stringable $message, array $context = []): void
    {
        $this->records[] = [is_string($level) ? $level : '', (string) $message];
    }

    /** @return list<string> */
    public function levelsOf(string $needle): array
    {
        $levels = [];
        foreach ($this->records as [$level, $message]) {
            if (str_contains($message, $needle)) {
                $levels[] = $level;
            }
        }

        return $levels;
    }
}
