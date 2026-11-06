<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Modules\Geo\Models\Comune;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Comune read APIs', function (): void {
    test('finds a comune by name without case sensitivity', function (): void {
        $comune = Comune::findByNome('milano');

        Assert::assertInstanceOf(Comune::class, $comune);
        Assert::assertSame('Milano', $comune->nome);
    });

    test('finds comuni by postal code', function (): void {
        $comuni = Comune::findByCap('20100');

        Assert::assertCount(1, $comuni);
        $comune = $comuni->first();
        Assert::assertInstanceOf(Comune::class, $comune);
        Assert::assertSame('Milano', $comune->nome);
    });

    test('lists comuni for a province', function (): void {
        $comuni = Comune::getComuniByProvincia('Palermo');

        Assert::assertNotEmpty($comuni);
        foreach ($comuni as $comune) {
            Assert::assertInstanceOf(Comune::class, $comune);
            Assert::assertSame('Palermo', $comune->provincia);
        }
    });

    test('finds a comune record by numeric id', function (): void {
        $comune = Comune::findComune(1);

        Assert::assertIsArray($comune);
        Assert::assertSame('Palermo', $comune['nome'] ?? null);
    });
});
