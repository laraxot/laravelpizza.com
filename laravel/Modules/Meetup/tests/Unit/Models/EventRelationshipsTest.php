<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

describe('Event Relationships', function (): void {
    test('event belongs to owner user', function (): void {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $owner = $event->owner;

        expect($owner)->toBeInstanceOf(User::class)
            ->and($owner->id)->toBe($user->id);
    });

    test('event belongs to creator user', function (): void {
        $event = Event::factory()->create();
        $relation = $event->creator();

        expect($relation->getForeignKeyName())->toBe('created_by')
            ->and($relation->getRelated())->toBeInstanceOf(User::class);
    });

    test('event belongs to updater user', function (): void {
        $event = Event::factory()->create();
        $relation = $event->updater();

        expect($relation->getForeignKeyName())->toBe('updated_by')
            ->and($relation->getRelated())->toBeInstanceOf(User::class);
    });

    test('event belongs to organizer user', function (): void {
        $user = User::factory()->create();
        $event = Event::factory()->create(['organizer_id' => $user->id]);

        $organizer = $event->organizer;

        expect($organizer)->toBeInstanceOf(User::class)
            ->and($organizer->id)->toBe($user->id);
    });

    test('event owner can be null', function (): void {
        $event = Event::factory()->create(['user_id' => null]);

        expect($event->owner)->toBeNull();
    });

    test('event creator can be null', function (): void {
        $event = Event::factory()->create(['created_by' => null]);

        expect($event->creator)->toBeNull();
    });

    test('event updater can be null', function (): void {
        $event = Event::factory()->create(['updated_by' => null]);

        expect($event->updater)->toBeNull();
    });

    test('event organizer can be null', function (): void {
        $event = Event::factory()->create(['organizer_id' => null]);

        expect($event->organizer)->toBeNull();
    });

    test('event can load creator relationship eagerly', function (): void {
        $created = Event::factory()->create();

        $event = Event::with('creator')->whereKey($created->id)->first();

        expect($event)->not->toBeNull()
            ->and($event->relationLoaded('creator'))->toBeTrue();
    });

    test('event can load updater relationship eagerly', function (): void {
        $created = Event::factory()->create();
        $event = Event::with('updater')->whereKey($created->id)->first();

        expect($event)->not->toBeNull()
            ->and($event->relationLoaded('updater'))->toBeTrue();
    });

    test('event can load organizer relationship eagerly', function (): void {
        $user = User::factory()->create();
        $created = Event::factory()->create(['organizer_id' => $user->id]);

        $event = Event::with('organizer')->whereKey($created->id)->first();

        expect($event->organizer)->not->toBeNull()
            ->and($event->organizer->id)->toBe($user->id);
    });
});
