<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Http\Volt\CounterComponent;

describe('CounterComponent', function (): void {
    test('counter component extends volt component', function (): void {
        $component = new CounterComponent();

        expect($component)->toBeInstanceOf(\Livewire\Volt\Component::class);
    });

    test('counter component has count property', function (): void {
        $component = new CounterComponent();

        expect(property_exists($component, 'count'))->toBeTrue();
    });

    test('counter component has increment method', function (): void {
        expect(method_exists(CounterComponent::class, 'increment'))->toBeTrue();
    });

    test('counter component has decrement method', function (): void {
        expect(method_exists(CounterComponent::class, 'decrement'))->toBeTrue();
    });

    test('counter component uses correct namespace', function (): void {
        $reflector = new ReflectionClass(CounterComponent::class);

        expect($reflector->getNamespaceName())->toBe('Modules\Cms\Http\Volt');
    });

    test('counter component count starts at zero', function (): void {
        $component = new CounterComponent();

        expect($component->count)->toBe(0);
    });
});
