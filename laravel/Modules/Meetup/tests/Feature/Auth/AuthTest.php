<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Filament\Widgets\Auth\RegisterWidget;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

it('login page loads successfully', function () {
    $response = $this->get('/it/auth/login');
    $response->assertStatus(200);
});

it('register page loads successfully', function () {
    $response = $this->get('/it/auth/register');
    $response->assertStatus(200);
});

it('user can login with valid credentials', function () {
    $password = 'Password123!';
    $user = User::factory()->create([
        'password' => $password, // Model hashes it automatically
    ]);

    Livewire::test(LoginWidget::class)
        ->set('data.email', $user->email)
        ->set('data.password', $password)
        ->call('login')
        ->assertHasNoErrors();

    $this->assertAuthenticatedAs($user);
});

it('user cannot login with invalid password', function () {
    $user = User::factory()->create([
        'password' => 'correct-password', // Model hashes it automatically
    ]);

    Livewire::test(LoginWidget::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'wrong-password')
        ->call('login');

    $this->assertGuest();
});

it('user can create account with valid data', function () {
    $email = 'john.'.uniqid().'@example.com';
    $password = 'Password123!@#';

    // XotBaseWidget needs data to be initialized
    Livewire::test(RegisterWidget::class)
        ->set('data.first_name', 'John')
        ->set('data.last_name', 'Doe')
        ->set('data.email', $email)
        ->set('data.password', $password)
        ->set('data.password_confirmation', $password)
        ->call('submit');

    // Verification check - direct DB check as redirect might fail in test
    $this->assertDatabaseHas('users', ['email' => $email], 'user');
});

it('registration fails with weak password', function () {
    Livewire::test(RegisterWidget::class)
        ->set('data.first_name', 'John')
        ->set('data.last_name', 'Doe')
        ->set('data.email', 'test@example.com')
        ->set('data.password', 'weak')
        ->set('data.password_confirmation', 'weak')
        ->call('submit')
        ->assertHasErrors(['data.password']);
});

it('authenticated user is redirected from login page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/it/auth/login');

    $response->assertRedirect();
});
