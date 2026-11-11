<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Traits;

use Modules\Job\Tests\TestCase;
use Modules\Job\Traits\FormatSeconds;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('format_seconds_formats_minutes_and_seconds', function (): void {
    $formatter = new class
    {
        use FormatSeconds;
    };

    Assert::assertSame('1 m 30 s', $formatter->formatSeconds(90));
});

test('format_seconds_formats_hours', function (): void {
    $formatter = new class
    {
        use FormatSeconds;
    };

    Assert::assertSame('2 h 0 m 0 s', $formatter->formatSeconds(7200));
});
