<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

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
    $this->app->register(\Filament\Schemas\SchemasServiceProvider::class);
    Filament::setCurrentPanel(Filament::getPanel('user::admin'));
});

test('can change profile password', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'password' => Hash::make('old_password'),
    ]);

    actingAs($user);

    Livewire::test(MyProfilePage::class)
        ->fill([
            'passwordData.current_password' => 'old_password',
            'passwordData.new_password' => 'new_password',
            'passwordData.password_confirmation' => 'new_password',
        ])
        ->call('updatePassword')
        ->assertHasNoFormErrors();

    expect(Hash::check('new_password', $user->fresh()?->password))->toBeTrue();
});

test('cannot change password with wrong current password', function (): void {
    /** @var User $user */
    $user = User::factory()->create([
        'password' => Hash::make('old_password'),
    ]);

    actingAs($user);

    $testable = Livewire::test(MyProfilePage::class)
        ->fill([
            'passwordData.current_password' => 'wrong_password',
            'passwordData.new_password' => 'new_password',
            'passwordData.password_confirmation' => 'new_password',
        ])
        ->call('updatePassword');

    $testable->assertHasErrors();

    expect(collect($testable->errors()->keys())->contains(fn ($key) => str_contains($key, 'current_password')))->toBeTrue();

    expect(Hash::check('old_password', $user->fresh()?->password))->toBeTrue();
});
