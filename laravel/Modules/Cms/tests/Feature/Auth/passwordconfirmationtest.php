<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(TestCase::class);

test('confirm password screen can be rendered', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $lang = app()->getLocale();
    $response = actingAs($user)->get('/'.$lang.'/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'password')->call('confirmPassword');

    $response->assertHasNoErrors()->assertRedirect(route('dashboard', absolute: false));
});

test('password is not confirmed with invalid password', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'wrong-password')->call('confirmPassword');

    $response->assertHasErrors(['password']);
});
