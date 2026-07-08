<?php

declare(strict_types=1);

namespace Modules\Performance\Tests\Feature;

use Modules\Performance\Actions\GetHaDirittoMotivoAction;
use Modules\Performance\Models\CriteriEsclusione;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\IndividualeDip;
use Modules\Performance\Models\IndividualeDirigente;
use Modules\Performance\Models\IndividualePo;
use Modules\Performance\Models\IndividualeRegionale;
use Modules\Performance\Models\PerformanceFondo;
use PHPUnit\Framework\Assert;

uses(\Modules\Performance\Tests\TestCase::class);

it("instantiates concrete performance models", function (): void {
    Assert::assertInstanceOf(Individuale::class, new Individuale());
    Assert::assertInstanceOf(Individuale::class, new IndividualeDip());
    Assert::assertInstanceOf(Individuale::class, new IndividualeDirigente());
    Assert::assertInstanceOf(Individuale::class, new IndividualePo());
    Assert::assertInstanceOf(Individuale::class, new IndividualeRegionale());
});

it("keeps annual fondo data on the real aggregate model", function (): void {
    $fondo = new PerformanceFondo();
    $fondo->anno = 2025;

    Assert::assertSame(2025, $fondo->anno);
});

it("instantiates business rule collaborators", function (): void {
    Assert::assertInstanceOf(GetHaDirittoMotivoAction::class, new GetHaDirittoMotivoAction());
    Assert::assertInstanceOf(CriteriEsclusione::class, new CriteriEsclusione());
});
