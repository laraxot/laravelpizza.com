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

    $published = Event::factory()->create(['status' => 'published', 'user_id' => $owner->id]);
    // Proposta in attesa e bozza: le vede solo chi le ha create.
    $pending = Event::factory()->create(['status' => 'pending', 'user_id' => $owner->id]);
    $draft = Event::factory()->create(['status' => 'draft', 'user_id' => $owner->id]);

    // Solo gli eventi di questo test: il database condiviso puo' contenerne altri.
    $ids = [$published->id, $pending->id, $draft->id];
    $visible = static fn (?User $user): array => Event::visibleTo($user)->whereIn('id', $ids)->pluck('id')->sort()->values()->all();

    expect($visible(null))->toBe([$published->id])
        ->and($visible($other))->toBe([$published->id])
        ->and($visible($owner))->toBe(collect($ids)->sort()->values()->all());
});
