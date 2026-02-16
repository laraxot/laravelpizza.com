<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;

uses(TestCase::class);

test('login component renders', function () {
    $component = LivewireVolt::test('auth.login');

    expect($component)->not->toBeNull();
    $component->assertOk();
});

test('login component has default empty fields', function () {
    $component = LivewireVolt::test('auth.login');

    $component->assertSet('email', '')->assertSet('password', '')->assertSet('remember', false);
});

test('login component shows wire models', function () {
    $component = LivewireVolt::test('auth.login');

    $component
        ->assertSee('wire:model="email"')
        ->assertSee('wire:model="password"')
        ->assertSee('wire:model="remember"');
});

test('user can authenticate with valid credentials', function () {
    $email = $this->generateUniqueEmail();
    $user = $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasNoErrors();
    assertAuthenticated();
});

test('user cannot authenticate with invalid password', function () {
    $email = $this->generateUniqueEmail();
    $this->createTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'wrong_password')
        ->call('save');

    $response->assertHasErrors(['email']);
    assertGuest();
});

test('user cannot authenticate with non-existent email', function () {
    $email = $this->generateUniqueEmail();

    assertGuest();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
    assertGuest();
});

test('user cannot authenticate with invalid email format', function () {
    $response = LivewireVolt::test('auth.login')
        ->set('email', 'invalid-email')
        ->set('password', 'password123')
        ->call('save');

    $response->assertHasErrors(['email']);
});

test('form validation requires email and password', function () {
    $response = LivewireVolt::test('auth.login')->call('save');

    $response->assertHasErrors(['email', 'password']);
});

test('password too short fails validation', function () {
    $email = $this->generateUniqueEmail();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $email)
        ->set('password', '123')
        ->call('save');

    $response->assertHasErrors();
});
