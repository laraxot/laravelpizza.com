<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    DB::connection('user')->table('profiles')->insert([
        'id' => (string) Str::uuid(),
        'user_id' => $user->id,
        'type' => null,
        'first_name' => 'Ada',
        'last_name' => 'Lovelace',
        'user_name' => 'ada-lovelace',
        'email' => $user->email,
        'phone' => null,
        'address' => null,
        'birth_date' => null,
        'gender' => null,
        'bio' => 'Speaker and community organizer.',
        'avatar' => null,
        'timezone' => null,
        'locale' => 'en',
        'preferences' => null,
        'status' => 'active',
        'is_active' => true,
        'extra' => null,
        'created_at' => now(),
        'updated_at' => now(),
        'deleted_at' => null,
        'created_by' => null,
        'updated_by' => null,
        'deleted_by' => null,
    ]);

    $this->get('/en/profile/'.$user->getRouteKey())
        ->assertOk()
        ->assertSee('Ada Lovelace')
        ->assertSee('Speaker and community organizer.')
        ->assertDontSee('No event found');
});
