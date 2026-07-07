<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Traits;

use Modules\Job\Phpstan\FormatSecondsPhpstanProbe;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('format_seconds_probe_formats_minutes_and_seconds', function (): void {
    $probe = new FormatSecondsPhpstanProbe;

    Assert::assertSame('1 m 30 s', $probe->exposeFormatSeconds(90));
});

test('format_seconds_probe_formats_hours', function (): void {
    $probe = new FormatSecondsPhpstanProbe;

    Assert::assertSame('2 h 0 m 0 s', $probe->exposeFormatSeconds(7200));
});
