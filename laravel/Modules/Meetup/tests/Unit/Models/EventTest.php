<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

test('it can create an event and has correct defaults', function () {
    $event = Event::factory()->create([
        'title' => 'Test Event '.uniqid(),
        'slug' => null,
    ]);

    expect($event->title)->toContain('Test Event')
        ->and($event->slug)->not->toBeEmpty()
        ->and($event->attendees_count)->toBe(0)
        ->and($event->max_attendees)->toBeGreaterThan(0);
});

test('event has expected fillable fields', function () {
    $event = new Event();
    $expected = ['title', 'description', 'start_date', 'end_date', 'location', 'slug'];
    
    foreach ($expected as $field) {
        expect(in_array($field, $event->getFillable()))->toBeTrue();
    }
});

test('event owner relation loads correctly', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create(['user_id' => $user->id]);

    expect($event->owner)->toBeInstanceOf(User::class)
        ->and($event->owner->id)->toBe($user->id);
});

test('upcoming scope filters events correctly', function () {
    $upcomingEvent = Event::factory()->create([
        'start_date' => Carbon::now()->addDays(1),
    ]);
    $pastEvent = Event::factory()->past()->create();

    $upcomingEvents = Event::upcoming()->get();

    expect($upcomingEvents->contains($upcomingEvent))->toBeTrue()
        ->and($upcomingEvents->contains($pastEvent))->toBeFalse();
});

test('past scope filters events correctly', function () {
    $upcomingEvent = Event::factory()->create([
        'start_date' => Carbon::now()->addDays(1),
    ]);
    $pastEvent = Event::factory()->past()->create();

    $pastEvents = Event::past()->get();

    expect($pastEvents->contains($pastEvent))->toBeTrue()
        ->and($pastEvents->contains($upcomingEvent))->toBeFalse();
});

test('bySlug scope filters events correctly', function () {
    $uniqueSlug = 'unique-slug-'.uniqid();
    $event = Event::factory()->create(['slug' => $uniqueSlug]);
    Event::factory()->create(['slug' => 'other-slug-'.uniqid()]);

    $result = Event::bySlug($uniqueSlug)->first();

    expect($result->id)->toBe($event->id);
});

test('dateRange scope filters events correctly', function () {
    $startDate = Carbon::now()->addDays(2);
    $endDate = Carbon::now()->addDays(5);

    $insideEvent = Event::factory()->create(['start_date' => Carbon::now()->addDays(3)]);
    $outsideEvent = Event::factory()->create(['start_date' => Carbon::now()->addDays(6)]);

    $results = Event::dateRange($startDate, $endDate)->get();

    expect($results->contains($insideEvent))->toBeTrue()
        ->and($results->contains($outsideEvent))->toBeFalse();
});

test('getBySlug static method returns correct event', function () {
    $slug = 'static-slug-'.uniqid();
    $event = Event::factory()->create(['slug' => $slug]);
    
    $result = Event::getBySlug($slug);

    expect($result->id)->toBe($event->id);
});

test('toBlockArray returns correct data structure', function () {
    $event = Event::factory()->create([
        'title' => 'Block Test',
        'start_date' => Carbon::parse('2026-06-01 10:00:00'),
        'end_date' => Carbon::parse('2026-06-01 14:00:00'),
    ]);

    $block = $event->toBlockArray();

    expect($block['title'])->toBe('Block Test')
        ->and($block['slug'])->toBe($event->slug)
        ->and($block['date'])->toContain('June')
        ->and($block['time'])->toContain('10:00 AM')
        ->and($block['url'])->toContain('events');
});

test('toSchemaOrg returns valid structured data', function () {
    $event = Event::factory()->create([
        'title' => 'Schema Test',
        'event_status' => EventStatus::SCHEDULED,
        'event_attendance_mode' => EventAttendanceMode::OFFLINE,
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['@type'])->toBe('Event')
        ->and($schema['name'])->toBe('Schema Test')
        ->and($schema['maximumAttendeeCapacity'])->toBe($event->max_attendees);
});

test('getSocialShareData returns seo share data', function () {
    $event = Event::factory()->create(['title' => 'Social Share Test']);
    
    $socialData = $event->getSocialShareData();

    expect($socialData)->toBeInstanceOf(\Modules\Seo\Data\SocialShareData::class)
        ->and($socialData->title)->toBe('Social Share Test');
});

test('getRouteKeyName returns slug', function () {
    $event = new Event();
    expect($event->getRouteKeyName())->toBe('slug');
});

test('event slug auto-generation from title', function () {
    $event = Event::factory()->create([
        'title' => 'My Awesome Event Title '.uniqid(),
        'slug' => null,
    ]);

    expect($event->slug)->toContain('my-awesome-event-title');
});

test('event casts dates correctly', function () {
    $event = Event::factory()->create();
    
    expect($event->start_date)->toBeInstanceOf(Carbon::class)
        ->and($event->end_date)->toBeInstanceOf(Carbon::class);
});

test('event casts meta_data as array', function () {
    $event = Event::factory()->create([
        'meta_data' => ['key' => 'value', 'nested' => ['foo' => 'bar']],
    ]);

    expect($event->meta_data)->toBeArray()
        ->and($event->meta_data['key'])->toBe('value')
        ->and($event->meta_data['nested']['foo'])->toBe('bar');
});

test('event casts offers as array', function () {
    $offers = [['name' => 'Early Bird', 'price' => 20]];
    $event = Event::factory()->create(['offers' => $offers]);

    expect($event->offers)->toBeArray()
        ->and(count($event->offers))->toBe(1);
});

test('event casts attendees_count as integer', function () {
    $event = Event::factory()->create(['attendees_count' => '50']);

    expect($event->attendees_count)->toBeInt()
        ->and($event->attendees_count)->toBe(50);
});

test('event casts event_status to enum', function () {
    $event = Event::factory()->create([
        'event_status' => EventStatus::SCHEDULED,
    ]);

    expect($event->event_status)->toBeInstanceOf(EventStatus::class);
});

test('event casts event_attendance_mode to enum', function () {
    $event = Event::factory()->create([
        'event_attendance_mode' => EventAttendanceMode::ONLINE,
    ]);

    expect($event->event_attendance_mode)->toBeInstanceOf(EventAttendanceMode::class)
        ->and($event->event_attendance_mode)->toBe(EventAttendanceMode::ONLINE);
});

test('event can have null optional fields', function () {
    $event = Event::factory()->create([
        'description' => null,
        'location_id' => null,
        'cover_image' => null,
        'url' => null,
    ]);

    expect($event->description)->toBeNull()
        ->and($event->location_id)->toBeNull()
        ->and($event->cover_image)->toBeNull()
        ->and($event->url)->toBeNull();
});

test('toBlockArray includes correct status for upcoming event', function () {
    $event = Event::factory()->create([
        'start_date' => Carbon::now()->addDays(30),
    ]);

    $block = $event->toBlockArray();

    expect($block['status'])->toBe('upcoming');
});

test('toBlockArray includes correct status for past event', function () {
    $event = Event::factory()->past()->create();

    $block = $event->toBlockArray();

    expect($block['status'])->toBe('past');
});

test('toBlockArray includes attendee counts', function () {
    $event = Event::factory()->create([
        'attendees_count' => 42,
        'max_attendees' => 100,
    ]);

    $block = $event->toBlockArray();

    expect($block['attendees_current'])->toBe(42)
        ->and($block['attendees_max'])->toBe(100);
});

test('toBlockArray includes asset url for cover image', function () {
    $event = Event::factory()->create([
        'cover_image' => 'images/event-cover.jpg',
    ]);

    $block = $event->toBlockArray();

    expect($block['image'])->toContain('event-cover.jpg');
});

test('toBlockArray image is null when no cover image', function () {
    $event = Event::factory()->create([
        'cover_image' => null,
    ]);

    $block = $event->toBlockArray();

    expect($block['image'])->toBeNull();
});

test('toSchemaOrg includes description when provided', function () {
    $event = Event::factory()->create([
        'description' => 'Great Laravel community event',
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['description'])->toBe('Great Laravel community event');
});

test('toSchemaOrg excludes description when null', function () {
    $event = Event::factory()->create([
        'description' => null,
    ]);

    $schema = $event->toSchemaOrg();

    expect(isset($schema['description']))->toBeFalse();
});

test('toSchemaOrg includes image array when cover image provided', function () {
    $event = Event::factory()->create([
        'cover_image' => 'images/event.jpg',
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['image'])->toBeArray()
        ->and(count($schema['image']))->toBeGreaterThan(0);
});

test('toSchemaOrg excludes image when no cover image', function () {
    $event = Event::factory()->create([
        'cover_image' => null,
    ]);

    $schema = $event->toSchemaOrg();

    expect(isset($schema['image']))->toBeFalse();
});

test('toSchemaOrg includes organizer when available', function () {
    $organizer = User::factory()->create([
        'name' => 'John Organizer '.uniqid(),
        'email' => 'organizer-'.uniqid().'@example.com',
    ]);
    $event = Event::factory()->create([
        'organizer_id' => $organizer->id,
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['organizer']['@type'])->toBe('Person')
        ->and($schema['organizer']['name'])->toContain('John Organizer')
        ->and($schema['organizer']['email'])->toContain('@example.com');
});

test('toSchemaOrg excludes organizer when null', function () {
    $event = Event::factory()->create([
        'organizer_id' => null,
    ]);

    $schema = $event->toSchemaOrg();

    expect(isset($schema['organizer']))->toBeFalse();
});

test('getSocialShareData includes event title', function () {
    $event = Event::factory()->create([
        'title' => 'Laravel Pizza Meetup',
    ]);

    $socialData = $event->getSocialShareData();

    expect($socialData->title)->toBe('Laravel Pizza Meetup');
});

test('getSocialShareData includes localized url', function () {
    $event = Event::factory()->create([
        'slug' => 'pizza-meetup-'.uniqid(),
    ]);

    $socialData = $event->getSocialShareData();

    expect($socialData->url)->toContain('events')
        ->and($socialData->url)->toContain('pizza-meetup-');
});

test('getSocialShareData includes description truncated as text', function () {
    $longDescription = str_repeat('x', 200);
    $event = Event::factory()->create([
        'description' => $longDescription,
    ]);

    $socialData = $event->getSocialShareData();

    expect(strlen($socialData->text))->toBeLessThanOrEqual(163);
});

test('getSocialShareData text returns empty string when no description', function () {
    $event = Event::factory()->create([
        'description' => null,
    ]);

    $socialData = $event->getSocialShareData();

    expect($socialData->text)->toBe('');
});

test('getSocialShareData includes asset url for image', function () {
    $event = Event::factory()->create([
        'cover_image' => 'images/event-social.jpg',
    ]);

    $socialData = $event->getSocialShareData();

    expect($socialData->image)->toContain('event-social.jpg');
});

test('getSocialShareData image is null when no cover image', function () {
    $event = Event::factory()->create([
        'cover_image' => null,
    ]);

    $socialData = $event->getSocialShareData();

    expect($socialData->image)->toBeNull();
});

test('event factory online state sets attendance mode', function () {
    $event = Event::factory()->online()->create();

    expect($event->event_attendance_mode)->toBe(EventAttendanceMode::ONLINE);
});

test('event factory past state sets past dates', function () {
    $event = Event::factory()->past()->create();

    expect($event->start_date->isPast())->toBeTrue();
});

test('event connection is meetup', function () {
    $event = new Event();
    expect($event->getConnectionName())->toBe('meetup');
});

test('event has timestamps', function () {
    $event = Event::factory()->create();
    
    expect($event->created_at)->not->toBeNull()
        ->and($event->updated_at)->not->toBeNull()
        ->and($event->created_at)->toBeInstanceOf(Carbon::class);
});

test('event can be found by slug', function () {
    $slug = 'findme-'.uniqid();
    $event = Event::factory()->create(['slug' => $slug]);
    
    $found = Event::getBySlug($slug);
    
    expect($found)->not->toBeNull()
        ->and($found->id)->toBe($event->id);
});
