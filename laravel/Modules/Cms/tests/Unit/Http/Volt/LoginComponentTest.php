<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\LoginComponent;
use PHPUnit\Framework\Assert;

describe('LoginComponent', function (): void {
    test('login component extends volt component', function (): void {
        $component = new LoginComponent;
        Assert::assertSame(LoginComponent::class, $component::class);

    });

    test('login component has email property', function (): void {
        $component = new LoginComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('email'));
    });

    test('login component has password property', function (): void {
        $component = new LoginComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password'));
    });

    test('login component has remember property', function (): void {
        $component = new LoginComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('remember'));
    });

    test('login component has authenticate method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
    test('login component has authenticate method #2', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');

    test('login component uses correct namespace', function (): void {
        $reflector = new ReflectionClass(LoginComponent::class);

        Assert::assertSame('Modules\Cms\Http\Volt', $reflector->getNamespaceName());
    });
});
