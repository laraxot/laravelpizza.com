<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Actions\Auth\BuildPasswordResetUrlAction;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * Audit del front office (12/11/2026): titoli per pagina, dati personali non esposti,
 * pagine di autenticazione e di errore tradotte.
 */

function audited_organizer(): User
{
    return User::factory()->create([
        'name' => 'Organizzatrice Audit',
        'email' => 'organizer-audit-'.uniqid().'@example.com',
    ]);
}

function audited_event(User $organizer): Event
{
    return Event::query()->create([
        'title' => 'Serata audit '.uniqid(),
        'description' => 'Una serata per controllare il front office.',
        'location' => 'Milano',
        'start_date' => now()->addDays(10),
        'end_date' => now()->addDays(10)->addHours(2),
        'status' => 'published',
        'organizer_id' => $organizer->getKey(),
    ]);
}

test('the event page has the event title in <title> and never shows the organizer email', function (): void {
    $organizer = audited_organizer();
    $event = audited_event($organizer);

    $this->get('/it/events/'.$event->slug)
        ->assertOk()
        ->assertSee('<title>'.e($event->title).' - ', false)
        ->assertSee('Una serata per controllare il front office.', false)
        ->assertSee('Organizzatrice Audit')
        ->assertDontSee($organizer->email);
});

test('cms pages use their own title and a description taken from the hero block', function (): void {
    $this->get('/it/about')
        ->assertOk()
        ->assertSee('<title>Chi siamo - Laravel Pizza Meetups</title>', false)
        ->assertDontSee('Gestione meta tag e SEO del sito web');

    $this->get('/en/events')
        ->assertOk()
        ->assertSee('<title>Upcoming events - Laravel Pizza Meetups</title>', false);
});

test('a public profile hides email and address from other visitors, also in JSON-LD', function (): void {
    $person = audited_organizer();

    $this->get('/it/profile/'.$person->getKey())
        ->assertOk()
        ->assertSee('<title>Organizzatrice Audit - ', false)
        ->assertDontSee($person->email)
        ->assertDontSee('gravatar.com');

    $this->actingAs($person)
        ->get('/it/profile/'.$person->getKey())
        ->assertOk()
        ->assertSee($person->email);
});

test('an unknown profile id is a 404, not an anonymous profile page', function (): void {
    $this->get('/it/profile/does-not-exist')->assertNotFound();
});

test('the 404 page is translated and keeps the site navigation', function (): void {
    $this->get('/it/pagina-che-non-esiste')
        ->assertNotFound()
        ->assertSee('<title>Pagina non trovata - Laravel Pizza Meetups</title>', false)
        ->assertSee('Guarda i prossimi eventi');

    $this->get('/en/page-that-does-not-exist')
        ->assertNotFound()
        ->assertSee('Page not found');
});

test('the forgot password page is translated and does not reveal whether an email exists', function (): void {
    $this->get('/it/auth/password/reset')
        ->assertOk()
        ->assertSee('<h1', false)
        ->assertSee('Password dimenticata?')
        ->assertDontSee('Send password reset link');

    Notification::fake();
    $known = User::factory()->create(['email' => 'reset-known-'.uniqid().'@example.com']);

    $sent = Volt::test('auth.password.reset')->set('email', $known->email)->call('sendResetPasswordLink')->get('emailSentMessage');
    $unknown = Volt::test('auth.password.reset')->set('email', 'nobody-'.uniqid().'@example.com')->call('sendResetPasswordLink')->get('emailSentMessage');

    expect($sent)->toBeString()->not->toBe('')
        ->and($unknown)->toBe($sent);
});

test('/{locale}/login and /{locale}/register redirect to the auth pages', function (): void {
    $this->get('/it/login')->assertStatus(301)->assertRedirectContains('/it/auth/login');
    $this->get('/en/register')->assertStatus(301)->assertRedirectContains('/en/auth/register');
});

test('forgot password works end to end: the email link resets the password and signs the user in', function (): void {
    Notification::fake();
    $user = User::factory()->create(['email' => 'reset-flow-'.uniqid().'@example.com']);

    Volt::test('auth.password.reset')->set('email', $user->email)->call('sendResetPasswordLink');

    $token = null;
    Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use (&$token): bool {
        $token = $notification->token;

        return true;
    });
    expect($token)->toBeString();

    $this->get('/it/auth/password/'.$token.'?email='.urlencode($user->email))
        ->assertOk()
        ->assertSee('Scegli una nuova password');

    Volt::test('auth.password.token', ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'NuovaPassword!2026')
        ->set('passwordConfirmation', 'NuovaPassword!2026')
        ->call('resetPassword')
        ->assertHasNoErrors()
        ->assertRedirectContains('/events/my');

    expect(Hash::check('NuovaPassword!2026', (string) $user->fresh()?->password))->toBeTrue()
        ->and(auth()->id())->toBe($user->getKey());
});

test('the reset link in the email keeps the language of the request', function (): void {
    $user = User::factory()->create(['email' => 'reset-locale-'.uniqid().'@example.com']);
    app()->setLocale('en'); // come fa il middleware di mcamara sulle richieste /en/...

    $url = app(BuildPasswordResetUrlAction::class)->execute('tok123', $user->email);

    expect($url)->toContain('/en/auth/password/tok123')->toContain('email='.urlencode($user->email));
});
