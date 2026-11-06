<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Events;

use Modules\Activity\Events\ActivityEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('activity event can be constructed and dispatched', function (): void {
    ActivityEvent::dispatch();
    Assert::assertTrue(class_exists(ActivityEvent::class));
});
