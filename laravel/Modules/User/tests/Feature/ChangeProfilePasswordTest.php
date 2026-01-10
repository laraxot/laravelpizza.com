<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Modules\User\Filament\Pages\MyProfilePage;
use Modules\User\Models\User;
use Modules\User\Providers\Filament\AdminPanelProvider;
use Modules\User\Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(TestCase::class);

beforeEach(function (): void {
    $this->app->register(AdminPanelProvider::class);
    Filament::setCurrentPanel(Filament::getPanel('user::admin'));
});

test('can change profile password', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('old_password'),
    ]);

    actingAs($user);

    Livewire::test(MyProfilePage::class)
        ->fillForm([
            'Current password' => 'old_password',
            'new_password' => 'new_password',
            'passwordConfirmation' => 'new_password',
        ], 'editPasswordForm')
        ->call('updatePassword')
        ->assertHasNoFormErrors();

    expect(Hash::check('new_password', $user->fresh()?->password))->toBeTrue();
});

test('cannot change password with wrong current password', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('old_password'),
    ]);

    actingAs($user);

    Livewire::test(MyProfilePage::class)
        ->fillForm([
            'Current password' => 'wrong_password',
            'new_password' => 'new_password',
            'passwordConfirmation' => 'new_password',
        ], 'editPasswordForm')
        ->call('updatePassword')
        ->assertHasFormErrors(['Current password' => 'current_password'], 'editPasswordForm');

    expect(Hash::check('old_password', $user->fresh()?->password))->toBeTrue();
});
