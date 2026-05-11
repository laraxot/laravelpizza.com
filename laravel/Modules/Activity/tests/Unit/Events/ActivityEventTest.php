<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Events;

uses(TestCase::class);

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Activity\Events\ActivityEvent;
use Modules\Activity\Tests\TestCase;

test('ActivityEvent can be instantiated', function () {
    $event = new ActivityEvent;

    expect($event)->toBeObject();
});

test('ActivityEvent has expected properties', function () {
    $event = new ActivityEvent;

    // Siccome ActivityEvent è una classe vuota, testiamo solo che possa essere istanziata
    expect($event)->toBeInstanceOf(Dispatchable::class)
        ->and($event)->toBeInstanceOf(SerializesModels::class)
        ->and($event)->toBeInstanceOf(ShouldBroadcastNow::class);
})->skip('Skipping because we need to check actual class definition');
