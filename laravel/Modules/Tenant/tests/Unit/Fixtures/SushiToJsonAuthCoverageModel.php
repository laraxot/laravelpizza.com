<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

/**
 * Named subclass that returns a fixed auth id for audit-field coverage.
 */
final class SushiToJsonAuthCoverageModel extends SushiToJsonCoverageModel
{
    protected function authId(): int
    {
        return 42;
    }
}
