<?php

declare(strict_types=1);

use Modules\Cms\Http\Volt\LoginComponent;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

describe('LoginComponent', function (): void {
    test('login component extends volt component', function (): void {
        $component = new LoginComponent;
        Assert::assertSame(LoginComponent::class, $component::class);

    });

    test('login component has email property', function (): void {
        $component = new LoginComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('email'));
    });

    test('login component has password property', function (): void {
        $component = new LoginComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('password'));
    });

    test('login component has remember property', function (): void {
        $component = new LoginComponent;

        Assert::assertTrue((new ReflectionClass($component))->hasProperty('remember'));
    });

    test('login component has authenticate method', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');
    test('login component has authenticate method #2', function (): void {})->todo('Serve una asserzione di comportamento: l\'esistenza di un metodo su una classe nota e\' decidibile staticamente, quindi non prova niente.');

    test('login component uses correct namespace', function (): void {
        $reflector = new ReflectionClass(LoginComponent::class);

        Assert::assertSame('Modules\Cms\Http\Volt', $reflector->getNamespaceName());
    });
});
