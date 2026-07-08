<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament;

use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    $this->setupFilamentAdminPanel();

    $this->admin = UserFactory::new()->createOne([
        'type' => UserType::MasterAdmin,
        'name' => 'Admin Test',
        'email' => 'admin-'.uniqid('', true).'@example.com',
    ]);
    $this->user = UserFactory::new()->createOne([
        'name' => 'User Test',
        'email' => 'user-'.uniqid('', true).'@example.com',
    ]);

    $this->actingAs($this->requireAdmin());
});

describe('User Resource', function (): void {
    test('has correct model class', function (): void {
        Assert::assertSame(XotData::make()->getUserClass(), UserResource::getModel());
    });

    test('has correct slug', function (): void {
        Assert::assertSame('users', UserResource::getSlug());
    });

    test('has navigation configuration', function (): void {
        $navigationBadge = UserResource::getNavigationBadge();
        Assert::assertNotNull($navigationBadge);
    });

    test('can get navigation items', function (): void {
        $navigationItems = UserResource::getNavigationItems();
        Assert::assertNotEmpty($navigationItems);
    });

    test('list users page covered by dedicated test', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Livewire table UserResource richiede panel admin completo — coperto da Feature/Filament/Pages/ListUsersTest');
    });

    test('create user page covered by dedicated test', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Livewire create UserResource richiede panel admin completo — coperto da Feature/Filament/Pages/CreateUserTest');
    });

    test('edit user page covered by dedicated test', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Livewire edit UserResource richiede panel admin completo + policy');
    });

    test('view user page covered by dedicated test', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Livewire view UserResource richiede panel admin completo + policy');
    });

    test('bulk actions requires full admin panel', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Bulk actions UserResource richiedono panel admin completo + azioni registrate');
    });

    test('security covered by create user test', function (): void {
        /* @var TestCase $this */
        $this->skipTest('Security Livewire UserResource richiede panel admin completo — validazione coperta da CreateUserTest');
    });
});
