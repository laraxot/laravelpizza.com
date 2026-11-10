<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * Accesso e registrazione dal sito pubblico. I moduli sono widget Livewire (LoginWidget, RegisterWidget):
 * non esistono rotte POST /auth/login o /auth/register, quindi i test passano dai componenti come fa il browser.
 * Email sempre univoche: la tabella users vive su un'altra connessione e un indirizzo fisso
 * (test@example.com) faceva fallire i test in base all'ordine di esecuzione.
 */

function authEmail(string $prefix): string
{
    return $prefix.'-'.uniqid().'@example.test';
}

beforeEach(function (): void {
    RateLimiter::clear('register|127.0.0.1');
});

test('login and registration pages load in italian and english', function (string $path): void {
    $this->get($path)->assertOk();
})->with(['/it/auth/login', '/en/auth/login', '/it/auth/register', '/en/auth/register']);

test('the login page shows email and password fields and links to registration', function (): void {
    $this->get('/it/auth/login')
        ->assertOk()
        ->assertSee('type="email"', false)
        ->assertSee('type="password"', false)
        ->assertSee('/it/auth/register', false);
});

test('the registration page shows the fields and both mandatory consents', function (): void {
    $this->get('/it/auth/register')
        ->assertOk()
        ->assertSee('first_name', false)
        ->assertSee('last_name', false)
        ->assertSee('privacy_accepted', false)
        ->assertSee('terms_accepted', false)
        ->assertSee('/it/auth/login', false);
});

test('a user can log in with the right password and lands on their events', function (): void {
    $user = User::factory()->create(['email' => authEmail('login'), 'password' => Hash::make('Password!2026')]);

    Livewire::test(LoginWidget::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'Password!2026')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect();

    $this->assertAuthenticatedAs($user);
});

test('a wrong password does not log the user in', function (): void {
    $user = User::factory()->create(['email' => authEmail('wrong'), 'password' => Hash::make('Password!2026')]);

    Livewire::test(LoginWidget::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'not-the-password')
        ->call('login')
        ->assertHasErrors(['data.email']);

    $this->assertGuest();
});

test('a visitor can create an account and is logged in', function (): void {
    $email = authEmail('register');

    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'Giulia')
        ->set('last_name', 'Rossi')
        ->set('email', $email)
        ->set('password', 'Pizza!Margherita26')
        ->set('password_confirmation', 'Pizza!Margherita26')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect();

    $user = User::query()->where('email', $email)->first();
    expect($user)->not->toBeNull()
        ->and($user?->name)->toBe('Giulia Rossi');
    $this->assertAuthenticatedAs($user);
});

test('registration needs an email and both consents', function (array $override, string $field): void {
    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'Mario')
        ->set('last_name', 'Bianchi')
        ->set('email', authEmail('consent'))
        ->set('password', 'Pizza!Margherita26')
        ->set('password_confirmation', 'Pizza!Margherita26')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->set($override)
        ->call('submit')
        ->assertHasErrors([$field]);

    $this->assertGuest();
})->with([
    'no email' => [['email' => ''], 'email'],
    'no privacy consent' => [['privacy_accepted' => false], 'privacy_accepted'],
    'no terms consent' => [['terms_accepted' => false], 'terms_accepted'],
]);

test('an email cannot be registered twice', function (): void {
    $existing = User::factory()->create(['email' => authEmail('twice')]);

    Livewire::test(RegisterWidget::class)
        ->set('first_name', 'Mario')
        ->set('last_name', 'Bianchi')
        ->set('email', $existing->email)
        ->set('password', 'Pizza!Margherita26')
        ->set('password_confirmation', 'Pizza!Margherita26')
        ->set('privacy_accepted', true)
        ->set('terms_accepted', true)
        ->call('submit')
        ->assertHasErrors(['email']);
});
