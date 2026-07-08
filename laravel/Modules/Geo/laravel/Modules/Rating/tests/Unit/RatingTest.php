<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Support\Facades\DB;
use Modules\Rating\Enums\SupportedLocale;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Rating', function (): void {
    test('can create rating', function (): void {
        $rating = Rating::create([
            'title' => 'Test Rating',
            'color' => '#FF0000',
        ]);

        Assert::assertTrue(
            DB::connection('rating')->table('ratings')
                ->where('id', $rating->id)
                ->where('title', 'Test Rating')
                ->exists()
        );
    });

    test('can create rating morph', function (): void {
        $rating = Rating::create([
            'title' => 'Test Rating',
        ]);

        $ratingMorph = RatingMorph::create([
            'rating_id' => $rating->id,
            'model_type' => 'test_model',
            'model_id' => 1,
            'value' => 4.5,
            'note' => 'Test note',
            'is_winner' => true,
            'reward' => 10,
        ]);

        Assert::assertTrue(
            DB::connection('rating')->table('rating_morphs')
                ->where('id', $ratingMorph->id)
                ->where('rating_id', $rating->id)
                ->exists()
        );
    });

    test('supported locale enum', function (): void {
        $locale = SupportedLocale::IT;

        Assert::assertEquals('it', $locale->value);
        Assert::assertEquals('rating::supported_locale.values.it.label', $locale->getLabel());

        $localeFromString = SupportedLocale::fromString('en');
        Assert::assertEquals(SupportedLocale::EN, $localeFromString);

        $locales = SupportedLocale::toArray();
        Assert::assertArrayHasKey('it', $locales);
        Assert::assertArrayHasKey('en', $locales);
    });
});
