<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Password;
use Modules\User\Database\Factories\SocialiteUserFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\AddingTeam;
use Modules\User\Events\Login;
use Modules\User\Events\Registered;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('password data can be instantiated', function (): void {
    $passwordData = new PasswordData();

    Assert::assertInstanceOf(PasswordData::class, $passwordData);
    Assert::assertSame(5, $passwordData->otp_expiration_minutes);
    Assert::assertSame(6, $passwordData->otp_length);
    Assert::assertSame(60, $passwordData->expires_in);
    Assert::assertSame(8, $passwordData->min);
    Assert::assertTrue($passwordData->mixedCase);
    Assert::assertTrue($passwordData->letters);
    Assert::assertTrue($passwordData->numbers);
    Assert::assertTrue($passwordData->symbols);
    Assert::assertTrue($passwordData->uncompromised);
    Assert::assertSame(0, $passwordData->compromisedThreshold);
});

it('password data can be configured', function (): void {
    $passwordData = new PasswordData(
        otp_expiration_minutes: 30,
        otp_length: 8,
        expires_in: 60,
        min: 8,
        mixedCase: true,
        letters: true,
        numbers: true,
        symbols: true,
        uncompromised: true,
        compromisedThreshold: 5
    );

    Assert::assertSame(30, $passwordData->otp_expiration_minutes);
    Assert::assertSame(8, $passwordData->otp_length);
    Assert::assertSame(60, $passwordData->expires_in);
    Assert::assertSame(8, $passwordData->min);
    Assert::assertTrue($passwordData->mixedCase);
    Assert::assertTrue($passwordData->letters);
    Assert::assertTrue($passwordData->numbers);
    Assert::assertTrue($passwordData->symbols);
    Assert::assertTrue($passwordData->uncompromised);
    Assert::assertSame(5, $passwordData->compromisedThreshold);
});

it('password data get password rule works', function (): void {
    $passwordData = new PasswordData(
        min: 8,
        mixedCase: true,
        letters: true,
        numbers: true,
        symbols: true,
        uncompromised: true,
        compromisedThreshold: 3
    );

    $rule = $passwordData->getPasswordRule();

    Assert::assertInstanceOf(Password::class, $rule);
});

it('password data get helper text works', function (): void {
    $passwordData = new PasswordData(
        min: 8,
        mixedCase: true,
        letters: true,
        numbers: true,
        symbols: true,
        uncompromised: true
    );

    $helperText = $passwordData->getHelperText();

    Assert::assertStringContainsString('8 caratteri', $helperText);
    Assert::assertStringContainsString('maiuscola e una minuscola', $helperText);
    Assert::assertStringContainsString('lettera', $helperText);
    Assert::assertStringContainsString('numero', $helperText);
    Assert::assertStringContainsString('carattere speciale', $helperText);
    Assert::assertStringContainsString('compromessa', $helperText);
});

it('password data get form components returns array', function (): void {
    $passwordData = new PasswordData();

    // Smoke tests: methods should be callable without throwing.
    $passwordData->getPasswordFormComponent('password');
    $passwordData->setFieldName('password');
    $passwordData->getPasswordConfirmationFormComponent();
});

it('events can be instantiated', function (): void {
    $userFactory = UserFactory::new();
    \assert($userFactory instanceof Factory);
    $owner = $userFactory->createOne();
    \assert($owner instanceof User);

    $socialiteFactory = SocialiteUserFactory::new();
    \assert($socialiteFactory instanceof Factory);
    $socialiteUser = $socialiteFactory->createOne([
        'user_id' => (string) $owner->getKey(),
        'provider' => 'github',
        'provider_id' => 'provider-'.uniqid(),
    ]);
    \assert($socialiteUser instanceof SocialiteUser);

    $addingTeam = new AddingTeam($owner);
    $login = new Login($socialiteUser);
    $registered = new Registered($socialiteUser);
    $socialiteUserConnected = new SocialiteUserConnected($socialiteUser);

    Assert::assertInstanceOf(AddingTeam::class, $addingTeam);
    Assert::assertInstanceOf(Login::class, $login);
    Assert::assertInstanceOf(Registered::class, $registered);
    Assert::assertInstanceOf(SocialiteUserConnected::class, $socialiteUserConnected);
});

it('events have dispatchable trait', function (): void {
    $userFactory = UserFactory::new();
    \assert($userFactory instanceof Factory);
    $owner = $userFactory->createOne();
    \assert($owner instanceof User);

    $socialiteFactory = SocialiteUserFactory::new();
    \assert($socialiteFactory instanceof Factory);
    $socialiteUser = $socialiteFactory->createOne([
        'user_id' => (string) $owner->getKey(),
        'provider' => 'github',
        'provider_id' => 'provider-'.uniqid(),
    ]);
    \assert($socialiteUser instanceof SocialiteUser);

    // Smoke: calling dispatch should not error.
    AddingTeam::dispatch($owner);
    Login::dispatch($socialiteUser);
});

it('password data static make method exists', function (): void {
    $passwordData = PasswordData::make();
    Assert::assertInstanceOf(PasswordData::class, $passwordData);
});

it('password data get validation messages method exists', function (): void {
    $passwordData = new PasswordData();

    $passwordData->getValidationMessages();
});

it('password data get form schema method exists', function (): void {
    PasswordData::getFormSchema();
});
