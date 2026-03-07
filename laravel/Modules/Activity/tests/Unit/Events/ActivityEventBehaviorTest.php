<?php

declare(strict_types=1);

use Modules\Activity\Events\ActivityEvent;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

test('activity event can be constructed and dispatched', function (): void {
    $event = new ActivityEvent;

    expect($event)->toBeInstanceOf(ActivityEvent::class);

    ActivityEvent::dispatch();
    expect(true)->toBeTrue();
});
