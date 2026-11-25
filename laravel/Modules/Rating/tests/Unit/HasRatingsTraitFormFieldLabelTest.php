<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Modules\Rating\Datas\RatingData;
use Modules\Rating\Models\Rating;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('HasRatingsTrait::formFieldLabel', function (): void {
    test('preferisce txt a title e toglie HTML', function (): void {
        $rating = new Rating;
        $rating->forceFill(['id' => 1, 'title' => 'Ruolo', 'txt' => 'Ruolo <b>organizzativo</b>']);

        Assert::assertSame('Ruolo organizzativo', RatingData::formFieldLabel($rating));
    });

    test('usa title se txt assente', function (): void {
        $rating = new Rating;
        $rating->forceFill(['id' => 2, 'title' => 'Criterio']);

        Assert::assertSame('Criterio', RatingData::formFieldLabel($rating));
    });
});
