<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use RuntimeException;

/**
 * Named subclass whose query() throws — covers maxIdFromDatabase catch.
 */
final class SushiToJsonThrowingQueryModel extends SushiToJsonCoverageModel
{
    public static function query(): never
    {
        throw new RuntimeException('forced query failure for coverage');
    }
}
