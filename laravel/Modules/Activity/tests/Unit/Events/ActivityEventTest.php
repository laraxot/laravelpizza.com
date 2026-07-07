<?php

declare(strict_types=1);

use Modules\Activity\Events\ActivityEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('ActivityEvent uses expected Laravel event traits', function () {
    $event = new ActivityEvent;

    $traitNames = (new ReflectionClass($event))->getTraitNames();
    Assert::assertContains('Illuminate\Broadcasting\InteractsWithSockets', $traitNames);
    Assert::assertContains('Illuminate\Foundation\Events\Dispatchable', $traitNames);
    Assert::assertContains('Illuminate\Queue\SerializesModels', $traitNames);
});
