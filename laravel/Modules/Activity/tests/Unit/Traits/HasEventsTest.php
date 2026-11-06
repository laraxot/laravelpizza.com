<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Traits;

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\Fixtures\HasEventsDummyModel;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('stored events relation is configured as morphMany', function () {
    $model = new HasEventsDummyModel;
    $relation = $model->storedEvents();

    Assert::assertInstanceOf(StoredEvent::class, $relation->getRelated());
});

test('snapshots relation is configured as morphMany', function () {
    $model = new HasEventsDummyModel;
    $relation = $model->snapshots();

    Assert::assertInstanceOf(Snapshot::class, $relation->getRelated());
});
