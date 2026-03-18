<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Http\Volt;

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\VerifyComponent;

describe('VerifyComponent', function (): void {
    test('verify component extends volt component', function (): void {
        $component = new VerifyComponent();

        expect($component)->toBeInstanceOf(VoltComponent::class);
    });

    test('verify component has resend method', function (): void {
        expect(method_exists(VerifyComponent::class, 'resend'))->toBeTrue();
    });

    test('resend method returns void', function (): void {
        $reflection = new \ReflectionClass(VerifyComponent::class);
        $method = $reflection->getMethod('resend');
        $returnType = $method->getReturnType();

        expect($returnType)->not->toBeNull()
            ->and((string) $returnType)->toBe('void');
    });
});
