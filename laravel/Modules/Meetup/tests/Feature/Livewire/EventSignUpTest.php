<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Livewire;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Modules\Gdpr\Models\Consent;
use Modules\Meetup\Actions\Event\SignUpAndJoinEventAction;
use Modules\Meetup\Http\Livewire\EventRegistration;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Notifications\EventRegistrationConfirmedNotification;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * PRD FR-9: il visitatore si iscrive a un evento con solo email e password, dalla pagina dell'evento.
 * Conseguenze: email non valida o già registrata (con un'altra password) → errore chiaro; nessun altro campo obbligatorio.
 */

beforeEach(function (): void {
    Notification::fake();
    // Password::defaults() controlla la password su Have I Been Pwned: nei test niente rete.
    Http::fake(['api.pwnedpasswords.com/*' => Http::response('', 200)]);
    RateLimiter::clear('event-signup|127.0.0.1');
});

function signUpEvent(int $capacity = 10): Event
{
    return Event::query()->create([
        'title' => 'Sign-up meetup '.uniqid(),
        'slug' => 'signup-'.uniqid(),
        'status' => 'published',
        'max_attendees' => $capacity,
        'attendees_count' => 0,
        'start_date' => now()->addDays(10),
        'end_date' => now()->addDays(10)->addHours(2),
    ]);
}

function registeredTo(Event $event, string $userId): bool
{
    return EventUser::query()->where('event_id', $event->getKey())->where('user_id', $userId)->exists();
}

test('a visitor creates an account and joins the event with only email and password', function (): void {
    $event = signUpEvent();
    $email = 'nuova.'.uniqid().'@example.test';

    Livewire::test(EventRegistration::class, ['event' => $event])
        ->assertSee(__('meetup::event_registration.signup.intro'))
        ->set('email', strtoupper($email))
        ->set('password', 'Pizza-Meetup-2026!')
        ->set('consentsAccepted', true)
        ->call('signUp')
        ->assertHasNoErrors()
        ->assertRedirect();

    $user = User::query()->where('email', $email)->first();
    expect($user)->toBeInstanceOf(User::class)
        ->and(Hash::check('Pizza-Meetup-2026!', (string) $user->password))->toBeTrue()
        ->and($user->email_verified_at)->toBeNull()
        ->and((string) $user->name)->not->toBe('')
        ->and(registeredTo($event, (string) $user->id))->toBeTrue()
        ->and(auth()->id())->toBe($user->id);

    // FR-10: conferma dell'iscrizione.
    Notification::assertSentTo($user, EventRegistrationConfirmedNotification::class);
});

test('an existing account with the right password joins without creating a new user', function (): void {
    $event = signUpEvent();
    $user = User::factory()->create(['password' => Hash::make('Giusta-Password-1!')]);
    $before = User::query()->count();

    Livewire::test(EventRegistration::class, ['event' => $event])
        ->set('email', (string) $user->email)
        ->set('password', 'Giusta-Password-1!')
        ->call('signUp')
        ->assertHasNoErrors()
        ->assertRedirect();

    expect(User::query()->count())->toBe($before)
        ->and(registeredTo($event, (string) $user->id))->toBeTrue();
});

test('an existing email with a different password is rejected with a clear message', function (): void {
    $event = signUpEvent();
    $user = User::factory()->create(['password' => Hash::make('Giusta-Password-1!')]);

    Livewire::test(EventRegistration::class, ['event' => $event])
        ->set('email', (string) $user->email)
        ->set('password', 'Sbagliata-Password-1!')
        ->set('consentsAccepted', true)
        ->call('signUp')
        ->assertHasErrors(['email'])
        ->assertSee(__('meetup::event_registration.signup.email_taken'))
        ->assertSet('password', '');

    expect(registeredTo($event, (string) $user->id))->toBeFalse()
        ->and(auth()->check())->toBeFalse();
});

test('invalid email, weak password and missing consent are rejected before anything is saved', function (array $input, string $field): void {
    $event = signUpEvent();
    $before = User::query()->count();

    Livewire::test(EventRegistration::class, ['event' => $event])
        ->set('email', $input['email'])
        ->set('password', $input['password'])
        ->set('consentsAccepted', $input['consents'])
        ->call('signUp')
        ->assertHasErrors([$field]);

    expect(User::query()->count())->toBe($before)
        ->and(EventUser::query()->where('event_id', $event->getKey())->count())->toBe(0);
})->with([
    'invalid email' => [['email' => 'non-una-email', 'password' => 'Pizza-Meetup-2026!', 'consents' => true], 'email'],
    'weak password' => [['email' => 'debole@example.test', 'password' => 'pizza', 'consents' => true], 'password'],
    'no consent' => [['email' => 'senza.consenso@example.test', 'password' => 'Pizza-Meetup-2026!', 'consents' => false], 'consentsAccepted'],
]);

test('a full event is refused before the account is created (FR-11)', function (): void {
    $event = signUpEvent(capacity: 1);
    $event->forceFill(['attendees_count' => 1])->save();

    expect(fn () => app(SignUpAndJoinEventAction::class)->execute($event, 'piena@example.test', 'Pizza-Meetup-2026!', true, 'it'))
        ->toThrow(\DomainException::class, 'Event is full');

    expect(User::query()->where('email', 'piena@example.test')->exists())->toBeFalse();
});

test('the consents of a new account are stored as GDPR proof', function (): void {
    $event = signUpEvent();

    $result = app(SignUpAndJoinEventAction::class)->execute($event, 'consensi@example.test', 'Pizza-Meetup-2026!', true, 'en');

    expect($result['created'])->toBeTrue()
        ->and(Consent::query()->where('user_id', $result['user']->id)->whereNotNull('accepted_at')->count())->toBe(2);
});

test('repeated attempts from the same address are throttled', function (): void {
    $event = signUpEvent();
    $component = Livewire::test(EventRegistration::class, ['event' => $event]);

    foreach (range(1, 5) as $attempt) {
        $component->set('email', 'x')->set('password', 'y')->call('signUp');
    }

    $component->set('email', 'x')->set('password', 'y')->call('signUp')->assertHasErrors(['email']);

    $expected = explode(':seconds', (string) __('meetup::event_registration.signup.throttle'))[0];
    expect((string) $component->errors()->first('email'))->toStartWith($expected);
});
