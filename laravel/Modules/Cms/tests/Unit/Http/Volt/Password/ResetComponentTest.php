<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Volt\Password;

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\Password\ResetComponent;
<<<<<<< HEAD
=======
use ReflectionClass;
>>>>>>> e1ecbe9 (.)

uses(\Modules\Cms\Tests\TestCase::class, \Illuminate\Foundation\Testing\DatabaseTransactions::class);

describe('Password ResetComponent', function (): void {
    test('reset component extends volt component', function (): void {
        $component = new ResetComponent();

        expect($component)->toBeInstanceOf(VoltComponent::class);
    });

    test('reset component has expected public properties', function (): void {
        $component = new ResetComponent();

        expect(property_exists($component, 'email'))->toBeTrue()
            ->and(property_exists($component, 'emailSentMessage'))->toBeTrue()
            ->and($component->email)->toBeNull()
            ->and($component->emailSentMessage)->toBeFalse();
    });

    test('reset component has send reset password link method', function (): void {
        expect(method_exists(ResetComponent::class, 'sendResetPasswordLink'))->toBeTrue();
    });

    test('send reset password link method returns void', function (): void {
<<<<<<< HEAD
        $reflection = new \ReflectionClass(ResetComponent::class);
=======
        $reflection = new ReflectionClass(ResetComponent::class);
>>>>>>> e1ecbe9 (.)
        $method = $reflection->getMethod('sendResetPasswordLink');
        $returnType = $method->getReturnType();

        expect($returnType)->not->toBeNull()
            ->and((string) $returnType)->toBe('void');
    });
});
<<<<<<< HEAD
=======

>>>>>>> e1ecbe9 (.)
