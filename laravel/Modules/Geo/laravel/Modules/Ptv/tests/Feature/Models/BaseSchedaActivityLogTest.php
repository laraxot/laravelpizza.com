<?php

declare(strict_types=1);

use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Ptv\Models\Scheda;
use PHPUnit\Framework\Assert;

test('ptv scheda extends base scheda and implements the scheda contract', function (): void {
    $scheda = new Scheda();

    Assert::assertInstanceOf(BaseScheda::class, $scheda);
    Assert::assertInstanceOf(SchedaContract::class, $scheda);
});

test('ptv scheda exposes canonical range fields', function (): void {
    $scheda = new Scheda();

    Assert::assertSame('matr', $scheda->matrField());
    Assert::assertSame('ente', $scheda->enteField());
    Assert::assertSame('anno', $scheda->yearField());
    Assert::assertSame('dal', $scheda->rangeFromField());
    Assert::assertSame('al', $scheda->rangeToField());
});
