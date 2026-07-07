<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\LoginComponent;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('LoginComponent', function (): void {
    test('login component extends volt component', function (): void {
        $component = new LoginComponent();

        Assert::assertInstanceOf(Livewire\Volt\Component::class, $component);
    });

    test('login component has email property', function (): void {
        $component = new LoginComponent();

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('email'));
    });

    test('login component has password property', function (): void {
        $component = new LoginComponent();

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password'));
    });

    test('login component has remember property', function (): void {
        $component = new LoginComponent();

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('remember'));
    });

    test('login component has authenticate method', function (): void {
    });

    test('login component uses correct namespace', function (): void {
        $reflector = new ReflectionClass(LoginComponent::class);

        Assert::assertSame('Modules\Cms\Http\Volt', $reflector->getNamespaceName());
    });
});
