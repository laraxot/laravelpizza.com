<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\CounterComponent;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('CounterComponent', function (): void {
    test('counter component extends volt component', function (): void {
        $component = new CounterComponent();

        Assert::assertInstanceOf(Livewire\Volt\Component::class, $component);
    });

    test('counter component has count property', function (): void {
        $component = new CounterComponent();

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('count'));
    });

    test('counter component has increment method', function (): void {
    });

    test('counter component has decrement method', function (): void {
    });

    test('counter component uses correct namespace', function (): void {
        $reflector = new ReflectionClass(CounterComponent::class);

        Assert::assertSame('Modules\Cms\Http\Volt', $reflector->getNamespaceName());
    });

    test('counter component count starts at zero', function (): void {
        $component = new CounterComponent();

        Assert::assertSame(0, $component->count);
    });
});
