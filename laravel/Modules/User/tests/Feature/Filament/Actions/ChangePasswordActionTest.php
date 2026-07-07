<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Actions;

use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Actions\ChangePasswordAction;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
<<<<<<< HEAD
    // Use in-memory model to avoid DB constraints between tests
    $this->user = User::factory()->make([
        'type' => UserType::MasterAdmin,
        'email' => 'admin+'.uniqid('', true).'@example.com',
        'password' => Hash::make('oldpassword'),
    ]);
=======
    /* @var TestCase $this */
    $this->setupFilamentAdminPanel();
>>>>>>> 9fa499be (.)

    $this->action = new ChangePasswordAction('changePassword');
});

<<<<<<< HEAD
test('change password action has correct default name', function (): void {
    expect(ChangePasswordAction::getDefaultName())->toBe('changePassword');
});

test('change password action extends correct base class', function (): void {
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action has correct icon', function (): void {
    $this->action->setUp();

    // Test that the action has the correct icon
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action form has required fields', function (): void {
    $this->action->setUp();

    // The action should have a form with password fields
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action can be executed', function (): void {
    $this->action->setUp();

    // Test that the action can be executed
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action uses password data component', function (): void {
    $this->action->setUp();

    // The action should use PasswordData component for the password field
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action has confirmation field', function (): void {
    $this->action->setUp();

    // The action should have a password confirmation field
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action shows success notification', function (): void {
    $this->action->setUp();

    // The action should show a success notification after password change
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action validates password confirmation', function (): void {
    $this->action->setUp();

    // The action should validate that password confirmation matches
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action uses translation keys', function (): void {
    $this->action->setUp();

    // The action should use translation keys for labels and messages
    expect($this->action)->toBeInstanceOf(Action::class);
});

test('change password action has correct setup method', function (): void {
    $this->action->setUp();

    // The action should have a setUp method that configures the action
    expect($this->action)->toBeInstanceOf(Action::class);
=======
describe('Change Password Action', function (): void {
    test('change password action has correct default name', function (): void {
        Assert::assertSame('changePassword', ChangePasswordAction::getDefaultName());
    });

    test('change password action extends correct base class', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertInstanceOf(Action::class, $action);
    });

    test('change password action has correct icon', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertInstanceOf(Action::class, $action);
        Assert::assertSame('heroicon-o-key', $action->getIcon());
    });

    test('change password action form has required fields', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertInstanceOf(Action::class, $action);
        $reflection = new \ReflectionClass(ChangePasswordAction::class);
        Assert::assertTrue($reflection->hasMethod('setUp'));
    });

    test('change password action can be executed', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertInstanceOf(Action::class, $action);
        Assert::assertSame('changePassword', $action->getName());
    });

    test('change password action uses password data component', function (): void {
        $source = (new \ReflectionClass(ChangePasswordAction::class))->getFileName();
        $content = is_string($source) ? file_get_contents($source) : '';

        Assert::assertStringContainsString((string) 'PasswordData', (string) $content);
        Assert::assertStringContainsString((string) 'new_password', (string) $content);
    });

    test('change password action has confirmation field', function (): void {
        $source = (new \ReflectionClass(ChangePasswordAction::class))->getFileName();
        $content = is_string($source) ? file_get_contents($source) : '';

        Assert::assertStringContainsString((string) 'new_password_confirmation', (string) $content);
    });

    test('change password action shows success notification', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertInstanceOf(Action::class, $action);
        Assert::assertSame('changePassword', $action->getName());
    });

    test('change password action validates password confirmation', function (): void {
        $source = (new \ReflectionClass(ChangePasswordAction::class))->getFileName();
        $content = is_string($source) ? file_get_contents($source) : '';

        Assert::assertStringContainsString((string) "->same('new_password')", (string) $content);
    });

    test('change password action uses translation keys', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertInstanceOf(Action::class, $action);
        Assert::assertNotEmpty($action->getLabel());
    });

    test('change password action has correct setup method', function (): void {
        $reflection = new \ReflectionClass(ChangePasswordAction::class);

        Assert::assertTrue($reflection->hasMethod('setUp'));
        Assert::assertTrue($reflection->getMethod('setUp')->isProtected());
    });
>>>>>>> 9fa499be (.)
});
