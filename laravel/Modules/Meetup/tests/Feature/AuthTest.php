<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Tests\TestCase;
use function Pest\Laravel\get;

uses(TestCase::class);

test('login route is accessible and has correct UI', function () {
    $this->get('/it/auth/login')
        ->assertStatus(200)
        ->assertSee('Accedi al tuo account')
        ->assertSee('Oppure');
});


test('register route is accessible and has correct UI', function () {
    $response = $this->get('/it/auth/register');
    $response->assertStatus(200);
    $response->assertSee('Registrati');
    $response->assertDontSee('Sign up');
    $response->assertSee('Nome');
    $response->assertSee('Cognome');
    $response->assertSee('Indirizzo Email');
    $response->assertSee('Password');
    $response->assertSee('Conferma Password');
});
