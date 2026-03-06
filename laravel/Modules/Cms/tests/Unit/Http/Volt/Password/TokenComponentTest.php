<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Volt\Password;

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\Password\TokenComponent;
<<<<<<< HEAD
=======
use ReflectionClass;
>>>>>>> e1ecbe9 (.)

uses(\Modules\Cms\Tests\TestCase::class, \Illuminate\Foundation\Testing\DatabaseTransactions::class);

describe('Password TokenComponent', function (): void {
    test('token component extends volt component', function (): void {
        $component = new TokenComponent();

        expect($component)->toBeInstanceOf(VoltComponent::class);
    });

    test('token component has expected public properties', function (): void {
        $component = new TokenComponent();

        expect(property_exists($component, 'token'))->toBeTrue()
            ->and(property_exists($component, 'email'))->toBeTrue()
            ->and(property_exists($component, 'password'))->toBeTrue()
            ->and(property_exists($component, 'passwordConfirmation'))->toBeTrue()
            ->and($component->token)->toBe('')
            ->and($component->email)->toBe('');
    });

    test('mount method sets token and email values', function (): void {
        $component = new TokenComponent();

        $component->mount('abc-token');

        expect($component->token)->toBe('abc-token')
            ->and($component->email)->toBe('');
    });

    test('token component has reset password method', function (): void {
        expect(method_exists(TokenComponent::class, 'resetPassword'))->toBeTrue();
    });

    test('reset password method returns redirector or redirect response', function (): void {
<<<<<<< HEAD
        $reflection = new \ReflectionClass(TokenComponent::class);
=======
        $reflection = new ReflectionClass(TokenComponent::class);
>>>>>>> e1ecbe9 (.)
        $method = $reflection->getMethod('resetPassword');
        $returnType = $method->getReturnType();

        expect($returnType)->not->toBeNull()
            ->and((string) $returnType)->toBe('Illuminate\Routing\Redirector|Illuminate\Http\RedirectResponse');
    });
});
<<<<<<< HEAD
=======

>>>>>>> e1ecbe9 (.)
