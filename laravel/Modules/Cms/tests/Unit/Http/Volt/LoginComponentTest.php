<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Http\Volt\LoginComponent;

describe('LoginComponent', function (): void {
    test('login component extends volt component', function (): void {
        $component = new LoginComponent();

        expect($component)->toBeInstanceOf(Livewire\Volt\Component::class);
    });

    test('login component has email property', function (): void {
        $component = new LoginComponent();

        expect(property_exists($component, 'email'))->toBeTrue();
    });

    test('login component has password property', function (): void {
        $component = new LoginComponent();

        expect(property_exists($component, 'password'))->toBeTrue();
    });

    test('login component has remember property', function (): void {
        $component = new LoginComponent();

        expect(property_exists($component, 'remember'))->toBeTrue();
    });

    test('login component has authenticate method', function (): void {
        expect(method_exists(LoginComponent::class, 'authenticate'))->toBeTrue();
    });

    test('login component uses correct namespace', function (): void {
        $reflector = new ReflectionClass(LoginComponent::class);

        expect($reflector->getNamespaceName())->toBe('Modules\Cms\Http\Volt');
    });
});
