<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('la pagina di login è accessibile', function () {
    get('/admin/login')->assertStatus(200)->assertSee('Login')->assertSee('Email')->assertSee('Password');
});

test('un utente può effettuare il login', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    post('/admin/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ])->assertRedirect('/admin');

    $this->assertAuthenticated();
});

test('un utente non può effettuare il login con credenziali errate', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    post('/admin/login', [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['email']);

    $this->assertGuest();
});

test('un utente non può accedere al pannello admin senza autenticazione', function () {
    get('/admin')->assertRedirect('/admin/login');
});

test('un utente autenticato può accedere al pannello admin', function () {
    $user = User::factory()->create();

    actingAs($user)->get('/admin')->assertStatus(200)->assertSee('Dashboard');
});
