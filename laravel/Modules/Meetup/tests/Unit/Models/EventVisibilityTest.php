<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('publiclyVisible scope returns only published events', function () {
    $published = Event::factory()->create(['status' => 'published']);
    $pending = Event::factory()->create(['status' => 'pending']);
    $draft = Event::factory()->create(['status' => 'draft']);

    $visible = Event::query()->publiclyVisible()->pluck('id');

    expect($visible)->toContain($published->id)
        ->and($visible)->not->toContain($pending->id)
        ->and($visible)->not->toContain($draft->id);
});

test('visibleToUser scope includes owner pending events and published events', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();

    $published = Event::factory()->create(['status' => 'published']);
    $ownerPending = Event::factory()->create(['status' => 'pending', 'user_id' => $owner->id]);
    $otherPending = Event::factory()->create(['status' => 'pending', 'user_id' => $other->id]);

    $visible = Event::query()->visibleToUser((string) $owner->id)->pluck('id');

    expect($visible)->toContain($published->id)
        ->and($visible)->toContain($ownerPending->id)
        ->and($visible)->not->toContain($otherPending->id);
});

test('canBeViewedBy enforces pending owner-only visibility', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();

    $published = Event::factory()->create(['status' => 'published']);
    $pending = Event::factory()->create(['status' => 'pending', 'user_id' => $owner->id]);

    expect($published->canBeViewedBy(null))->toBeTrue()
        ->and($pending->canBeViewedBy((string) $owner->id))->toBeTrue()
        ->and($pending->canBeViewedBy((string) $other->id))->toBeFalse()
        ->and($pending->canBeViewedBy(null))->toBeFalse();
});
