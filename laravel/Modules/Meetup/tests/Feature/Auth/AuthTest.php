<?php

declare(strict_types=1);

use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

it('login page loads successfully', function () {
    $response = $this->get('/it/auth/login');

    $response->assertStatus(200);
});

it('login page contains required form elements', function () {
    $response = $this->get('/it/auth/login');

    $response->assertStatus(200);
    $response->assertSee('type="email"');
    $response->assertSee('type="password"');
});

it('login page shows register link', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    $response->assertSee(route('login'));
});

it('register page loads successfully', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
});

it('register page contains all required fields', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    $response->assertSee('type="email"');
    $response->assertSee('type="password"');
});

it('register page shows privacy consent checkbox', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    $response->assertSee('privacy_accepted');
});

it('register page shows terms consent checkbox', function () {
    $response = $this->get('/it/auth/register');

    $response->assertStatus(200);
    $response->assertSee('terms_accepted');
});

it('user can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/it/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
});

it('user cannot login with invalid password', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/it/auth/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors();
    $this->assertGuest();
});

it('user can create account with valid data', function () {
    $response = $this->post('/it/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => 'true',
        'terms_accepted' => 'true',
    ]);

    $response->assertRedirect('/');
});

it('registration fails without email', function () {
    $response = $this->post('/it/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => 'true',
        'terms_accepted' => 'true',
    ]);

    $response->assertSessionHasErrors(['email']);
});

it('registration fails without privacy consent', function () {
    $response = $this->post('/it/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'privacy_accepted' => 'false',
        'terms_accepted' => 'true',
    ]);

    $response->assertSessionHasErrors(['privacy_accepted']);
});

it('registration fails without terms consent', function () {
    $response = $this->post('/it/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password123!',
        'password_confirmation' => 'password123!',
        'privacy_accepted' => 'true',
        'terms_accepted' => 'false',
    ]);

    $response->assertSessionHasErrors(['terms_accepted']);
});

it('authenticated user is redirected from login page', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($user)
        ->get('/it/auth/login');

    $response->assertRedirect('/');
});

it('logout redirects to login page', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($user)
        ->post('/logout');

    $response->assertRedirect('/it/auth/login');
});
