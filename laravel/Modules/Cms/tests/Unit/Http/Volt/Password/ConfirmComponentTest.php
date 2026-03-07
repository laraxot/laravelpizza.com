<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Volt\Password;

<<<<<<< HEAD
use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\Password\ConfirmComponent;
=======
use Modules\Cms\Http\Volt\Password\ConfirmComponent;
use ReflectionClass;
use Livewire\Volt\Component as VoltComponent;
>>>>>>> e1ecbe9 (.)

uses(\Modules\Cms\Tests\TestCase::class, \Illuminate\Foundation\Testing\DatabaseTransactions::class);

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
<<<<<<< HEAD
        $reflection = new \ReflectionClass(ConfirmComponent::class);
=======
        $reflection = new ReflectionClass(ConfirmComponent::class);
>>>>>>> e1ecbe9 (.)
        $method = $reflection->getMethod('confirm');
        $returnType = $method->getReturnType();

        expect($returnType)->not->toBeNull()
            ->and((string) $returnType)->toBe('Illuminate\Http\RedirectResponse');
    });
});
