<?php

use Livewire\Volt\Volt;
use Modules\Xot\Datas\XotData;

test('login screen can be rendered', function () {
    // Ensure user is logged out first
    $this->assertGuest();
    
    // Main login route redirects to admin login
    $response = $this->get('/login');
    $response->assertRedirect('/admin/login');
    
    // Test admin login page directly
    $adminResponse = $this->get('/admin/login');
    $adminResponse->assertOk();
    $adminResponse->assertSee('Login');
});

test('users can authenticate using the login screen', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    // Test authentication via HTTP request instead of Volt component
    $response = $this->post('/admin/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(302)->assertRedirect('/admin');

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    // Test authentication via HTTP request
    $response = $this->post('/admin/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();

    $this->assertGuest();
});

test('navigation menu can be rendered', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $this->actingAs($user);

    // Test admin panel instead since dashboard route may not exist
    $response = $this->get('/admin');

    $response->assertOk();
});

test('users can logout', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $this->actingAs($user);

    // Test logout via route
    $response = $this->post('/logout');

    $response->assertRedirect('/home');

    $this->assertGuest();
});
