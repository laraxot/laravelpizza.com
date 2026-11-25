<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Modules\Rating\Models\BaseModel;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Models\Traits\HasRating;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Il pivot di `HasRating::ratings()` e' `RatingMorph`: lo deduce `RelationX::morphToManyX()`
 * per convenzione (`guessMorphPivot`), senza parametri. La relazione si costruisce senza query.
 *
 * `morphToManyX()` non ha mai avuto un parametro `pivotClass`: il test che lo esercitava
 * e' arrivato con la sync del 19 novembre da un'altra generazione del modulo ed e' stato tolto
 * (story `phpstan-rating-tail-contracts`).
 */
test('ratings() usa RatingMorph come pivot per convenzione', function (): void {
    $host = new class extends BaseModel
    {
        use HasRating;
    };

    $relation = $host->ratings();

    Assert::assertSame(Rating::class, $relation->getRelated()::class);
    Assert::assertSame(RatingMorph::class, $relation->getPivotClass());
});
