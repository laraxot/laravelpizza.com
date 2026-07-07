<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Modules\Cms\Tests\TestCase;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

use function Safe\class_implements;

uses(TestCase::class);
test('widget can be rendered', function (): void {
    $component = Livewire::test(LoginWidget::class);
    /* @var Testable<\Livewire\Component> $component */
    $component->assertStatus(200);
});

test('widget initializes correctly', function (): void {
    $component = Livewire::test(LoginWidget::class);
    /* @var Testable<\Livewire\Component> $component */
    $component
        ->assertSet('data.remember', false)
        ->assertSet('data.email', null)
        ->assertSet('data.password', null);
});

test('can set form data', function (): void {
    $component = Livewire::test(LoginWidget::class);
    /* @var Testable<\Livewire\Component> $component */
    $component->set('data.email', 'test@example.com')->set('data.password', 'password123');
    $component->assertSet('data.email', 'test@example.com')->assertSet('data.password', 'password123');
});

test('authenticates user with valid credentials', function (): void {
    $email = TestCase::pestGenerateUniqueEmail();
    TestCase::pestCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);
    cmsAssertGuest();

    $component = Livewire::test(LoginWidget::class);
    /* @var Testable<\Livewire\Component> $component */
    $component->set('data.email', $email)->set('data.password', 'password123')->call('save');

    cmsAssertAuthenticated();

    $authenticatedUser = Auth::user();
    Assert::assertNotNull($authenticatedUser);
    Assert::assertSame($email, $authenticatedUser->email);
});

test('handles invalid credentials gracefully', function (): void {
    $email = TestCase::pestGenerateUniqueEmail();
    TestCase::pestCreateTestUser([
        'email' => $email,
        'password' => Hash::make('correct_password'),
    ]);
    cmsAssertGuest();

    $component = Livewire::test(LoginWidget::class);
    /* @var Testable<\Livewire\Component> $component */
    $component->set('data.email', $email)->set('data.password', 'wrong_password')->call('save');

    cmsAssertGuest();
});

test('authentication works regardless of user type', function (): void {
    $email = TestCase::pestGenerateUniqueEmail();
    TestCase::pestCreateTestUser([
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);
    cmsAssertGuest();

    $component = Livewire::test(LoginWidget::class);
    /* @var Testable<\Livewire\Component> $component */
    $component->set('data.email', $email)->set('data.password', 'password123')->call('save');

    cmsAssertAuthenticated();

    $authenticatedUser = Auth::user();
    /** @var class-string<object> $userClass */
    $userClass = XotData::make()->getUserClass();
    Assert::assertInstanceOf($userClass, $authenticatedUser);
    Assert::assertSame($email, $authenticatedUser->email);
});

test('getUserClass returns valid class', function (): void {
    /** @var class-string<object> $userClass */
    $userClass = XotData::make()->getUserClass();

    Assert::assertTrue(class_exists($userClass));

    $interfaces = class_implements($userClass);
    Assert::assertNotFalse($interfaces);
    Assert::assertContains(UserContract::class, $interfaces);
});

test('createTestUser creates valid instances', function (): void {
    $user = TestCase::pestCreateTestUser();
    /** @var class-string<Illuminate\Database\Eloquent\Model&UserContract> $userClass */
    $userClass = XotData::make()->getUserClass();
    $foundUser = $userClass::query()->where('email', $user->email)->first();
    Assert::assertInstanceOf(UserContract::class, $foundUser);
    Assert::assertSame($user->email, $foundUser->email);
});
