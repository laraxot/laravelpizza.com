<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt as LivewireVolt;

use function Pest\Laravel\actingAs;

test('confirm password screen can be rendered', function () {
    $user = cmsCreateTestUser(['password' => Hash::make('password')]);

    actingAs($user);
    $lang = app()->getLocale();
    $response = $this->get('/'.$lang.'/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = cmsCreateTestUser(['password' => Hash::make('password')]);

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'password')->call('confirmPassword');

    $response->assertHasNoErrors();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('password is not confirmed with invalid password', function () {
    $user = cmsCreateTestUser(['password' => Hash::make('password')]);

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'wrong-password')->call('confirmPassword');

    $response->assertHasErrors(['password']);
});
