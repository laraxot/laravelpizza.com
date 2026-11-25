<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('RatingMorph / BaseRatingMorph', function (): void {
    test('usa la tabella rating_morph (singolare)', function (): void {
        Assert::assertSame('rating_morph', (new RatingMorph)->getTable());
    });

    test('espone le relazioni rating user profile model', function (): void {
        $morph = new RatingMorph;

        Assert::assertSame('rating_id', $morph->rating()->getForeignKeyName());
        Assert::assertSame(Rating::class, $morph->rating()->getRelated()::class);
        Assert::assertSame('user_id', $morph->user()->getForeignKeyName());
        Assert::assertSame('user_id', $morph->profile()->getForeignKeyName());
        Assert::assertSame('model_type', $morph->model()->getMorphType());
    });
});
