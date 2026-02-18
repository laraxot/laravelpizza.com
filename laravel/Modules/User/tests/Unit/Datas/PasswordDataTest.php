<?php

declare(strict_types=1);

use Modules\User\Datas\PasswordData;
use Modules\User\Tests\TestCase;
use Spatie\LaravelData\Data;

uses(TestCase::class);

beforeEach(function (): void {
    $this->passwordData = new PasswordData(
        otp_expiration_minutes: 10,
        otp_length: 8,
        expires_in: 120,
        min: 12,
        mixedCase: true,
        letters: true,
        numbers: true,
        symbols: true,
        uncompromised: true,
        compromisedThreshold: 5,
        failMessage: 'Password non valida',
    );
});

test('password data can be created with custom parameters', function (): void {
    expect($this->passwordData)->toBeInstanceOf(PasswordData::class);
    expect($this->passwordData->otp_expiration_minutes)->toBe(10);
    expect($this->passwordData->otp_length)->toBe(8);
    expect($this->passwordData->expires_in)->toBe(120);
    expect($this->passwordData->min)->toBe(12);
    expect($this->passwordData->mixedCase)->toBeTrue();
    expect($this->passwordData->letters)->toBeTrue();
    expect($this->passwordData->numbers)->toBeTrue();
    expect($this->passwordData->symbols)->toBeTrue();
    expect($this->passwordData->uncompromised)->toBeTrue();
    expect($this->passwordData->compromisedThreshold)->toBe(5);
    expect($this->passwordData->failMessage)->toBe('Password non valida');
});

test('password data has default values', function (): void {
    $defaultPasswordData = new PasswordData();

    expect($defaultPasswordData->otp_expiration_minutes)->toBe(5);
    expect($defaultPasswordData->otp_length)->toBe(6);
    expect($defaultPasswordData->expires_in)->toBe(60);
    expect($defaultPasswordData->min)->toBe(8);
    expect($defaultPasswordData->mixedCase)->toBeTrue();
    expect($defaultPasswordData->letters)->toBeTrue();
    expect($defaultPasswordData->numbers)->toBeTrue();
    expect($defaultPasswordData->symbols)->toBeTrue();
    expect($defaultPasswordData->uncompromised)->toBeTrue();
    expect($defaultPasswordData->compromisedThreshold)->toBe(0);
    expect($defaultPasswordData->failMessage)->toBeNull();
});

test('password data extends spatie data class', function (): void {
    expect($this->passwordData)->toBeInstanceOf(Data::class);
});

test('password data has correct properties', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);
    $properties = $reflection->getProperties();

    $propertyNames = array_map(fn ($prop) => $prop->getName(), $properties);

    expect($propertyNames)->toContain('otp_expiration_minutes');
    expect($propertyNames)->toContain('otp_length');
    expect($propertyNames)->toContain('expires_in');
    expect($propertyNames)->toContain('min');
    expect($propertyNames)->toContain('mixedCase');
    expect($propertyNames)->toContain('letters');
    expect($propertyNames)->toContain('numbers');
    expect($propertyNames)->toContain('symbols');
    expect($propertyNames)->toContain('uncompromised');
    expect($propertyNames)->toContain('compromisedThreshold');
    expect($propertyNames)->toContain('failMessage');
});

test('password data has correct types', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);

    $otpExpirationProperty = $reflection->getProperty('otp_expiration_minutes');
    $otpLengthProperty = $reflection->getProperty('otp_length');
    $expiresInProperty = $reflection->getProperty('expires_in');
    $minProperty = $reflection->getProperty('min');
    $mixedCaseProperty = $reflection->getProperty('mixedCase');
    $lettersProperty = $reflection->getProperty('letters');
    $numbersProperty = $reflection->getProperty('numbers');
    $symbolsProperty = $reflection->getProperty('symbols');
    $uncompromisedProperty = $reflection->getProperty('uncompromised');
    $compromisedThresholdProperty = $reflection->getProperty('compromisedThreshold');
    $failMessageProperty = $reflection->getProperty('failMessage');

    expect($otpExpirationProperty->getType()->getName())->toBe('int');
    expect($otpLengthProperty->getType()->getName())->toBe('int');
    expect($expiresInProperty->getType()->getName())->toBe('int');
    expect($minProperty->getType()->getName())->toBe('int');
    expect($mixedCaseProperty->getType()->getName())->toBe('bool');
    expect($lettersProperty->getType()->getName())->toBe('bool');
    expect($numbersProperty->getType()->getName())->toBe('bool');
    expect($symbolsProperty->getType()->getName())->toBe('bool');
    expect($uncompromisedProperty->getType()->getName())->toBe('bool');
    expect($compromisedThresholdProperty->getType()->getName())->toBe('int');
    expect($failMessageProperty->getType()->getName())->toBe('string');
    expect($failMessageProperty->getType()->allowsNull())->toBeTrue();
});

test('password data has correct constructor parameters', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);
    $constructor = $reflection->getConstructor();

    expect($constructor)->not->toBeNull();

    $parameters = $constructor->getParameters();
    expect($parameters)->toHaveCount(12);

    // Check first few parameters
    expect($parameters[0]->getName())->toBe('otp_expiration_minutes');
    expect($parameters[0]->getType()->getName())->toBe('int');
    expect($parameters[0]->isOptional())->toBeTrue();
    expect($parameters[0]->getDefaultValue())->toBe(5);

    expect($parameters[1]->getName())->toBe('otp_length');
    expect($parameters[1]->getType()->getName())->toBe('int');
    expect($parameters[1]->isOptional())->toBeTrue();
    expect($parameters[1]->getDefaultValue())->toBe(6);
});

test('password data has correct namespace', function (): void {
    expect(PasswordData::class)->toContain('Modules\User\Datas');
});

test('password data has correct strict types declaration', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);
    $filename = $reflection->getFileName();

    if ($filename) {
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    }
});
