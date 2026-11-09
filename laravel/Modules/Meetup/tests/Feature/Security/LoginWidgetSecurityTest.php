<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Security;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * security-audit S-05: il login Livewire ha un limite di tentativi
 * e un login riuscito non mostra più l'errore "credenziali non valide".
 */

beforeEach(function (): void {
    RateLimiter::clear('throttle-check@example.test|127.0.0.1');
});

test('a successful login authenticates without reporting an error', function (): void {
    $user = User::factory()->create([
        'email' => 'login-ok-'.uniqid().'@example.test',
        'password' => Hash::make('secret-password'),
    ]);

    Livewire::test(LoginWidget::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'secret-password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect();

    $this->assertAuthenticatedAs($user);
});

test('login attempts are throttled after five failures', function (): void {
    User::factory()->create([
        'email' => 'throttle-check@example.test',
        'password' => Hash::make('right-password'),
    ]);

    $component = Livewire::test(LoginWidget::class)
        ->set('data.email', 'throttle-check@example.test')
        ->set('data.password', 'wrong-password');

    foreach (range(1, 5) as $attempt) {
        $component->call('login')->assertHasErrors(['data.email']);
    }

    // Anche con la password giusta il sesto tentativo è bloccato.
    $component->set('data.password', 'right-password')
        ->call('login')
        ->assertHasErrors(['data.email']);

    $this->assertGuest();
});
