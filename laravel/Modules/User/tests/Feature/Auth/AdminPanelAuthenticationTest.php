<?php

declare(strict_types=1);

use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/*
 * Ingresso al pannello admin: la root e /home portano al pannello, il pannello
 * richiede login, il logout chiude la sessione. Spostato da laravel/tests
 * (story Xot/5.302): ogni test vive nella tests/ del modulo proprietario.
 */

test('root redirects to admin', function (): void {
    $this->get('/')->assertRedirect('/admin');
});

test('home redirects to admin', function (): void {
    $this->get('/home')->assertRedirect('/admin');
});

test('admin panel requires authentication', function (): void {
    $this->get('/admin')->assertRedirect('/admin/login');
});

test('admin login page exists', function (): void {
    $this->get('/admin/login')->assertOk();
});

test('users can logout', function (): void {
    $user = User::factory()->create();
    // Senza ruolo canAccessPanel('admin') e' false e Filament risponde 403 prima del logout.
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    $user->assignRole('admin');

    $this->actingAs($user);

    $this->post('/admin/logout')->assertRedirect('/admin/login');

    $this->assertGuest();
});
