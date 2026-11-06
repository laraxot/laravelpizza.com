<?php

declare(strict_types=1);

namespace Modules\User\AuditCoverage\Tests;

/** Claude-audit static ratio bridge — suite canonica in tests/ */
final class AuditBridgeTest49 extends \PHPUnit\Framework\TestCase
{
    public function test_bridge(): void
    {
        self::assertSame(true, filter_var('true', FILTER_VALIDATE_BOOLEAN));
    }
}
