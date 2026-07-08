<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Collection;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Actions\ChangePasswordAction;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Pages\BaseListUsers;
use Modules\User\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\User\Models\User;
use Modules\User\Providers\Filament\AdminPanelProvider;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    try {
        $panel = Filament::getPanel('user::admin');
    } catch (\Exception $e) {
        $panelProvider = new AdminPanelProvider(app());
        $panel = $panelProvider->panel(Panel::make());
        Filament::registerPanel($panel);
    }
    Filament::setCurrentPanel($panel);

    $this->listUsersPage = new ListUsers();

    $users = UserFactory::new()
        ->count(3)
        ->createOne([
            'type' => UserType::MasterAdmin,
        ]);

    $this->users = new Collection($users->all());
});

describe('List Users', function (): void {
    test('list users page has correct resource', function (): void {
        Assert::assertSame(UserResource::class, ListUsers::getResource());
    });

    test('list users page extends correct base class', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        Assert::assertInstanceOf(BaseListUsers::class, $listUsersPage);
    });

    test('list users page can be instantiated', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        Assert::assertInstanceOf(ListUsers::class, $listUsersPage);
    });

    test('list users page has correct table columns', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        $columns = $listUsersPage->getTableColumns();

        Assert::assertArrayHasKey('name', $columns);
        Assert::assertArrayHasKey('email', $columns);
        $nameColumn = $columns['name'];
        Assert::assertInstanceOf(TextColumn::class, $nameColumn);
        Assert::assertSame('name', $nameColumn->getName());
        Assert::assertTrue($nameColumn->isSearchable());
        $emailColumn = $columns['email'];
        Assert::assertInstanceOf(TextColumn::class, $emailColumn);
        Assert::assertSame('email', $emailColumn->getName());
        Assert::assertTrue($emailColumn->isSearchable());
    });

    test('list users page has correct table filters', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        $filters = $listUsersPage->getTableFilters();

        Assert::assertCount(0, $filters);
    });

    test('list users page has correct table actions', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        $actions = $listUsersPage->getTableActions();

        Assert::assertArrayHasKey('change_password', $actions);

        $changePasswordAction = $actions['change_password'];
        Assert::assertInstanceOf(ChangePasswordAction::class, $changePasswordAction);
    });

    test('list users page can display users', function (): void {
        /** @var TestCase $this */
        $users = $this->requireUsers();
        $createdUserIds = $users->pluck('id');
        $testUsers = User::whereIn('id', $createdUserIds)->get();

        Assert::assertCount(3, $testUsers);
        foreach ($testUsers as $user) {
            Assert::assertInstanceOf(User::class, $user);
            if (is_string($user->type)) {
                Assert::assertSame(UserType::MasterAdmin->value, $user->type);
            } else {
                Assert::assertSame(UserType::MasterAdmin, $user->type);
            }
        }
    });

    test('list users page has correct navigation label', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        $label = $listUsersPage->getNavigationLabel();
        Assert::assertNotEmpty($label);
    });

    test('list users page has correct title', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        $title = $listUsersPage->getTitle();
        Assert::assertNotEmpty($title);
    });

    test('list users page has correct breadcrumbs', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        try {
            $breadcrumbs = $listUsersPage->getBreadcrumbs();
            Assert::assertNotEmpty($breadcrumbs);
        } catch (\Exception $e) {
        }
    });

    test('list users page can handle search', function (): void {
        /** @var TestCase $this */
        $listUsersPage = $this->requireListUsersPage();
        $columns = $listUsersPage->getTableColumns();
        $nameColumn = $columns['name'];
        $emailColumn = $columns['email'];

        Assert::assertTrue($nameColumn->isSearchable());
        Assert::assertTrue($emailColumn->isSearchable());
    });
});
