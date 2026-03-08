<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('scopeVisibleTo filters correctly', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();

    // Published event (visible to all)
    $published = Event::factory()->create(['status' => 'published', 'user_id' => $owner->id]);
    
    // Pending event (visible only to owner)
    $pending = Event::factory()->create(['status' => 'pending', 'user_id' => $owner->id]);
    
    // Draft event (visible to no one via this scope - assuming draft is purely private/dev)
    $draft = Event::factory()->create(['status' => 'draft', 'user_id' => $owner->id]);

    // Guest view
    $guestEvents = Event::visibleTo(null)->get();
    expect($guestEvents)->toHaveCount(1)
        ->and($guestEvents->first()->id)->toBe($published->id);

    // Owner view
    $ownerEvents = Event::visibleTo($owner)->get();
    expect($ownerEvents)->toHaveCount(2)
        ->and($ownerEvents->pluck('id'))->toContain($published->id, $pending->id);

    // Other user view
    $otherEvents = Event::visibleTo($other)->get();
    expect($otherEvents)->toHaveCount(1)
        ->and($otherEvents->first()->id)->toBe($published->id);
});
