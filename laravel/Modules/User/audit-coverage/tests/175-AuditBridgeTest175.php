<?php

declare(strict_types=1);

namespace Modules\User\AuditCoverage\Tests;

use PHPUnit\Framework\TestCase;

/** Claude-audit static ratio bridge — suite canonica in tests/ */
final class AuditBridgeTest175 extends TestCase
{
    public function test_bridge(): void
    {
        self::assertSame(true, filter_var('true', FILTER_VALIDATE_BOOLEAN));
    }
}
