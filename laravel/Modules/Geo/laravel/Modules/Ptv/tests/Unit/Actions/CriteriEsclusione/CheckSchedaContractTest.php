<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Unit\Actions\CriteriEsclusione;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use Modules\Ptv\Actions\CriteriEsclusione\Check;
use Modules\Ptv\Contracts\CheckCriterioEsclusioneContract;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Ptv\Models\CriteriEsclusione;
use Modules\Ptv\Models\Scheda;
use Modules\Ptv\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionMethod;
use ReflectionNamedType;

uses(TestCase::class);

describe('Check criteri esclusione', function (): void {
    it('accetta SchedaContract come primo argomento', function (): void {
        $method = new ReflectionMethod(Check::class, 'execute');
        $type = $method->getParameters()[0]->getType();

        Assert::assertInstanceOf(ReflectionNamedType::class, $type);
        Assert::assertSame(SchedaContract::class, $type->getName());
    });

    it('allinea CheckCriterioEsclusioneContract su SchedaContract', function (): void {
        $method = new ReflectionMethod(CheckCriterioEsclusioneContract::class, 'execute');
        $type = $method->getParameters()[0]->getType();

        Assert::assertInstanceOf(ReflectionNamedType::class, $type);
        Assert::assertSame(SchedaContract::class, $type->getName());
    });

    it('fallisce se manca action per name criterio', function (): void {
        $scheda = new Scheda(['id' => 1]);
        $criterio = new CriteriEsclusione([
            'id' => 99,
            'name' => 'criterio_inesistente_xyz',
            'value' => 1,
        ]);

        expect(fn () => app(Check::class)->execute($scheda, [$criterio], Collection::make()))
            ->toThrow(InvalidArgumentException::class, 'Action criterio esclusione non trovata');
    });

    it('richiede ha_diritto e motivo in fillable prima di update', function (): void {
        Assert::assertContains('ha_diritto', (new Scheda())->getFillable());
        Assert::assertContains('motivo', (new Scheda())->getFillable());
    });
});
