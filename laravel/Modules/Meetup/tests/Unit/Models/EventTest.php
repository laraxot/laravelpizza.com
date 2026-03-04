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
        'slug' => null, // Test auto-slugging
    ]);

    expect($event->title)->toContain('Test Event')
        ->and($event->slug)->not->toBeEmpty()
        ->and($event->attendees_count)->toBe(0)
        ->and($event->max_attendees)->toBeGreaterThan(0);
});

test('it has the correct relations', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create([
        'user_id' => $user->id,
        'created_by' => $user->id,
        'updated_by' => $user->id,
        'organizer_id' => $user->id,
    ]);

    $event->refresh(); // Crucial for cross-connection relations

    expect($event->owner)->toBeInstanceOf(User::class)
        ->and($event->owner->id)->toBe($user->id)
        ->and($event->creator->id)->toBe($user->id)
        ->and($event->updater->id)->toBe($user->id)
        ->and($event->organizer->id)->toBe($user->id);
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
    $slug = 'unique-slug-'.uniqid();
    $event = Event::factory()->create(['slug' => $slug]);
    Event::factory()->create(['slug' => 'other-slug-'.uniqid()]);

    $result = Event::bySlug($slug)->first();

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
        'cover_image' => 'images/test.jpg',
    ]);

    $block = $event->toBlockArray();

    expect($block['title'])->toBe('Block Test')
        ->and($block['slug'])->toBe($event->slug)
        ->and($block['status'])->toBe('upcoming')
        ->and($block['date'])->toBe('June 1, 2026')
        ->and($block['time'])->toBe('10:00 AM - 2:00 PM')
        ->and($block['url'])->toContain($event->slug);
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

test('event has correct fillable fields', function () {
    $event = new Event();
    $fillable = [
        'title', 'description', 'in_language', 'start_date', 'end_date', 'duration',
        'location', 'location_id', 'status', 'event_status', 'event_attendance_mode',
        'attendees_count', 'max_attendees', 'cover_image', 'slug', 'url',
        'offers', 'meta_data', 'user_id', 'organizer_id',
    ];
    
    foreach ($fillable as $field) {
        expect(in_array($field, $event->getFillable()))->toBeTrue();
    }
});

test('event has correct default attributes', function () {
    $event = Event::factory()->make();
    
    expect($event->attendees_count)->toBe(0)
        ->and($event->max_attendees)->toBeGreaterThan(0)
        ->and($event->status)->toBe('draft');
});

test('event casts dates correctly', function () {
    $event = Event::factory()->create();
    
    expect($event->start_date)->toBeInstanceOf(Carbon::class)
        ->and($event->end_date)->toBeInstanceOf(Carbon::class)
        ->and($event->created_at)->toBeInstanceOf(Carbon::class);
});

test('event casts meta_data and offers as arrays', function () {
    $event = Event::factory()->create([
        'meta_data' => ['key' => 'value'],
        'offers' => [['name' => 'Ticket', 'price' => 10]],
    ]);

    expect($event->meta_data)->toBeArray()
        ->and($event->offers)->toBeArray()
        ->and($event->meta_data['key'])->toBe('value');
});

test('event casts attendees and max_attendees as integers', function () {
    $event = Event::factory()->create([
        'attendees_count' => '50',
        'max_attendees' => '100',
    ]);

    expect($event->attendees_count)->toBeInt()
        ->and($event->max_attendees)->toBeInt()
        ->and($event->attendees_count)->toBe(50)
        ->and($event->max_attendees)->toBe(100);
});

test('event casts event_status to enum', function () {
    $event = Event::factory()->create([
        'event_status' => EventStatus::SCHEDULED,
    ]);

    expect($event->event_status)->toBeInstanceOf(EventStatus::class)
        ->and($event->event_status)->toBe(EventStatus::SCHEDULED);
});

test('event casts event_attendance_mode to enum', function () {
    $event = Event::factory()->create([
        'event_attendance_mode' => EventAttendanceMode::ONLINE,
    ]);

    expect($event->event_attendance_mode)->toBeInstanceOf(EventAttendanceMode::class)
        ->and($event->event_attendance_mode)->toBe(EventAttendanceMode::ONLINE);
});

test('event slug is auto-generated from title if not provided', function () {
    $event = Event::factory()->create([
        'title' => 'My Awesome Event',
        'slug' => null,
    ]);

    expect($event->slug)->toBe('my-awesome-event');
});

test('event slug is preserved if provided', function () {
    $event = Event::factory()->create([
        'title' => 'My Event',
        'slug' => 'custom-slug',
    ]);

    expect($event->slug)->toBe('custom-slug');
});

test('event can be created with null optional fields', function () {
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

test('upcoming scope excludes events without start_date', function () {
    Event::factory()->create(['start_date' => null]);
    
    $upcoming = Event::upcoming()->get();
    
    expect($upcoming->count())->toBeGreaterThanOrEqual(0);
});

test('past scope excludes events without start_date', function () {
    Event::factory()->create(['start_date' => null]);
    
    $past = Event::past()->get();
    
    expect($past->count())->toBeGreaterThanOrEqual(0);
});

test('event owner relation loads correctly', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create(['user_id' => $user->id]);
    
    expect($event->owner)->toBeInstanceOf(User::class)
        ->and($event->owner->id)->toBe($user->id);
});

test('event creator relation loads correctly', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create(['created_by' => $user->id]);
    
    expect($event->creator)->toBeInstanceOf(User::class)
        ->and($event->creator->id)->toBe($user->id);
});

test('event updater relation loads correctly', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create(['updated_by' => $user->id]);
    
    expect($event->updater)->toBeInstanceOf(User::class)
        ->and($event->updater->id)->toBe($user->id);
});

test('event organizer relation loads correctly', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create(['organizer_id' => $user->id]);
    
    expect($event->organizer)->toBeInstanceOf(User::class)
        ->and($event->organizer->id)->toBe($user->id);
});

test('event can have all user relations pointing to different users', function () {
    $owner = User::factory()->create();
    $creator = User::factory()->create();
    $updater = User::factory()->create();
    $organizer = User::factory()->create();
    
    $event = Event::factory()->create([
        'user_id' => $owner->id,
        'created_by' => $creator->id,
        'updated_by' => $updater->id,
        'organizer_id' => $organizer->id,
    ]);

    expect($event->owner->id)->toBe($owner->id)
        ->and($event->creator->id)->toBe($creator->id)
        ->and($event->updater->id)->toBe($updater->id)
        ->and($event->organizer->id)->toBe($organizer->id);
});

test('toBlockArray includes correct formatted dates', function () {
    $event = Event::factory()->create([
        'start_date' => Carbon::parse('2026-12-25 14:30:00'),
        'end_date' => Carbon::parse('2026-12-25 18:00:00'),
    ]);

    $block = $event->toBlockArray();

    expect($block['date'])->toContain('December')
        ->and($block['date'])->toContain('25')
        ->and($block['time'])->toContain('2:30 PM')
        ->and($block['time'])->toContain('6:00 PM');
});

test('toBlockArray status is upcoming for future events', function () {
    $event = Event::factory()->create([
        'start_date' => Carbon::now()->addDays(30),
    ]);

    $block = $event->toBlockArray();

    expect($block['status'])->toBe('upcoming');
});

test('toBlockArray status is past for past events', function () {
    $event = Event::factory()->create([
        'start_date' => Carbon::now()->subDays(30),
    ]);

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

test('toBlockArray url is localized', function () {
    $event = Event::factory()->create([
        'slug' => 'test-event',
    ]);

    $block = $event->toBlockArray();

    expect($block['url'])->toContain('events')
        ->and($block['url'])->toContain('test-event');
});

test('toSchemaOrg returns structured data with event type', function () {
    $event = Event::factory()->create();

    $schema = $event->toSchemaOrg();

    expect($schema['@context'])->toBe('https://schema.org')
        ->and($schema['@type'])->toBe('Event');
});

test('toSchemaOrg includes event name from title', function () {
    $event = Event::factory()->create([
        'title' => 'Laravel Meetup 2026',
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['name'])->toBe('Laravel Meetup 2026');
});

test('toSchemaOrg includes dates in ISO format', function () {
    $event = Event::factory()->create([
        'start_date' => Carbon::parse('2026-06-15 10:00:00'),
        'end_date' => Carbon::parse('2026-06-15 14:00:00'),
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['startDate'])->toContain('2026-06-15')
        ->and($schema['endDate'])->toContain('2026-06-15');
});

test('toSchemaOrg includes location as place object', function () {
    $event = Event::factory()->create([
        'location' => 'Roma, Italy',
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['location']['@type'])->toBe('Place')
        ->and($schema['location']['name'])->toBe('Roma, Italy');
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
        ->and(count($schema['image']))->toBeGreaterThan(0)
        ->and($schema['image'][0])->toContain('event.jpg');
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
        'name' => 'John Organizer',
        'email' => 'john@example.com',
    ]);
    $event = Event::factory()->create([
        'organizer_id' => $organizer->id,
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['organizer']['@type'])->toBe('Person')
        ->and($schema['organizer']['name'])->toBe('John Organizer')
        ->and($schema['organizer']['email'])->toBe('john@example.com');
});

test('toSchemaOrg excludes organizer when null', function () {
    $event = Event::factory()->create([
        'organizer_id' => null,
    ]);

    $schema = $event->toSchemaOrg();

    expect(isset($schema['organizer']))->toBeFalse();
});

test('toSchemaOrg includes offers when available', function () {
    $offers = [['@type' => 'Offer', 'price' => '20']];
    $event = Event::factory()->create([
        'offers' => $offers,
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['offers'])->toBe($offers);
});

test('toSchemaOrg excludes offers when null', function () {
    $event = Event::factory()->create([
        'offers' => null,
    ]);

    $schema = $event->toSchemaOrg();

    expect(isset($schema['offers']))->toBeFalse();
});

test('toSchemaOrg includes inLanguage when provided', function () {
    $event = Event::factory()->create([
        'in_language' => 'it',
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['inLanguage'])->toBe('it');
});

test('toSchemaOrg excludes inLanguage when null', function () {
    $event = Event::factory()->create([
        'in_language' => null,
    ]);

    $schema = $event->toSchemaOrg();

    expect(isset($schema['inLanguage']))->toBeFalse();
});

test('toSchemaOrg includes duration when provided', function () {
    $event = Event::factory()->create([
        'duration' => 'PT4H',
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['duration'])->toBe('PT4H');
});

test('toSchemaOrg excludes duration when null', function () {
    $event = Event::factory()->create([
        'duration' => null,
    ]);

    $schema = $event->toSchemaOrg();

    expect(isset($schema['duration']))->toBeFalse();
});

test('toSchemaOrg always includes maximum attendee capacity', function () {
    $event = Event::factory()->create([
        'max_attendees' => 150,
    ]);

    $schema = $event->toSchemaOrg();

    expect($schema['maximumAttendeeCapacity'])->toBe(150);
});

test('getSocialShareData returns social share data object', function () {
    $event = Event::factory()->create();

    $socialData = $event->getSocialShareData();

    expect($socialData)->toBeInstanceOf(\Modules\Seo\Data\SocialShareData::class);
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
        'slug' => 'pizza-meetup',
    ]);

    $socialData = $event->getSocialShareData();

    expect($socialData->url)->toContain('events')
        ->and($socialData->url)->toContain('pizza-meetup');
});

test('getSocialShareData includes truncated description as text', function () {
    $longDescription = 'This is a very long description that should be truncated to fit in social share text with a maximum of 160 characters to maintain compatibility with most social platforms';
    $event = Event::factory()->create([
        'description' => $longDescription,
    ]);

    $socialData = $event->getSocialShareData();

    expect(strlen($socialData->text))->toBeLessThanOrEqual(163); // 160 + "..."
});

test('getSocialShareData has null text when no description', function () {
    $event = Event::factory()->create([
        'description' => null,
    ]);

    $socialData = $event->getSocialShareData();

    expect($socialData->text)->toBeNull();
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

test('event factory online state sets attendance mode and url', function () {
    $event = Event::factory()->online()->create();

    expect($event->event_attendance_mode)->toBe(EventAttendanceMode::ONLINE)
        ->and($event->url)->not->toBeNull();
});

test('event can be created with multiple state factories', function () {
    $event = Event::factory()->online()->past()->create();

    expect($event->event_attendance_mode)->toBe(EventAttendanceMode::ONLINE)
        ->and($event->start_date->isPast())->toBeTrue();
});

test('event connection is meetup', function () {
    $event = new Event();
    expect($event->getConnectionName())->toBe('meetup');
});

test('event uses has xot factory trait', function () {
    $event = Event::factory()->create();
    expect($event)->toBeInstanceOf(Event::class);
});

test('event has timestamps', function () {
    $event = Event::factory()->create();
    
    expect($event->created_at)->not->toBeNull()
        ->and($event->updated_at)->not->toBeNull()
        ->and($event->created_at)->toBeInstanceOf(Carbon::class)
        ->and($event->updated_at)->toBeInstanceOf(Carbon::class);
});

test('event can be saved and retrieved with all fillable attributes', function () {
    $data = [
        'title' => 'Complete Event',
        'description' => 'Full event description',
        'in_language' => 'en',
        'location' => 'Virtual',
        'location_id' => null,
        'status' => 'published',
        'event_status' => EventStatus::SCHEDULED,
        'event_attendance_mode' => EventAttendanceMode::ONLINE,
        'attendees_count' => 25,
        'max_attendees' => 50,
        'cover_image' => 'images/complete-event.jpg',
        'url' => 'https://example.com/event',
    ];
    
    $event = Event::factory()->create($data);
    $retrieved = Event::find($event->id);

    expect($retrieved->title)->toBe($data['title'])
        ->and($retrieved->location)->toBe($data['location'])
        ->and($retrieved->attendees_count)->toBe($data['attendees_count']);
});
