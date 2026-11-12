<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('header renders correct navigation items for guests', function (): void {
    $this->get('/it')
        ->assertStatus(200)
        ->assertSee('Home')
        ->assertSee('Accedi')
        ->assertSee('Registrati')
        ->assertDontSee('Dashboard');
});

test('header renders avatar dropdown for authenticated users', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/it');

    // La "Dashboard" pubblica non esiste più: l'area personale è "I miei eventi".
    $response->assertStatus(200)
        ->assertSee('I miei eventi')
        ->assertSee('Tutti gli eventi')
        ->assertSee('Profilo')
        ->assertSee('Esci')
        ->assertDontSee('Accedi')
        ->assertDontSee('Registrati');
});
