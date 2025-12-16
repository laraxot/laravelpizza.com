<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

test('password can be updated', function (): void {
<<<<<<< HEAD
    $user = User::factory()->create([
=======
    $xotData = XotData::make();
    $userClass = $xotData->getUserClass();

    $user = $userClass::factory()->create([
>>>>>>> 1810cfd (.)
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    $response = Volt::test('settings.password')
        ->set('current_password', 'password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $response->assertHasNoErrors();

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

<<<<<<< HEAD
test('correct password must be provided to update password', function (): void {
    $user = User::factory()->create([
=======
test('current password must be correct', function (): void {
    $xotData = XotData::make();
    $userClass = $xotData->getUserClass();

    $user = $userClass::factory()->create([
>>>>>>> 1810cfd (.)
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    $response = Volt::test('settings.password')
        ->set('current_password', 'wrong-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $response->assertHasErrors(['current_password']);
});
