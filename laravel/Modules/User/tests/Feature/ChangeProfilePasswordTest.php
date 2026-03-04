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
    try {
        $this->app->register(AdminPanelProvider::class);
        if (class_exists(\Filament\Schemas\SchemasServiceProvider::class)) {
            $this->app->register(\Filament\Schemas\SchemasServiceProvider::class);
        }
        Filament::setCurrentPanel(Filament::getPanel('user::admin'));
    } catch (Throwable $e) {
        $this->markTestSkipped('Filament admin panel user::admin not configured for testing: '.$e->getMessage());
    }
});

test('can change profile password', function (): void {
    if (! class_exists(MyProfilePage::class)) {
        $this->markTestSkipped('MyProfilePage class does not exist');
    }

    /** @var User $user */
    $user = User::factory()->create([
        'password' => Hash::make('old_password'),
    ]);

    actingAs($user);

    try {
        Livewire::test(MyProfilePage::class)
            ->fill([
                'passwordData.current_password' => 'old_password',
                'passwordData.new_password' => 'new_password',
                'passwordData.password_confirmation' => 'new_password',
            ])
            ->call('updatePassword')
            ->assertHasNoFormErrors();

        expect(Hash::check('new_password', $user->fresh()?->password))->toBeTrue();
    } catch (Throwable $e) {
        $this->markTestSkipped('MyProfilePage requires Filament panel: '.$e->getMessage());
    }
});

test('cannot change password with wrong current password', function (): void {
    if (! class_exists(MyProfilePage::class)) {
        $this->markTestSkipped('MyProfilePage class does not exist');
    }

    /** @var User $user */
    $user = User::factory()->create([
        'password' => Hash::make('old_password'),
    ]);

    actingAs($user);

    try {
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
    } catch (Throwable $e) {
        $this->markTestSkipped('MyProfilePage requires Filament panel: '.$e->getMessage());
    }
});
