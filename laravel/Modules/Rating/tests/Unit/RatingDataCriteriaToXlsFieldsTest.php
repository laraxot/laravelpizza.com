<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Support\Collection;
use Modules\Rating\Datas\RatingData;
use Modules\Rating\Models\Rating;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('RatingData::criteriaToXlsFields (story 18.60 / 5.230)', function (): void {
    test('criterio foglia: solo path xls_export_value con label da txt', function (): void {
        $rating = new Rating;
        $rating->forceFill([
            'id' => 10,
            'txt' => 'Punteggio',
            'title' => 'Title',
            'parent_id' => null,
        ]);
        $rating->setRelation('children', Collection::make());

        $fields = RatingData::criteriaToXlsFields(Collection::make([$rating]));

        Assert::assertSame(
            [
                'ratings_by_id.10.xls_export_value' => 'Punteggio',
            ],
            $fields,
        );
    });

    test('criterio con figli: path valore + colonna note', function (): void {
        $child = new Rating;
        $child->forceFill(['id' => 11, 'parent_id' => 20, 'txt' => 'Opzione A']);

        $parent = new Rating;
        $parent->forceFill([
            'id' => 20,
            'txt' => '<b>Ruolo</b>',
            'parent_id' => null,
        ]);
        $parent->setRelation('children', Collection::make([$child]));

        $fields = RatingData::criteriaToXlsFields(Collection::make([$parent]));

        Assert::assertArrayHasKey('ratings_by_id.20.xls_export_value', $fields);
        Assert::assertSame('Ruolo', $fields['ratings_by_id.20.xls_export_value']);
        Assert::assertArrayHasKey('ratings_by_id.20.pivot.note', $fields);
        Assert::assertStringContainsString('Ruolo', $fields['ratings_by_id.20.pivot.note']);
    });

    test('righe con parent_id (opzioni Select) non diventano colonne', function (): void {
        $option = new Rating;
        $option->forceFill([
            'id' => 30,
            'txt' => 'Opzione',
            'parent_id' => 20,
        ]);
        $option->setRelation('children', Collection::make());

        Assert::assertSame([], RatingData::criteriaToXlsFields(Collection::make([$option])));
    });
});
