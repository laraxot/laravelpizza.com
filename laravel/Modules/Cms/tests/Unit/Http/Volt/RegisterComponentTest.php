<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Volt;

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\RegisterComponent;
use ReflectionClass;

uses(\Modules\Cms\Tests\TestCase::class);

describe('RegisterComponent', function (): void {
    test('register component extends volt component', function (): void {
        $component = new RegisterComponent();

        expect($component)->toBeInstanceOf(VoltComponent::class);
    });

    test('register component has expected public properties defaults', function (): void {
        $component = new RegisterComponent();

        expect(property_exists($component, 'name'))->toBeTrue()
            ->and(property_exists($component, 'email'))->toBeTrue()
            ->and(property_exists($component, 'password'))->toBeTrue()
            ->and(property_exists($component, 'password_confirmation'))->toBeTrue()
            ->and($component->name)->toBe('')
            ->and($component->email)->toBe('')
            ->and($component->password)->toBe('')
            ->and($component->password_confirmation)->toBe('');
    });

    test('register component has register method', function (): void {
        expect(method_exists(RegisterComponent::class, 'register'))->toBeTrue();
    });

    test('register method returns redirect response', function (): void {
        $reflection = new ReflectionClass(RegisterComponent::class);
        $method = $reflection->getMethod('register');
        $returnType = $method->getReturnType();

        expect($returnType)->not->toBeNull()
            ->and((string) $returnType)->toBe('Illuminate\Http\RedirectResponse');
    });
});
