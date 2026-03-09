<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('login route is accessible and has correct UI', function () {
    $response = $this->get('/it/auth/login');
    $response->assertStatus(200)
        ->assertSee('Accedi')
        ->assertSee('Email')
        ->assertSee('Password');
});

test('register route is accessible and has correct UI', function () {
    $response = $this->get('/it/auth/register');
    $response->assertStatus(200);
    $response->assertSee('Registrati');
    $response->assertDontSee('Sign up');
    $response->assertSee('Nome');
    $response->assertSee('Cognome');
    $response->assertSee('Email');
    $response->assertSee('Password');
});
