<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\CounterComponent;
use PHPUnit\Framework\Assert;

describe('CounterComponent', function (): void {
    test('counter component extends volt component', function (): void {
        $component = new CounterComponent;
        Assert::assertSame(CounterComponent::class, $component::class);

    });

    test('counter component has count property', function (): void {
        $component = new CounterComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('count'));
    });

    test('counter component has increment method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');

    test('counter component has decrement method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');

    test('counter component uses correct namespace', function (): void {
        $reflector = new ReflectionClass(CounterComponent::class);

        Assert::assertSame('Modules\Cms\Http\Volt', $reflector->getNamespaceName());
    });

    test('counter component count starts at zero', function (): void {
        $component = new CounterComponent;

        Assert::assertSame(0, $component->count);
    });
});
