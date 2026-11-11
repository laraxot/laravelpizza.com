<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Livewire;

use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Modules\Meetup\Actions\Event\GetUserRegisteredEventsAction;
use Modules\Meetup\Actions\Event\JoinEventAction;
use Modules\Meetup\Http\Livewire\EventRegistration;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Notifications\EventRegistrationConfirmedNotification;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * Journey UJ-2 (PRD FR-9, FR-10, FR-11): iscrizione dalla pagina evento.
 */

function registrableEvent(int $capacity = 10): Event
{
    return Event::query()->create([
        'title' => 'Registrable meetup '.uniqid(),
        'slug' => 'registrable-'.uniqid(),
        'status' => 'published',
        'max_attendees' => $capacity,
        'attendees_count' => 0,
        'start_date' => now()->addDays(15),
        'end_date' => now()->addDays(15)->addHours(3),
    ]);
}

test('join event action registers the user and queues the confirmation email', function (): void {
    Notification::fake();
    $user = User::factory()->create();
    $event = registrableEvent();

    app(JoinEventAction::class)->execute($event, $user, 'it');

    expect(EventUser::query()->where('event_id', $event->getKey())->where('user_id', (string) $user->getKey())->exists())->toBeTrue()
        ->and($event->fresh()->attendees_count)->toBe(1);

    Notification::assertSentTo($user, EventRegistrationConfirmedNotification::class, function (EventRegistrationConfirmedNotification $notification) use ($event, $user): bool {
        $mail = $notification->toMail($user);

        return $notification->event->is($event)
            && str_contains((string) $mail->subject, (string) $event->title);
    });
});

test('no confirmation email is sent when the registration is rejected', function (): void {
    Notification::fake();
    $user = User::factory()->create();
    $event = registrableEvent(capacity: 1);
    $event->forceFill(['attendees_count' => 1])->save();

    expect(fn () => app(JoinEventAction::class)->execute($event, $user, 'it'))
        ->toThrow(\DomainException::class, 'Event is full');

    Notification::assertNothingSent();
});

test('a guest is sent to the login page and back to the event afterwards', function (): void {
    $event = registrableEvent();

    Livewire::test(EventRegistration::class, ['event' => $event])
        ->call('register')
        ->assertRedirect();

    expect((string) session('url.intended'))->toContain('/events/'.$event->slug);
    expect(EventUser::query()->where('event_id', $event->getKey())->count())->toBe(0);
});

test('an authenticated user registers and can cancel the registration', function (): void {
    Notification::fake();
    $user = User::factory()->create();
    $event = registrableEvent();

    $component = Livewire::actingAs($user)
        ->test(EventRegistration::class, ['event' => $event])
        ->assertSee(__('meetup::event_registration.actions.register'))
        ->call('register')
        ->assertSet('messageType', 'success')
        ->assertSee(__('meetup::event_registration.state.registered'));

    expect($event->fresh()->attendees_count)->toBe(1);

    $component->call('unregister')
        ->assertSet('messageType', 'success')
        ->assertSee(__('meetup::event_registration.actions.register'));

    expect($event->fresh()->attendees_count)->toBe(0);
});

test('a full event shows the sold out state and refuses registrations', function (): void {
    $user = User::factory()->create();
    $event = registrableEvent(capacity: 1);
    $event->forceFill(['attendees_count' => 1])->save();

    Livewire::actingAs($user)
        ->test(EventRegistration::class, ['event' => $event])
        ->assertSee(__('meetup::event_registration.state.full'))
        ->call('register')
        ->assertSet('messageType', 'error')
        ->assertSee(__('meetup::event_registration.messages.full'));
});

test('my events lists only the published events the user registered for', function (): void {
    $user = User::factory()->create();
    $mine = registrableEvent();
    $other = registrableEvent();
    $draft = registrableEvent();
    EventUser::query()->create(['event_id' => $mine->getKey(), 'user_id' => (string) $user->getKey()]);
    EventUser::query()->create(['event_id' => $draft->getKey(), 'user_id' => (string) $user->getKey()]);
    $draft->forceFill(['status' => 'draft'])->save();

    $ids = app(GetUserRegisteredEventsAction::class)
        ->execute((string) $user->getKey())
        ->pluck('id')
        ->all();

    expect($ids)->toBe([$mine->getKey()]);

    $this->actingAs($user)
        ->get('/it/events-my')
        ->assertOk()
        ->assertSee($mine->title)
        ->assertDontSee($other->title);
});
