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
    $this->get('/it/auth/register')
        ->assertStatus(200)
        ->assertSee('Registrati')
        ->assertDontSee('Sign up');
});
