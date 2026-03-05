<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Performer;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('Performer Model', function (): void {
    test('it can create a performer with valid data', function (): void {
        $performer = Performer::factory()->create([
            'name' => 'John Doe',
            'type' => 'speaker',
            'bio' => 'Experienced PHP developer',
        ]);

        expect($performer->name)->toBe('John Doe')
            ->and($performer->type)->toBe('speaker')
            ->and($performer->bio)->toBe('Experienced PHP developer');
    });

    test('it has fillable attributes', function (): void {
        $performer = new Performer();
        $expected = ['name', 'type', 'bio', 'photo', 'website', 'email', 'company', 'twitter', 'linkedin', 'github', 'meta_data'];

        foreach ($expected as $field) {
            expect(in_array($field, $performer->getFillable()))->toBeTrue();
        }
    });

    test('it casts meta_data to array', function (): void {
        $performer = Performer::factory()->create([
            'meta_data' => ['key' => 'value', 'foo' => 'bar'],
        ]);

        expect($performer->meta_data)->toBeArray()
            ->and($performer->meta_data['key'])->toBe('value');
    });

    test('byType scope filters performers correctly', function (): void {
        $speaker = Performer::factory()->create(['type' => 'speaker']);
        $host = Performer::factory()->create(['type' => 'host']);
        $moderator = Performer::factory()->create(['type' => 'moderator']);

        $speakers = Performer::byType('speaker')->get();

        expect($speakers->contains($speaker))->toBeTrue()
            ->and($speakers->contains($host))->toBeFalse()
            ->and($speakers->contains($moderator))->toBeFalse();
    });

    test('it has many-to-many relationship with events', function (): void {
        $performer = Performer::factory()->create();
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();

        $performer->events()->attach($event1->id, ['role' => 'speaker', 'order' => 1]);
        $performer->events()->attach($event2->id, ['role' => 'speaker', 'order' => 2]);

        $events = $performer->events()->get();

        expect($events->count())->toBe(2)
            ->and($events->contains($event1))->toBeTrue()
            ->and($events->contains($event2))->toBeTrue();
    });

    test('it preserves pivot data in many-to-many relationship', function (): void {
        $performer = Performer::factory()->create();
        $event = Event::factory()->create();

        $performer->events()->attach($event->id, ['role' => 'headliner', 'order' => 1]);

        $attachedEvent = $performer->events()->first();

        expect($attachedEvent->pivot->role)->toBe('headliner')
            ->and($attachedEvent->pivot->order)->toBe(1);
    });

    test('performer can have multiple types of roles in different events', function (): void {
        $performer = Performer::factory()->create(['type' => 'speaker']);
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();

        $performer->events()->attach($event1->id, ['role' => 'keynote', 'order' => 1]);
        $performer->events()->attach($event2->id, ['role' => 'workshop_leader', 'order' => 2]);

        $event1Attachment = $performer->events()->where('event_id', $event1->id)->first();
        $event2Attachment = $performer->events()->where('event_id', $event2->id)->first();

        expect($event1Attachment->pivot->role)->toBe('keynote')
            ->and($event2Attachment->pivot->role)->toBe('workshop_leader');
    });

    test('it stores social media handles', function (): void {
        $performer = Performer::factory()->create([
            'twitter' => '@johndoe',
            'linkedin' => 'john-doe',
            'github' => 'johndoe',
        ]);

        expect($performer->twitter)->toBe('@johndoe')
            ->and($performer->linkedin)->toBe('john-doe')
            ->and($performer->github)->toBe('johndoe');
    });

    test('it stores company and website info', function (): void {
        $performer = Performer::factory()->create([
            'company' => 'Acme Corp',
            'website' => 'https://johndoe.com',
        ]);

        expect($performer->company)->toBe('Acme Corp')
            ->and($performer->website)->toBe('https://johndoe.com');
    });

    test('it can store photo path', function (): void {
        $performer = Performer::factory()->create([
            'photo' => '/photos/speaker.jpg',
        ]);

        expect($performer->photo)->toBe('/photos/speaker.jpg');
    });

    test('it detaches events correctly', function (): void {
        $performer = Performer::factory()->create();
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();

        $performer->events()->attach($event1->id, ['role' => 'speaker', 'order' => 1]);
        $performer->events()->attach($event2->id, ['role' => 'speaker', 'order' => 2]);

        $performer->events()->detach($event1->id);

        $remainingEvents = $performer->events()->get();

        expect($remainingEvents->count())->toBe(1)
            ->and($remainingEvents->contains($event2))->toBeTrue();
    });

    test('byType scope returns empty collection for non-existent type', function (): void {
        Performer::factory()->create(['type' => 'speaker']);
        Performer::factory()->create(['type' => 'host']);

        $organizers = Performer::byType('organizer')->get();

        expect($organizers->count())->toBe(0);
    });
});
