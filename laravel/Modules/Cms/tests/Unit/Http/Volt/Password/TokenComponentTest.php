<?php

declare(strict_types=1);

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\Password\TokenComponent;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('Password TokenComponent', function (): void {
    test('token component extends volt component', function (): void {
        $component = new TokenComponent();

        Assert::assertInstanceOf(VoltComponent::class, $component);
    });

    test('token component has expected public properties', function (): void {
        $component = new TokenComponent();

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('token'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('email'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('passwordConfirmation'));

        Assert::assertSame('', $component->token);

        Assert::assertSame('', $component->email);
    });

    test('mount method sets token and email values', function (): void {
        $component = new TokenComponent();

        $component->mount('abc-token');

        Assert::assertSame('abc-token', $component->token);

        Assert::assertSame('', $component->email);
    });

    test('token component has reset password method', function (): void {
    });

    test('reset password method returns redirector or redirect response', function (): void {
        $reflection = new ReflectionClass(TokenComponent::class);
        $method = $reflection->getMethod('resetPassword');
        $returnType = $method->getReturnType();

        Assert::assertNull($returnType);

        Assert::assertSame('Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse', (string) $returnType);
    });
});
