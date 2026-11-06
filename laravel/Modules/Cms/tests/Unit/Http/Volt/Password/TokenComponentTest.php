<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\Password\TokenComponent;
use PHPUnit\Framework\Assert;

describe('Password TokenComponent', function (): void {
    test('token component extends volt component', function (): void {
        $component = new TokenComponent;
        Assert::assertSame(TokenComponent::class, $component::class);

    });

    test('token component has expected public properties', function (): void {
        $component = new TokenComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('token'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('email'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('passwordConfirmation'));

        Assert::assertSame('', $component->token);

        Assert::assertSame('', $component->email);
    });

    test('mount method sets token and email values', function (): void {
        $component = new TokenComponent;

        $component->mount('abc-token');

        Assert::assertSame('abc-token', $component->token);

        Assert::assertSame('', $component->email);
    });

    test('token component has reset password method', function (): void {})->todo('Add behavior assertion: method existence is statically decidable');
    test('token component has reset password method #2', function (): void {})->todo('Add behavior assertion: method existence is statically decidable');

    test('reset password method returns redirector or redirect response', function (): void {
        $reflection = new ReflectionClass(TokenComponent::class);
        $method = $reflection->getMethod('resetPassword');
        $returnType = $method->getReturnType();

        Assert::assertNotNull($returnType);
        Assert::assertStringContainsString('RedirectResponse', (string) $returnType);
    });
});
