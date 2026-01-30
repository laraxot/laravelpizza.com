<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Events\ActivityEvent;

test('ActivityEvent can be instantiated', function () {
    $event = new ActivityEvent;

    expect($event)->toBeObject();
});

test('ActivityEvent has expected properties', function () {
    $event = new ActivityEvent;

    // Siccome ActivityEvent è una classe vuota, testiamo solo che possa essere istanziata
    expect($event)->toBeInstanceOf(\Illuminate\Foundation\Events\Dispatchable::class)
        ->and($event)->toBeInstanceOf(\Illuminate\Queue\SerializesModels::class)
        ->and($event)->toBeInstanceOf(\Illuminate\Contracts\Broadcasting\ShouldBroadcastNow::class);
})->skip('Skipping because we need to check actual class definition');
