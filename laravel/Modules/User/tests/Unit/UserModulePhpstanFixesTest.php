<?php

declare(strict_types=1);

use Illuminate\Validation\Rules\Password;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\AddingTeam;
use Modules\User\Events\Login;
use Modules\User\Events\Registered;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Models\SocialiteUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

it('password data can be instantiated', function (): void {
    $passwordData = new PasswordData();

    $this->assertInstanceOf(PasswordData::class, $passwordData);
    $this->assertSame(5, $passwordData->otp_expiration_minutes);
    $this->assertSame(6, $passwordData->otp_length);
    $this->assertSame(60, $passwordData->expires_in);
    $this->assertSame(8, $passwordData->min);
    $this->assertTrue($passwordData->mixedCase);
    $this->assertTrue($passwordData->letters);
    $this->assertTrue($passwordData->numbers);
    $this->assertTrue($passwordData->symbols);
    $this->assertTrue($passwordData->uncompromised);
    $this->assertSame(0, $passwordData->compromisedThreshold);
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

    $this->assertSame(30, $passwordData->otp_expiration_minutes);
    $this->assertSame(8, $passwordData->otp_length);
    $this->assertSame(60, $passwordData->expires_in);
    $this->assertSame(8, $passwordData->min);
    $this->assertTrue($passwordData->mixedCase);
    $this->assertTrue($passwordData->letters);
    $this->assertTrue($passwordData->numbers);
    $this->assertTrue($passwordData->symbols);
    $this->assertTrue($passwordData->uncompromised);
    $this->assertSame(5, $passwordData->compromisedThreshold);
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

    $this->assertInstanceOf(Password::class, $rule);
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

    $this->assertIsString($helperText);
    $this->assertStringContainsString('8 caratteri', $helperText);
    $this->assertStringContainsString('maiuscola e una minuscola', $helperText);
    $this->assertStringContainsString('lettera', $helperText);
    $this->assertStringContainsString('numero', $helperText);
    $this->assertStringContainsString('carattere speciale', $helperText);
    $this->assertStringContainsString('compromessa', $helperText);
});

it('password data get form components returns array', function (): void {
    $passwordData = new PasswordData();

    // Smoke tests: methods should be callable without throwing.
    $passwordData->getPasswordFormComponent('password');
    $passwordData->setFieldName('password');
    $passwordData->getPasswordConfirmationFormComponent();
});

it('events can be instantiated', function (): void {
    $userFactory = User::factory();
    \assert($userFactory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $owner = $userFactory->create();
    \assert($owner instanceof User);

    $socialiteFactory = SocialiteUser::factory();
    \assert($socialiteFactory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $socialiteUser = $socialiteFactory->create();
    \assert($socialiteUser instanceof SocialiteUser);

    $addingTeam = new AddingTeam($owner);
    $login = new Login($socialiteUser);
    $registered = new Registered($socialiteUser);
    $socialiteUserConnected = new SocialiteUserConnected($socialiteUser);

    $this->assertInstanceOf(AddingTeam::class, $addingTeam);
    $this->assertInstanceOf(Login::class, $login);
    $this->assertInstanceOf(Registered::class, $registered);
    $this->assertInstanceOf(SocialiteUserConnected::class, $socialiteUserConnected);
});

it('events have dispatchable trait', function (): void {
    $userFactory = User::factory();
    \assert($userFactory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $owner = $userFactory->create();
    \assert($owner instanceof User);

    $socialiteFactory = SocialiteUser::factory();
    \assert($socialiteFactory instanceof Illuminate\Database\Eloquent\Factories\Factory);
    $socialiteUser = $socialiteFactory->create();
    \assert($socialiteUser instanceof SocialiteUser);

    // Smoke: calling dispatch should not error.
    AddingTeam::dispatch($owner);
    Login::dispatch($socialiteUser);
});

it('password data static make method exists', function (): void {
    $passwordData = PasswordData::make();
    $this->assertInstanceOf(PasswordData::class, $passwordData);
});

it('password data get validation messages method exists', function (): void {
    $passwordData = new PasswordData();

    $messages = $passwordData->getValidationMessages();
    $this->assertIsArray($messages);
});

it('password data get form schema method exists', function (): void {
    $schema = PasswordData::getFormSchema();
    $this->assertIsArray($schema);
});
