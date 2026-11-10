<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Admin;

use Filament\Facades\Filament;
use Modules\Meetup\Filament\Resources\EventResource\Pages\CreateEvent;
use Modules\Meetup\Filament\Resources\EventResource\Pages\EditEvent;
use Modules\Meetup\Filament\Resources\EventResource\RelationManagers\RegistrationsRelationManager;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Models\Performer;
use Modules\Meetup\Models\Venue;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\Role;
use Modules\User\Models\User;

use function Pest\Livewire\livewire;

uses(TestCase::class);

/**
 * Pannello organizzatore (PRD FR-1, FR-2, FR-4): pagine raggiungibili, creazione tramite CreateEventAction,
 * relatori collegati, elenco iscritti.
 */
function organizer(): User
{
    $user = User::factory()->create();
    $role = Role::query()->firstOrCreate(['name' => 'meetup::admin', 'guard_name' => 'web']);
    $user->assignRole($role);

    return $user;
}

beforeEach(function (): void {
    Filament::setCurrentPanel(Filament::getPanel('meetup::admin'));
});

test('the organizer reaches every page of the panel', function (string $path): void {
    $this->actingAs(organizer())
        ->get('/meetup/admin/'.$path)
        ->assertOk();
})->with([
    'events', 'events/create',
    'venues', 'venues/create',
    'performers', 'performers/create',
    'sponsors', 'sponsors/create',
]);

test('a user without the organizer role cannot open the panel', function (): void {
    $this->actingAs(User::factory()->create())
        ->get('/meetup/admin/events')
        ->assertForbidden();
});

test('creating an event from the panel records the organizer and links speakers and venue', function (): void {
    $user = organizer();
    $venue = Venue::query()->create(['name' => 'Sala test '.uniqid(), 'city' => 'Milano']);
    $performer = Performer::query()->create(['name' => 'Relatrice '.uniqid(), 'type' => 'speaker']);

    $this->actingAs($user);

    livewire(CreateEvent::class)
        ->fillForm([
            'title' => 'Evento dal pannello '.uniqid(),
            'start_date' => now()->addWeek()->setTime(19, 0),
            'end_date' => now()->addWeek()->setTime(22, 0),
            'location' => 'Milano',
            'location_id' => $venue->getKey(),
            'status' => 'published',
            'max_attendees' => 40,
            'performers' => [$performer->getKey()],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $event = Event::query()->where('location_id', $venue->getKey())->latest('id')->firstOrFail();

    expect($event->user_id)->toBe((string) $user->getKey())
        ->and($event->organizer_id)->toBe((string) $user->getKey())
        ->and($event->performers()->pluck('performers.id')->all())->toContain($performer->getKey());
});

test('the end of an event must come after its start', function (): void {
    $this->actingAs(organizer());

    livewire(CreateEvent::class)
        ->fillForm([
            'title' => 'Date invertite',
            'start_date' => now()->addWeek()->setTime(22, 0),
            'end_date' => now()->addWeek()->setTime(19, 0),
            'location' => 'Roma',
            'status' => 'draft',
            'max_attendees' => 10,
        ])
        ->call('create')
        ->assertHasFormErrors(['end_date']);
});

test('the organizer sees who registered and can cancel a registration', function (): void {
    $this->actingAs(organizer());
    $attendee = User::factory()->create();
    $event = Event::query()->create([
        'title' => 'Con iscritti '.uniqid(),
        'location' => 'Torino',
        'start_date' => now()->addDays(3),
        'end_date' => now()->addDays(3)->addHours(2),
        'status' => 'published',
        'max_attendees' => 10,
        'attendees_count' => 1,
    ]);
    $registration = EventUser::query()->create(['event_id' => $event->getKey(), 'user_id' => (string) $attendee->getKey(), 'status' => 'attending']);

    livewire(RegistrationsRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class])
        ->assertOk()
        ->assertCanSeeTableRecords([$registration])
        ->callTableAction('cancel_registration', $registration);

    expect(EventUser::query()->whereKey($registration->getKey())->exists())->toBeFalse()
        ->and($event->fresh()?->attendees_count)->toBe(0);
});
