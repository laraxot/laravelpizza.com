<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Modules\AI\Actions\GeneratePredictionsAction;
use Modules\AI\Datas\PredictionData;
use Modules\AI\Tests\Support\OpenAiHttpFake;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Generate Predictions Action', function (): void {
    test('generates a single prediction with AI', function (): void {
        OpenAiHttpFake::fakeCompletions(OpenAiHttpFake::predictionPayload([
            'category' => 'Politica',
        ]));

        $action = app(GeneratePredictionsAction::class);
        $prediction = $action->execute('Elezioni politiche 2026', [
            'category' => 'Politica',
            'language' => 'it',
        ]);

        Assert::assertInstanceOf(PredictionData::class, $prediction);
        Assert::assertNotEmpty($prediction->title);
        Assert::assertSame('Politica', $prediction->category);
        Assert::assertNotEmpty($prediction->tags);
        Assert::assertTrue($prediction->isWagerable);
    });

    test('generates multiple unique predictions', function (): void {
        $titles = [
            'Prediction Alpha',
            'Prediction Beta',
            'Prediction Gamma',
            'Prediction Delta',
            'Prediction Epsilon',
        ];

        $sequence = Http::sequence();
        foreach ($titles as $title) {
            $payload = OpenAiHttpFake::predictionPayload(['title' => $title]);
            $sequence->push([
                'choices' => [
                    ['text' => json_encode($payload, JSON_THROW_ON_ERROR)],
                ],
                'usage' => ['total_tokens' => 120],
            ]);
        }

        Http::fake(['api.openai.com/*' => $sequence]);

        $action = app(GeneratePredictionsAction::class);
        $generatedTitles = [];

        for ($i = 0; $i < 5; $i++) {
            $prediction = $action->execute("Topic {$i}");
            $generatedTitles[] = $prediction->title;
        }

        Assert::assertCount(5, $generatedTitles);
        Assert::assertCount(5, array_unique($generatedTitles));
    });

    test('generates valid prediction data structure', function (): void {
        OpenAiHttpFake::fakeCompletions(OpenAiHttpFake::predictionPayload());

        $action = app(GeneratePredictionsAction::class);
        $prediction = $action->execute('Test prediction');

        Assert::assertInstanceOf(PredictionData::class, $prediction);
        Assert::assertNotEmpty($prediction->title);
        Assert::assertNotEmpty($prediction->description);
        Assert::assertNotEmpty($prediction->content);
        Assert::assertNotEmpty($prediction->category);
        Assert::assertGreaterThanOrEqual(0.0, $prediction->liquidityParameter);
        Assert::assertLessThanOrEqual(1.0, $prediction->liquidityParameter);
        Assert::assertGreaterThan(0, $prediction->stocksCount);
        Assert::assertNotEmpty($prediction->tags);
    });

    test('generates future dates for closed_at', function (): void {
        OpenAiHttpFake::fakeCompletions(OpenAiHttpFake::predictionPayload());

        $action = app(GeneratePredictionsAction::class);
        $now = now();
        $prediction = $action->execute('Test prediction');

        $closedAt = Carbon::parse($prediction->closedAt);
        Assert::assertTrue($closedAt->isAfter($now));
    });

    test('uses fallback when OpenAI API key is not configured', function (): void {
        Assert::markTestSkipped('Requires config manipulation');
    });

    test('respects category parameter', function (): void {
        OpenAiHttpFake::fakeCompletions(OpenAiHttpFake::predictionPayload([
            'category' => 'Sport',
        ]));

        $action = app(GeneratePredictionsAction::class);
        $prediction = $action->execute('Serie A 2026', [
            'category' => 'Sport',
        ]);

        Assert::assertSame('Sport', $prediction->category);
    });

    test('converts prediction data to predict array', function (): void {
        OpenAiHttpFake::fakeCompletions(OpenAiHttpFake::predictionPayload());

        $action = app(GeneratePredictionsAction::class);
        $prediction = $action->execute('Test prediction');
        $predictArray = $prediction->toPredictArray();

        Assert::assertArrayHasKey('title', $predictArray);
        Assert::assertArrayHasKey('description', $predictArray);
        Assert::assertArrayHasKey('content', $predictArray);
        Assert::assertArrayHasKey('excerpt', $predictArray);
        Assert::assertArrayHasKey('category_name', $predictArray);
        Assert::assertArrayHasKey('tags', $predictArray);
        Assert::assertArrayHasKey('closed_at', $predictArray);
        Assert::assertArrayHasKey('ends_at', $predictArray);
        Assert::assertArrayHasKey('liquidity_parameter', $predictArray);
        Assert::assertArrayHasKey('stocks_count', $predictArray);
        Assert::assertArrayHasKey('is_wagerable', $predictArray);
        Assert::assertArrayHasKey('status', $predictArray);
        Assert::assertArrayHasKey('published_at', $predictArray);
        Assert::assertTrue(
            is_array($predictArray['title']) && array_key_exists('it', $predictArray['title'])
        );
    });

    test('generates valid tags array', function (): void {
        OpenAiHttpFake::fakeCompletions(OpenAiHttpFake::predictionPayload([
            'tags' => ['bitcoin', 'crypto', '2026'],
        ]));

        $action = app(GeneratePredictionsAction::class);
        $prediction = $action->execute('Bitcoin crypto prediction');

        Assert::assertNotEmpty($prediction->tags);

        foreach ($prediction->tags as $tag) {
            Assert::assertNotEmpty($tag);
        }
    });

    test('handles empty topic gracefully', function (): void {
        Assert::markTestSkipped('Implement error handling');
    });

    test('respects rate limiting in batch generation', function (): void {
        Assert::markTestSkipped('Rate limiting not implemented yet');
    });
});
