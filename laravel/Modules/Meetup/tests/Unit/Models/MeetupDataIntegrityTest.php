<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Actions\Event\ExportEventRegistrationsAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventPerformer;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Models\Performer;
use Modules\Meetup\Models\Sponsor;
use Modules\Meetup\Models\Venue;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

function integrityEvent(array $attributes = []): Event
{
    return Event::query()->create([
        'title' => 'Evento integrita',
        'location' => 'Milano',
        'start_date' => now()->addDays(5),
        'end_date' => now()->addDays(5)->addHours(2),
        'status' => 'published',
        ...$attributes,
    ]);
}

test('two events with the same title get different slugs', function (): void {
    $title = 'Laravel Pizza Milano '.uniqid();

    $first = integrityEvent(['title' => $title]);
    $second = integrityEvent(['title' => $title]);
    $third = integrityEvent(['title' => $title]);

    expect($first->slug)->toBe(str($title)->slug()->toString())
        ->and($second->slug)->toBe($first->slug.'-2')
        ->and($third->slug)->toBe($first->slug.'-3');
});

test('the public JSON-LD never contains the organizer email', function (): void {
    $organizer = User::factory()->create(['email' => 'organizzatrice-'.uniqid().'@example.test']);
    $event = integrityEvent(['organizer_id' => (string) $organizer->getKey()]);

    $json = (string) json_encode($event->fresh()?->toSchemaOrg());

    expect($json)->not->toContain($organizer->email)
        ->and($json)->toContain('"organizer"');
});

test('cover images uploaded from the panel get a public storage url', function (): void {
    $event = integrityEvent(['cover_image' => 'events/cover.jpg']);

    expect($event->coverImageUrl())->toEndWith('/storage/events/cover.jpg')
        ->and(integrityEvent(['cover_image' => 'https://cdn.example.test/a.jpg'])->coverImageUrl())->toBe('https://cdn.example.test/a.jpg')
        ->and(integrityEvent()->coverImageUrl())->toBeNull();
});

test('deleting a venue keeps its events and clears the link', function (): void {
    $venue = Venue::query()->create(['name' => 'Sala '.uniqid(), 'city' => 'Roma']);
    $event = integrityEvent(['location_id' => $venue->getKey()]);

    $venue->delete();

    expect($event->fresh()?->location_id)->toBeNull();
});

test('deleting a speaker or a sponsor removes only their links to events', function (): void {
    $event = integrityEvent();
    $performer = Performer::query()->create(['name' => 'Relatore '.uniqid()]);
    $sponsor = Sponsor::query()->create(['name' => 'Sponsor '.uniqid()]);
    $event->performers()->attach($performer->getKey());
    $event->sponsors()->attach($sponsor->getKey());

    $performer->delete();
    $sponsor->delete();

    expect(EventPerformer::query()->where('event_id', $event->getKey())->exists())->toBeFalse()
        ->and(EventSponsor::query()->where('event_id', $event->getKey())->exists())->toBeFalse()
        ->and(Event::query()->whereKey($event->getKey())->exists())->toBeTrue();
});

test('the attendee export lists name and email and neutralises spreadsheet formulas', function (): void {
    $event = integrityEvent();
    $honest = User::factory()->create(['name' => 'Giulia Rossi', 'email' => 'giulia-'.uniqid().'@example.test']);
    $tricky = User::factory()->create(['name' => '=HYPERLINK("http://evil.test")', 'email' => 'x-'.uniqid().'@example.test']);
    foreach ([$honest, $tricky] as $user) {
        EventUser::query()->create(['event_id' => $event->getKey(), 'user_id' => (string) $user->getKey(), 'status' => 'attending']);
    }

    $rows = app(ExportEventRegistrationsAction::class)->rows($event);
    $names = array_column($rows, 0);

    expect($rows)->toHaveCount(2)
        ->and($names)->toContain('Giulia Rossi')
        ->and($names)->toContain('\'=HYPERLINK("http://evil.test")')
        ->and(array_column($rows, 1))->toContain($honest->email);
});
