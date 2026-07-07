<?php

declare(strict_types=1);

use Livewire\Volt\Component as VoltComponent;
use Modules\Cms\Http\Volt\Password\ResetComponent;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('Password ResetComponent', function (): void {
    test('reset component extends volt component', function (): void {
        $component = new ResetComponent();

        Assert::assertInstanceOf(VoltComponent::class, $component);
    });

    test('reset component has expected public properties', function (): void {
        $component = new ResetComponent();

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('email'));

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('emailSentMessage'));

        Assert::assertNull($component->email);

        Assert::assertFalse($component->emailSentMessage);
    });

    test('reset component has send reset password link method', function (): void {
    });

    test('send reset password link method returns void', function (): void {
        $reflection = new ReflectionClass(ResetComponent::class);
        $method = $reflection->getMethod('sendResetPasswordLink');
        $returnType = $method->getReturnType();

        Assert::assertNull($returnType);

        Assert::assertSame('void', (string) $returnType);
    });
});
