<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('snapshot uses the default connection in testing', function (): void {
    $model = new Snapshot;

    Assert::assertSame(config('database.default'), $model->getConnectionName());
});
