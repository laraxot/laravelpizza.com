<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\Relation;
use Mockery\MockInterface;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Tests\Fixtures\RatingsHostStiChildStub;
use Modules\Rating\Tests\Fixtures\RatingsHostStub;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

require_once __DIR__.'/../Fixtures/RatingsHostStub.php';
require_once __DIR__.'/../Fixtures/RatingsHostStiChildStub.php';

/**
 * Story Rating `rating-morphs-sti-parent-fqcn`: `rating_morph.model_type` ha due forme
 * per la stessa entita' (alias della morph map e FQCN). Su un figlio STI le due forme
 * sono l'alias e il FQCN del **padre**, mai `static::class` del figlio.
 */
const MORPH_TYPES_TEST_ALIAS = 'ratings_host_stub';

afterEach(function (): void {
    // La morph map e' statica e condivisa fra i test: si toglie solo l'alias aggiunto qui.
    $map = Relation::morphMap();
    unset($map[MORPH_TYPES_TEST_ALIAS]);
    Relation::morphMap($map, false);
    \Mockery::close();
});

function aliasRatingsHostStub(): void
{
    Relation::morphMap([
        MORPH_TYPES_TEST_ALIAS => RatingsHostStub::class,
    ]);
}

/**
 * Riga pivot grezza di `rating_morph`, con la sua forma di `model_type`.
 */
function morphRow(int $ratingId, string $modelType, int|float|null $value, ?string $note = null): RatingMorph
{
    $pivot = new RatingMorph;
    $pivot->setRawAttributes([
        'rating_id' => $ratingId,
        'model_type' => $modelType,
        'value' => $value,
        'note' => $note,
    ]);

    return $pivot;
}

describe('HasRatingsTrait::ratingMorphTypes', function (): void {
    test('figlio STI con alias: alias e FQCN del padre, mai la classe figlia', function (): void {
        aliasRatingsHostStub();

        $types = (new RatingsHostStiChildStub)->ratingMorphTypes();

        Assert::assertSame([MORPH_TYPES_TEST_ALIAS, RatingsHostStub::class], $types);
        Assert::assertNotContains(RatingsHostStiChildStub::class, $types);
    });

    test('figlio STI senza alias: solo il FQCN del padre', function (): void {
        Assert::assertSame([RatingsHostStub::class], (new RatingsHostStiChildStub)->ratingMorphTypes());
    });

    test('host non STI con alias: alias e FQCN', function (): void {
        aliasRatingsHostStub();

        Assert::assertSame([MORPH_TYPES_TEST_ALIAS, RatingsHostStub::class], (new RatingsHostStub)->ratingMorphTypes());
    });

    test('host non STI senza alias: un solo FQCN, nessun duplicato', function (): void {
        Assert::assertSame([RatingsHostStub::class], (new RatingsHostStub)->ratingMorphTypes());
    });
});

describe('HasRatingsTrait::ratings_by_id fra le due forme', function (): void {
    test('con value null su entrambe le righe preferisce quella con la nota (opzione altro)', function (): void {
        $host = new RatingsHostStub;
        $host->setRelation('ratings', new EloquentCollection);
        $host->setRelation('ratingMorphs', new EloquentCollection([
            morphRow(52, MORPH_TYPES_TEST_ALIAS, null),
            morphRow(52, RatingsHostStub::class, null, 'motivo libero'),
        ]));

        Assert::assertSame('motivo libero', data_get($host, 'ratings_by_id.52.pivot.note'));
    });
});

describe('HasRatingsTrait::hydrateRatingsFormData fra le due forme', function (): void {
    test('riga alias vuota accanto alla FQCN valorizzata: il form riceve il voto (scheda 9240)', function (): void {
        $host = new RatingsHostStub;
        $host->setRelation('ratings', new EloquentCollection);
        $host->setRelation('ratingMorphs', new EloquentCollection([
            morphRow(52, MORPH_TYPES_TEST_ALIAS, null),
            morphRow(52, RatingsHostStub::class, 53),
            morphRow(34, MORPH_TYPES_TEST_ALIAS, null),
            morphRow(34, RatingsHostStub::class, 3),
        ]));

        $data = $host->hydrateRatingsFormData([]);

        Assert::assertSame([
            '52' => ['pivot' => ['value' => 53, 'note' => null]],
            '34' => ['pivot' => ['value' => 3, 'note' => null]],
        ], $data['ratings']);
    });

    test('nota su una sola forma: il form riparte da altro', function (): void {
        $host = new RatingsHostStub;
        $host->setRelation('ratings', new EloquentCollection);
        $host->setRelation('ratingMorphs', new EloquentCollection([
            morphRow(52, MORPH_TYPES_TEST_ALIAS, null),
            morphRow(52, RatingsHostStub::class, null, 'motivo libero'),
        ]));

        $data = $host->hydrateRatingsFormData([]);

        Assert::assertSame([
            '52' => ['pivot' => ['value' => 'other', 'note' => 'motivo libero']],
        ], $data['ratings']);
    });
});

describe('HasRatingsTrait: chi scrive il pivot invalida le relazioni caricate', function (): void {
    test('syncRatingsFormData scarica ratings e ratingMorphs dopo la scrittura', function (): void {
        /** @var HasMany<MorphPivot, RatingsHostStub>&MockInterface $relation */
        $relation = \Mockery::mock(HasMany::class);
        $relation->shouldReceive('where')->with('rating_id', 7)->andReturnSelf();
        $relation->shouldReceive('update')->once()->andReturn(2);

        $host = new RatingsHostStub;
        $host->forceFill(['id' => 9240]);
        $host->exists = true;
        $host->forcedHasMany = $relation;
        $host->setRelation('ratings', new EloquentCollection);
        $host->setRelation('ratingMorphs', new EloquentCollection([
            morphRow(7, RatingsHostStub::class, 1),
        ]));

        $host->syncRatingsFormData([
            7 => ['pivot' => ['value' => 4]],
        ]);

        Assert::assertFalse($host->relationLoaded('ratings'));
        Assert::assertFalse($host->relationLoaded('ratingMorphs'));
    });

    test('clearEvaluation scarica ratings e ratingMorphs dopo la scrittura', function (): void {
        /** @var HasMany<MorphPivot, RatingsHostStub>&MockInterface $relation */
        $relation = \Mockery::mock(HasMany::class);
        $relation->shouldReceive('update')->once()->andReturn(2);

        $host = new RatingsHostStub;
        $host->forceFill(['id' => 9240]);
        $host->exists = true;
        $host->forcedHasMany = $relation;
        $host->setRelation('ratings', new EloquentCollection);
        $host->setRelation('ratingMorphs', new EloquentCollection([
            morphRow(7, RatingsHostStub::class, 1),
        ]));

        $host->clearEvaluation();

        Assert::assertFalse($host->relationLoaded('ratings'));
        Assert::assertFalse($host->relationLoaded('ratingMorphs'));
    });
});
