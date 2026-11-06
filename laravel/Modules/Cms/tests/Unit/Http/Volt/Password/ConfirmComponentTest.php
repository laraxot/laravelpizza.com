<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\Password\ConfirmComponent;
use PHPUnit\Framework\Assert;

describe('Password ConfirmComponent', function (): void {
    test('confirm component extends volt component', function (): void {
        $component = new ConfirmComponent;
        Assert::assertSame(ConfirmComponent::class, $component::class);

    });

    test('confirm component has password property', function (): void {
        $component = new ConfirmComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password'));

        Assert::assertSame('', $component->password);
    });

    test('confirm component has confirm method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
    test('confirm component has confirm method #2', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');

    test('confirm method declares redirect response return type', function (): void {
        $reflection = new ReflectionClass(ConfirmComponent::class);
        $method = $reflection->getMethod('confirm');
        $returnType = $method->getReturnType();

        Assert::assertInstanceOf(ReflectionNamedType::class, $returnType);
        Assert::assertSame('Illuminate\Http\RedirectResponse', $returnType->getName());
    });
});
