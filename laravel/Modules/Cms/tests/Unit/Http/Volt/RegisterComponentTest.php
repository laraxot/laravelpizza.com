<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Volt;

use Modules\Cms\Http\Volt\RegisterComponent;
use PHPUnit\Framework\Assert;

describe('Register Component', function (): void {
    test('register component extends volt component', function (): void {
        $component = new RegisterComponent;
        Assert::assertSame(RegisterComponent::class, $component::class);

    });

    test('register component has expected public properties defaults', function (): void {
        $component = new RegisterComponent;

        Assert::assertTrue((new \ReflectionClass($component))->hasProperty('name'));

        Assert::assertTrue((new \ReflectionClass($component))->hasProperty('email'));

        Assert::assertTrue((new \ReflectionClass($component))->hasProperty('password'));

        Assert::assertTrue((new \ReflectionClass($component))->hasProperty('password_confirmation'));

        Assert::assertSame('', $component->name);

        Assert::assertSame('', $component->email);

        Assert::assertSame('', $component->password);

        Assert::assertSame('', $component->password_confirmation);
    });

    test('register component has register method', function (): void {
        $method = (new \ReflectionClass(RegisterComponent::class))->getMethod('register');

        Assert::assertSame('register', $method->getName());
    });

    test('register method returns redirect response', function (): void {
        $reflection = new \ReflectionClass(RegisterComponent::class);
        $method = $reflection->getMethod('register');
        $returnType = $method->getReturnType();

        Assert::assertNotNull($returnType);
        // Il cast a stringa di `ReflectionType` e' deprecato: il ramo alternativo serviva
        // solo ai tipi union/intersection, che qui non ci sono. Si asserisce il tipo.
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType);
        Assert::assertSame('Illuminate\Http\RedirectResponse', $returnType->getName());
    });
});
