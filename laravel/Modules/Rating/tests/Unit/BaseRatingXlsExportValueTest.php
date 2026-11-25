<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Modules\Rating\Datas\RatingData;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Tests\Fixtures\RatingsHostStub;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

require_once __DIR__.'/../Fixtures/RatingsHostStub.php';

describe('BaseRating xls_export_value (story 18.58)', function (): void {
    test('foglia: xls_export_value espone pivot.value numerico', function (): void {
        $rating = new Rating;
        $rating->setRawAttributes(['id' => 10, 'title' => 'Voto']);
        $rating->setRelation('children', new EloquentCollection);
        $pivot = new RatingMorph;
        $pivot->setRawAttributes(['rating_id' => 10, 'value' => 7, 'note' => null]);
        $rating->setRelation('pivot', $pivot);

        Assert::assertSame(7, $rating->xls_export_value);
        Assert::assertNull($rating->resolveSelectedChild());
    });

    test('padre con figli: xls_export_value e\' txt del figlio selezionato via pivot.value', function (): void {
        $child = new Rating;
        $child->setRawAttributes([
            'id' => 99,
            'title' => 'Opzione B',
            'txt' => '<p>Testo lungo B</p>',
            'parent_id' => 50,
        ]);

        $parent = new Rating;
        $parent->setRawAttributes(['id' => 50, 'title' => 'Criterio Select']);
        $parent->setRelation('children', new EloquentCollection([$child]));
        $pivot = new RatingMorph;
        $pivot->setRawAttributes(['rating_id' => 50, 'value' => 99, 'note' => 'nota libero']);
        $parent->setRelation('pivot', $pivot);

        Assert::assertSame(99, $parent->pivot->value);
        Assert::assertSame($child, $parent->resolveSelectedChild());
        Assert::assertSame('Testo lungo B', $parent->xls_export_value);
    });

    test('padre senza selezione: xls_export_value stringa vuota', function (): void {
        $child = new Rating;
        $child->setRawAttributes(['id' => 99, 'title' => 'Opzione', 'parent_id' => 50]);

        $parent = new Rating;
        $parent->setRawAttributes(['id' => 50, 'title' => 'Criterio']);
        $parent->setRelation('children', new EloquentCollection([$child]));
        $pivot = new RatingMorph;
        $pivot->setRawAttributes(['rating_id' => 50, 'value' => null, 'note' => null]);
        $parent->setRelation('pivot', $pivot);

        Assert::assertSame('', $parent->xls_export_value);
    });

    test('ratingXlsValuePath + data_get sull\'host risolvono il txt del figlio', function (): void {
        $child = new Rating;
        $child->setRawAttributes(['id' => 99, 'title' => 'Figlio', 'txt' => 'Scelta A', 'parent_id' => 52]);

        $parent = new Rating;
        $parent->setRawAttributes(['id' => 52, 'title' => 'Padre']);
        $parent->setRelation('children', new EloquentCollection([$child]));
        $pivot = new RatingMorph;
        $pivot->setRawAttributes(['rating_id' => 52, 'value' => 99, 'note' => 'n1']);
        $parent->setRelation('pivot', $pivot);

        $host = new RatingsHostStub;
        $host->setRelation('ratings', new EloquentCollection([$parent]));
        $host->setRelation('ratingMorphs', new EloquentCollection([$pivot]));

        Assert::assertSame(
            'ratings_by_id.52.xls_export_value',
            RatingData::ratingXlsValuePath($parent),
        );
        Assert::assertSame('Scelta A', data_get($host, RatingData::ratingXlsValuePath($parent)));
        Assert::assertSame('n1', data_get($host, RatingData::ratingValuePath($parent, 'note')));
    });
});
