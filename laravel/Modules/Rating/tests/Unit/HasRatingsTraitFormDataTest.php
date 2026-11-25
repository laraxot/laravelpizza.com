<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Mockery\MockInterface;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Tests\Fixtures\RatingsHostStub;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

require_once __DIR__.'/../Fixtures/RatingsHostStub.php';

afterEach(function (): void {
    \Mockery::close();
});

/**
 * @param  array<string, int|string|null>  $payload
 * @return HasMany<MorphPivot, RatingsHostStub>&MockInterface
 */
function mockRatingMorphsQuery(int|string $ratingId, array $payload, int $updated = 1): HasMany
{
    /** @var HasMany<MorphPivot, RatingsHostStub>&MockInterface $relation */
    $relation = \Mockery::mock(HasMany::class);
    $relation->shouldReceive('whereIn')->andReturnSelf();
    $relation->shouldReceive('where')->with('rating_id', $ratingId)->andReturnSelf();
    $relation->shouldReceive('update')->once()->with($payload)->andReturn($updated);

    return $relation;
}

/**
 * Host con le sole righe pivot `rating_morph` caricate: `hydrateRatingsFormData()` legge
 * da `ratings_by_id`, cioe' da `ratingMorphs` (entrambe le forme di `model_type`).
 *
 * @param  list<array{0: int, 1: int|float|null, 2: string|null}>  $rows  [rating_id, value, note]
 */
function hostWithMorphRows(array $rows): RatingsHostStub
{
    $morphs = array_map(static function (array $row): RatingMorph {
        $pivot = new RatingMorph;
        $pivot->setRawAttributes([
            'rating_id' => $row[0],
            'model_type' => RatingsHostStub::class,
            'value' => $row[1],
            'note' => $row[2],
        ]);

        return $pivot;
    }, $rows);

    $host = new RatingsHostStub;
    $host->setRelation('ratings', new EloquentCollection);
    $host->setRelation('ratingMorphs', new EloquentCollection($morphs));

    return $host;
}

/*
 * Story Rating/5.145 — refactor: fill/save del pivot ratings.{id}.pivot.{value,note}
 * spostato da CompilaIndennitaResponsabilita (duplicato, parziale, con un cast a 0 buggato)
 * a due metodi generici del trait. Risolve anche il blocker IR/5.140 (issue
 * provtv/module_indennitaresponsabilita_fila5#36) sul pass-through di pivot.note.
 *
 * Hotfix 2026-09-16: sync/clear usano ratingMorphs() (model_id + alias|FQCN), non
 * updateExistingPivot solo-alias.
 */
describe('HasRatingsTrait::hydrateRatingsFormData', function (): void {
    test('mappa value e note per ogni riga gia caricata', function (): void {
        $host = hostWithMorphRows([[1, 5, null], [2, null, null]]);

        $data = $host->hydrateRatingsFormData(['dal' => 'x']);

        Assert::assertSame('x', $data['dal']);
        Assert::assertSame([
            '1' => ['pivot' => ['value' => 5, 'note' => null]],
            '2' => ['pivot' => ['value' => null, 'note' => null]],
        ], $data['ratings']);
    });

    test('rimappa value null + note valorizzata sulla chiave "other" (altro)', function (): void {
        $host = hostWithMorphRows([[3, null, 'motivo libero']]);

        $data = $host->hydrateRatingsFormData([]);

        Assert::assertSame([
            '3' => ['pivot' => ['value' => 'other', 'note' => 'motivo libero']],
        ], $data['ratings']);
    });

    test('non rimappa se value e un numero reale, anche zero', function (): void {
        $host = hostWithMorphRows([[4, 0, 'commento']]);

        $data = $host->hydrateRatingsFormData([]);

        Assert::assertSame([
            '4' => ['pivot' => ['value' => 0, 'note' => 'commento']],
        ], $data['ratings']);
    });
});

describe('HasRatingsTrait::syncRatingsFormData', function (): void {
    test('scrive value numerico e note invariata via ratingMorphs', function (): void {
        $host = new RatingsHostStub;
        $host->forceFill(['id' => 1001]);
        $host->exists = true;
        $host->forcedHasMany = mockRatingMorphsQuery(7, ['value' => 5, 'note' => 'ok'], 1);

        $host->syncRatingsFormData([
            7 => ['pivot' => ['value' => 5, 'note' => 'ok']],
        ]);
    });

    test('normalizza a null la chiave "other" (altro), mai a zero', function (): void {
        $host = new RatingsHostStub;
        $host->forceFill(['id' => 1002]);
        $host->exists = true;
        $host->forcedHasMany = mockRatingMorphsQuery(8, ['value' => null, 'note' => 'motivo'], 1);

        $host->syncRatingsFormData([
            8 => ['pivot' => ['value' => 'other', 'note' => 'motivo']],
        ]);
    });

    test('normalizza a null un valore non numerico, mai a zero', function (): void {
        $host = new RatingsHostStub;
        $host->forceFill(['id' => 1003]);
        $host->exists = true;
        $host->forcedHasMany = mockRatingMorphsQuery(9, ['value' => null], 1);

        $host->syncRatingsFormData([
            9 => ['pivot' => ['value' => 'garbage']],
        ]);
    });

    test('value null resta null (nessuna scelta), mai a zero', function (): void {
        $host = new RatingsHostStub;
        $host->forceFill(['id' => 1004]);
        $host->exists = true;
        $host->forcedHasMany = mockRatingMorphsQuery(10, ['value' => null], 1);

        $host->syncRatingsFormData([
            10 => ['pivot' => ['value' => null]],
        ]);
    });

    test('se nessuna pivot esiste per questo host, attach una sola volta', function (): void {
        $host = new RatingsHostStub;
        $host->forceFill(['id' => 1005]);
        $host->exists = true;
        $host->forcedHasMany = mockRatingMorphsQuery(11, ['value' => 3], 0);

        /** @var MorphToMany<Rating, RatingsHostStub, MorphPivot, 'pivot'>&MockInterface $morph */
        $morph = \Mockery::mock(MorphToMany::class);
        $morph->shouldReceive('attach')->once()->with(11, ['value' => 3]);
        $host->forcedMorph = $morph;

        $host->syncRatingsFormData([
            11 => ['pivot' => ['value' => 3]],
        ]);
    });
});

describe('HasRatingsTrait::clearEvaluation / clearRatingsFormData', function (): void {
    test('azzera value e note di tutte le pivot di questo model_id via ratingMorphs', function (): void {
        /** @var HasMany<MorphPivot, RatingsHostStub>&MockInterface $relation */
        $relation = \Mockery::mock(HasMany::class);
        $relation->shouldReceive('update')->once()->with([
            'value' => null,
            'note' => null,
        ])->andReturn(3);

        $host = new RatingsHostStub;
        $host->forceFill(['id' => 9408]);
        $host->exists = true;
        $host->forcedHasMany = $relation;

        $host->clearEvaluation();
    });

    test('clearRatingsFormData delega a clearEvaluation (stesso scope model_id)', function (): void {
        /** @var HasMany<MorphPivot, RatingsHostStub>&MockInterface $relation */
        $relation = \Mockery::mock(HasMany::class);
        $relation->shouldReceive('update')->once()->with([
            'value' => null,
            'note' => null,
        ])->andReturn(1);

        $host = new RatingsHostStub;
        $host->forceFill(['id' => 9409]);
        $host->exists = true;
        $host->forcedHasMany = $relation;

        $host->clearRatingsFormData(null);
    });
});
