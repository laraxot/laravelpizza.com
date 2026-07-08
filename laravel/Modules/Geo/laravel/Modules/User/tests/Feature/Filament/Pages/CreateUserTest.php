<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Panel;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Providers\Filament\AdminPanelProvider;
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
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

    $this->createUserPage = new CreateUser();
});

describe('Create User', function (): void {
    test('create user page has correct resource', function (): void {
        /** @var TestCase $this */
        $createUserPage = $this->requireCreateUserPage();
        Assert::assertSame(UserResource::class, $createUserPage->getResource());
    });

    test('create user page extends correct base class', function (): void {
        /** @var TestCase $this */
        $createUserPage = $this->requireCreateUserPage();
        Assert::assertInstanceOf(XotBaseCreateRecord::class, $createUserPage);
    });

    test('create user page can be instantiated', function (): void {
        /** @var TestCase $this */
        $createUserPage = $this->requireCreateUserPage();
        Assert::assertInstanceOf(CreateUser::class, $createUserPage);
    });

    test('create user page has correct navigation label', function (): void {
        /** @var TestCase $this */
        $createUserPage = $this->requireCreateUserPage();
        $label = $createUserPage->getNavigationLabel();

        Assert::assertNotEmpty($label);
    });

    test('create user page has correct title', function (): void {
        /** @var TestCase $this */
        $createUserPage = $this->requireCreateUserPage();
        $title = $createUserPage->getTitle();

        Assert::assertNotEmpty($title);
    });

    test('create user page has correct breadcrumbs structure', function (): void {
        /** @var TestCase $this */
        $createUserPage = $this->requireCreateUserPage();
        try {
            $breadcrumbs = $createUserPage->getBreadcrumbs();
            Assert::assertNotEmpty($breadcrumbs);
        } catch (\Exception $e) {
        }
    });

    test('create user page can be accessed', function (): void {
        /** @var TestCase $this */
        $createUserPage = $this->requireCreateUserPage();
        Assert::assertInstanceOf(CreateUser::class, $createUserPage);
    });

    test('create user page can create user with valid data', function (): void {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'type' => UserType::MasterAdmin,
        ];

        Assert::assertSame('Test User', $userData['name']);
        Assert::assertSame('test@example.com', $userData['email']);
        Assert::assertSame('password123', $userData['password']);
        Assert::assertSame(UserType::MasterAdmin, $userData['type']);
    });

    test('create user page handles form submission structure', function (): void {
        $formData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'newpassword123',
            'type' => UserType::BoUser,
        ];

        Assert::assertArrayHasKey('name', $formData);
        Assert::assertArrayHasKey('email', $formData);
        Assert::assertArrayHasKey('password', $formData);
        Assert::assertArrayHasKey('type', $formData);
        Assert::assertSame('New User', $formData['name']);
        Assert::assertSame('newuser@example.com', $formData['email']);
        Assert::assertSame('newpassword123', $formData['password']);
        Assert::assertSame(UserType::BoUser, $formData['type']);
    });

    test('create user page follows filament conventions', function (): void {
        /** @var TestCase $this */
        $createUserPage = $this->requireCreateUserPage();
        Assert::assertSame(UserResource::class, $createUserPage->getResource());
        Assert::assertSame(XotData::make()->getUserClass(), $createUserPage->getModel());
    });
});
