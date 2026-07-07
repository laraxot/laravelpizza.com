<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\Fixtures\HasEventsDummyModel;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('stored events relation is configured as morphMany', function () {
    $model = new HasEventsDummyModel;
    $relation = $model->storedEvents();

    Assert::assertInstanceOf(MorphMany::class, $relation);
    Assert::assertInstanceOf(StoredEvent::class, $relation->getRelated());
});

test('snapshots relation is configured as morphMany', function () {
    $model = new HasEventsDummyModel;
    $relation = $model->snapshots();

    Assert::assertInstanceOf(MorphMany::class, $relation);
    Assert::assertInstanceOf(Snapshot::class, $relation->getRelated());
});
