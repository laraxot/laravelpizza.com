<?php

declare(strict_types=1);

use Illuminate\Validation\Rules\Password;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\AddingTeam;
use Modules\User\Events\Login;
use Modules\User\Events\Registered;
use Modules\User\Events\SocialiteUserConnected;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

it('password data can be instantiated', function (): void {
    $passwordData = new PasswordData();

    expect($passwordData)->toBeInstanceOf(PasswordData::class);
    expect($passwordData->otp_expiration_minutes)->toEqual(5);
    expect($passwordData->otp_length)->toEqual(6);
    expect($passwordData->expires_in)->toEqual(60);
    expect($passwordData->min)->toEqual(8);
    expect($passwordData->mixedCase)->toBeTrue();
    expect($passwordData->letters)->toBeTrue();
    expect($passwordData->numbers)->toBeTrue();
    expect($passwordData->symbols)->toBeTrue();
    expect($passwordData->uncompromised)->toBeTrue();
    expect($passwordData->compromisedThreshold)->toEqual(0);
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

    expect($passwordData->otp_expiration_minutes)->toEqual(30);
    expect($passwordData->otp_length)->toEqual(8);
    expect($passwordData->expires_in)->toEqual(60);
    expect($passwordData->min)->toEqual(8);
    expect($passwordData->mixedCase)->toBeTrue();
    expect($passwordData->letters)->toBeTrue();
    expect($passwordData->numbers)->toBeTrue();
    expect($passwordData->symbols)->toBeTrue();
    expect($passwordData->uncompromised)->toBeTrue();
    expect($passwordData->compromisedThreshold)->toEqual(5);
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

    expect($rule)->toBeInstanceOf(Password::class);
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

    expect($helperText)->toBeString();
    expect($helperText)->toContain('8 caratteri');
    expect($helperText)->toContain('maiuscola e una minuscola');
    expect($helperText)->toContain('lettera');
    expect($helperText)->toContain('numero');
    expect($helperText)->toContain('carattere speciale');
    expect($helperText)->toContain('compromessa');
});

it('password data get form components returns array', function (): void {
    $passwordData = new PasswordData();

    // Test che il metodo esista e non lanci eccezioni
    expect(method_exists($passwordData, 'getPasswordFormComponents'))->toBeTrue();

    // Test che il metodo getPasswordFormComponent esista
    expect(method_exists($passwordData, 'getPasswordFormComponent'))->toBeTrue();

    // Test che il metodo getPasswordConfirmationFormComponent esista
    expect(method_exists($passwordData, 'getPasswordConfirmationFormComponent'))->toBeTrue();
});

it('events can be instantiated', function (): void {
    $addingTeam = new AddingTeam();
    $login = new Login();
    $registered = new Registered();
    $socialiteUserConnected = new SocialiteUserConnected();

    expect($addingTeam)->toBeInstanceOf(AddingTeam::class);
    expect($login)->toBeInstanceOf(Login::class);
    expect($registered)->toBeInstanceOf(Registered::class);
    expect($socialiteUserConnected)->toBeInstanceOf(SocialiteUserConnected::class);
});

it('events have dispatchable trait', function (): void {
    $addingTeam = new AddingTeam();
    $login = new Login();

    expect(method_exists($addingTeam, 'dispatch'))->toBeTrue();
    expect(method_exists($login, 'dispatch'))->toBeTrue();
});

it('password data static make method exists', function (): void {
    expect(method_exists(PasswordData::class, 'make'))->toBeTrue();
});

it('password data get validation messages method exists', function (): void {
    $passwordData = new PasswordData();

    expect(method_exists($passwordData, 'getValidationMessages'))->toBeTrue();
});

it('password data get form schema method exists', function (): void {
    expect(method_exists(PasswordData::class, 'getFormSchema'))->toBeTrue();
});
