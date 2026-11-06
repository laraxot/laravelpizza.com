<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\VerifyComponent;
use PHPUnit\Framework\Assert;

describe('VerifyComponent', function (): void {
    test('verify component extends volt component', function (): void {
        $component = new VerifyComponent;
        Assert::assertSame(VerifyComponent::class, $component::class);

    });

    test('verify component has resend method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
    test('verify component has resend method #2', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');

    test('resend method returns void', function (): void {
        $reflection = new ReflectionClass(VerifyComponent::class);
        $method = $reflection->getMethod('resend');
        $returnType = $method->getReturnType();

        Assert::assertInstanceOf(ReflectionNamedType::class, $returnType);
        Assert::assertSame('void', $returnType->getName());
    });
});
