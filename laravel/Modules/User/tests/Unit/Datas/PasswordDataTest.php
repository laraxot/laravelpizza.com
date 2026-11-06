<?php

declare(strict_types=1);

use Modules\User\Datas\PasswordData;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

use function Safe\file_get_contents;

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

/** Tipo nativo (non union) dichiarato per la proprieta' promossa dal costruttore. */
function passwordDataPropertyType(string $property): ReflectionNamedType
{
    $type = (new ReflectionProperty(PasswordData::class, $property))->getType();
    Assert::assertInstanceOf(ReflectionNamedType::class, $type);

    return $type;
}

function passwordDataParameterType(ReflectionParameter $parameter): ReflectionNamedType
{
    $type = $parameter->getType();
    Assert::assertInstanceOf(ReflectionNamedType::class, $type);

    return $type;
}

test('password data can be created with custom parameters', function (): void {
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

test('password data has correct properties', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);
    $properties = $reflection->getProperties();

    $propertyNames = array_map(fn (ReflectionProperty $prop) => $prop->getName(), $properties);

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
    $expected = [
        'otp_expiration_minutes' => 'int',
        'otp_length' => 'int',
        'expires_in' => 'int',
        'min' => 'int',
        'mixedCase' => 'bool',
        'letters' => 'bool',
        'numbers' => 'bool',
        'symbols' => 'bool',
        'uncompromised' => 'bool',
        'compromisedThreshold' => 'int',
        'failMessage' => 'string',
    ];

    foreach ($expected as $property => $typeName) {
        expect(passwordDataPropertyType($property)->getName())->toBe($typeName);
    }

    expect(passwordDataPropertyType('failMessage')->allowsNull())->toBeTrue();
});

test('password data has correct constructor parameters', function (): void {
    $constructor = (new ReflectionClass(PasswordData::class))->getConstructor();
    Assert::assertNotNull($constructor);

    $parameters = $constructor->getParameters();
    expect($parameters)->toHaveCount(12);

    // Check first few parameters
    expect($parameters[0]->getName())->toBe('otp_expiration_minutes');
    expect(passwordDataParameterType($parameters[0])->getName())->toBe('int');
    expect($parameters[0]->isOptional())->toBeTrue();
    expect($parameters[0]->getDefaultValue())->toBe(5);

    expect($parameters[1]->getName())->toBe('otp_length');
    expect(passwordDataParameterType($parameters[1])->getName())->toBe('int');
    expect($parameters[1]->isOptional())->toBeTrue();
    expect($parameters[1]->getDefaultValue())->toBe(6);
});

test('password data has correct namespace', function (): void {
    expect(PasswordData::class)->toContain('Modules\User\Datas');
});

test('password data has correct strict types declaration', function (): void {
    $filename = (new ReflectionClass(PasswordData::class))->getFileName();
    Assert::assertNotFalse($filename);

    expect(file_get_contents($filename))->toContain('declare(strict_types=1);');
});
