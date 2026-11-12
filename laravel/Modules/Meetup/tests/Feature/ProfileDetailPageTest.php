<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('localized public profile page renders from dynamic profile identifier route', function (): void {
    $user = User::factory()->create([
        'name' => 'Profile Public Test',
        'email' => 'profile-public-'.uniqid().'@example.com',
    ]);

    $this->get('/it/profile/'.$user->getRouteKey())
        ->assertOk()
        ->assertSee('Profile Public Test')
        ->assertDontSee('Nessun evento trovato')
        ->assertDontSee('Undefined variable');
});

test('localized public profile page shows profile bio when related user profile exists', function (): void {
    $user = User::factory()->create([
        'name' => 'Ada Lovelace',
        'email' => 'ada-lovelace-'.uniqid().'@example.com',
    ]);

    // Il profilo dell'app è Modules\Meetup\Models\Profile (xra.main_module = Meetup), sul database dati.
    $user->profile()->create([
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'email' => $user->email,
        'bio' => 'Speaker and community organizer.',
        'locale' => 'en',
    ]);

    $this->get('/en/profile/'.$user->getRouteKey())
        ->assertOk()
        ->assertSee('Ada Lovelace')
        ->assertSee('Speaker and community organizer.')
        ->assertDontSee('No event found');
});
