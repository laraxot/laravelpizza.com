<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Filament\Facades\Filament;
use Filament\Schemas\SchemasServiceProvider;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Filament\Pages\MyProfilePage;
use Modules\User\Providers\Filament\AdminPanelProvider;
use Modules\User\Tests\TestCase;

use function Pest\Laravel\actingAs;

use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    $this->skipUnlessUsersTableReady();
    $this->skipUnlessUserColumn('profiles', 'uuid', 'profiles.uuid column is not available in the test database.');

    app()->register(AdminPanelProvider::class);
    app()->register(SchemasServiceProvider::class);
    Filament::setCurrentPanel(Filament::getPanel('user::admin'));
});

describe('Change Profile Password', function (): void {
    test('can change profile password', function (): void {
        $user = UserFactory::new()->createOne([
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

        Assert::assertTrue(Hash::check('new_password', (string) $user->fresh()?->password));
    });

    test('cannot change password with wrong current password', function (): void {
        $user = UserFactory::new()->createOne([
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

        $errors = $testable->errors();
        Assert::assertIsArray($errors);
        $hasCurrentPasswordError = false;
        foreach (array_keys($errors) as $errorKey) {
            if (str_contains((string) $errorKey, 'current_password')) {
                $hasCurrentPasswordError = true;
                break;
            }
        }
        Assert::assertTrue($hasCurrentPasswordError);
        Assert::assertTrue(Hash::check('old_password', (string) $user->fresh()?->password));
    });
});
