<?php

declare(strict_types=1);

use Modules\User\Datas\PasswordData;
use PHPUnit\Framework\Assert;
use ReflectionNamedType;

use function Safe\file_get_contents;

use Spatie\LaravelData\Data;

uses(Modules\User\Tests\TestCase::class);

function samplePasswordData(): PasswordData
{
    return new PasswordData(
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
}

test('password data can be created with custom parameters', function (): void {
    $passwordData = samplePasswordData();

    Assert::assertInstanceOf(PasswordData::class, $passwordData);
    Assert::assertSame(10, $passwordData->otp_expiration_minutes);
    Assert::assertSame(8, $passwordData->otp_length);
    Assert::assertSame(120, $passwordData->expires_in);
    Assert::assertSame(12, $passwordData->min);
    Assert::assertTrue($passwordData->mixedCase);
    Assert::assertTrue($passwordData->letters);
    Assert::assertTrue($passwordData->numbers);
    Assert::assertTrue($passwordData->symbols);
    Assert::assertTrue($passwordData->uncompromised);
    Assert::assertSame(5, $passwordData->compromisedThreshold);
    Assert::assertSame('Password non valida', $passwordData->failMessage);
});

test('password data has default values', function (): void {
    $defaultPasswordData = new PasswordData();

    Assert::assertSame(5, $defaultPasswordData->otp_expiration_minutes);
    Assert::assertSame(6, $defaultPasswordData->otp_length);
    Assert::assertSame(60, $defaultPasswordData->expires_in);
    Assert::assertSame(8, $defaultPasswordData->min);
    Assert::assertTrue($defaultPasswordData->mixedCase);
    Assert::assertTrue($defaultPasswordData->letters);
    Assert::assertTrue($defaultPasswordData->numbers);
    Assert::assertTrue($defaultPasswordData->symbols);
    Assert::assertTrue($defaultPasswordData->uncompromised);
    Assert::assertSame(0, $defaultPasswordData->compromisedThreshold);
    Assert::assertNull($defaultPasswordData->failMessage);
});

test('password data extends spatie data class', function (): void {
    Assert::assertInstanceOf(Data::class, samplePasswordData());
});

test('password data has correct properties', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);
    $propertyNames = array_map(
        static fn (ReflectionProperty $prop): string => $prop->getName(),
        $reflection->getProperties(),
    );

    foreach ([
        'otp_expiration_minutes',
        'otp_length',
        'expires_in',
        'min',
        'mixedCase',
        'letters',
        'numbers',
        'symbols',
        'uncompromised',
        'compromisedThreshold',
        'failMessage',
    ] as $expected) {
        Assert::assertContains($expected, $propertyNames);
    }
});

test('password data has correct types', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);

    $typeExpectations = [
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

    foreach ($typeExpectations as $propertyName => $expectedType) {
        $property = $reflection->getProperty($propertyName);
        $type = $property->getType();
        Assert::assertInstanceOf(ReflectionNamedType::class, $type);
        Assert::assertSame($expectedType, $type->getName());
    }

    $failMessageType = $reflection->getProperty('failMessage')->getType();
    Assert::assertInstanceOf(ReflectionNamedType::class, $failMessageType);
    Assert::assertTrue($failMessageType->allowsNull());
});

test('password data has correct constructor parameters', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);
    $constructor = $reflection->getConstructor();

    Assert::assertNotNull($constructor);

    $parameters = $constructor->getParameters();
    Assert::assertCount(12, $parameters);

    Assert::assertSame('otp_expiration_minutes', $parameters[0]->getName());
    $otpExpirationType = $parameters[0]->getType();
    Assert::assertInstanceOf(ReflectionNamedType::class, $otpExpirationType);
    Assert::assertSame('int', $otpExpirationType->getName());
    Assert::assertTrue($parameters[0]->isOptional());
    Assert::assertSame(5, $parameters[0]->getDefaultValue());

    Assert::assertSame('otp_length', $parameters[1]->getName());
    $otpLengthType = $parameters[1]->getType();
    Assert::assertInstanceOf(ReflectionNamedType::class, $otpLengthType);
    Assert::assertSame('int', $otpLengthType->getName());
    Assert::assertTrue($parameters[1]->isOptional());
    Assert::assertSame(6, $parameters[1]->getDefaultValue());
});

test('password data has correct namespace', function (): void {
    Assert::assertStringContainsString('Modules\User\Datas', PasswordData::class);
});

test('password data has correct strict types declaration', function (): void {
    $reflection = new ReflectionClass(PasswordData::class);
    $filename = $reflection->getFileName();
    Assert::assertIsString($filename);

    $content = file_get_contents($filename);
    Assert::assertStringContainsString('declare(strict_types=1)', $content);
});
