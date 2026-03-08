<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Volt\Password;

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\Password\ConfirmComponent;
use ReflectionClass;

uses(\Modules\Cms\Tests\TestCase::class);

describe('Password ConfirmComponent', function (): void {
    test('confirm component extends volt component', function (): void {
        $component = new ConfirmComponent();

        expect($component)->toBeInstanceOf(VoltComponent::class);
    });

    test('confirm component has password property', function (): void {
        $component = new ConfirmComponent();

        expect(property_exists($component, 'password'))->toBeTrue()
            ->and($component->password)->toBe('');
    });

    test('confirm component has confirm method', function (): void {
        expect(method_exists(ConfirmComponent::class, 'confirm'))->toBeTrue();
    });

    test('confirm method declares redirect response return type', function (): void {
        $reflection = new ReflectionClass(ConfirmComponent::class);
        $method = $reflection->getMethod('confirm');
        $returnType = $method->getReturnType();

        expect($returnType)->not->toBeNull()
            ->and((string) $returnType)->toBe('Illuminate\Http\RedirectResponse');
    });
});
