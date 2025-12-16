<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(TestCase::class);

<<<<<<< HEAD
test('confirm password screen can be rendered', function (): void {
    /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
    $userClass = XotData::make()->getUserClass();
    /** @var \Illuminate\Contracts\Auth\Authenticatable&\Illuminate\Database\Eloquent\Model $user */
=======
test('confirm password page can be rendered', function (): void {
    $xotData = XotData::make();
    $userClass = $xotData->getUserClass();
<<<<<<< HEAD
    
>>>>>>> 1810cfd (.)
=======

>>>>>>> 46d657c (.)
    $user = $userClass::factory()->create();

    $lang = app()->getLocale();
    $response = actingAs($user)->get('/'.$lang.'/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function (): void {
<<<<<<< HEAD
    /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
    $userClass = XotData::make()->getUserClass();
    /** @var \Illuminate\Contracts\Auth\Authenticatable&\Illuminate\Database\Eloquent\Model $user */
=======
    $xotData = XotData::make();
    $userClass = $xotData->getUserClass();
<<<<<<< HEAD
    
>>>>>>> 1810cfd (.)
=======

>>>>>>> 46d657c (.)
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'password')->call('confirmPassword');

    $response->assertHasNoErrors()->assertRedirect(route('dashboard', absolute: false));
});

test('password is not confirmed with invalid password', function (): void {
<<<<<<< HEAD
    /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
    $userClass = XotData::make()->getUserClass();
    /** @var \Illuminate\Contracts\Auth\Authenticatable&\Illuminate\Database\Eloquent\Model $user */
=======
    $xotData = XotData::make();
    $userClass = $xotData->getUserClass();
<<<<<<< HEAD
    
>>>>>>> 1810cfd (.)
=======

>>>>>>> 46d657c (.)
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')->set('password', 'wrong-password')->call('confirmPassword');

    $response->assertHasErrors(['password']);
});
