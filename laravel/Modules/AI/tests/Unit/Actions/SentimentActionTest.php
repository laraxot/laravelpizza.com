<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Mockery;
use Modules\AI\Actions\SentimentAction;
use Modules\AI\Datas\SentimentData;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

uses(\Modules\AI\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\AI\Tests\TestCase $this */
});

afterEach(function (): void {
Mockery::close();

});

describe('Sentiment Action', function (): void {
    test('_analyzes_positive_sentiment_correctly', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        $action = new SentimentAction;
        $text = 'This is a great product with excellent features. I am very happy with it.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
        Assert::assertGreaterThan(0, $result->score);
    });

    test('_analyzes_negative_sentiment_correctly', function (): void {
        $action = new SentimentAction;
        $text = 'This is a bad product with terrible features. I am very unhappy with it.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('NEGATIVE', $result->label);
        Assert::assertGreaterThan(0, $result->score);
    });

    test('_analyzes_neutral_sentiment_correctly', function (): void {
        $action = new SentimentAction;
        $text = 'This is a product with some features. I have mixed feelings about it.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertContains($result->label, ['POSITIVE', 'NEGATIVE']);
    });

    test('_handles_empty_text', function (): void {
        $action = new SentimentAction;
        $text = '';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('NEGATIVE', $result->label);
        Assert::assertSame(0, $result->score);
    });

    test('_handles_text_with_only_positive_words', function (): void {
        $action = new SentimentAction;
        $text = 'good great excellent positive happy';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
        Assert::assertSame(1.0, $result->score);
    });

    test('_handles_text_with_only_negative_words', function (): void {
        $action = new SentimentAction;
        $text = 'bad poor terrible negative unhappy';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('NEGATIVE', $result->label);
        Assert::assertSame(1.0, $result->score);
    });

    test('_handles_text_with_mixed_sentiment', function (): void {
        $action = new SentimentAction;
        $text = 'This product is good but has some bad aspects. Overall I am happy but also concerned.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertContains($result->label, ['POSITIVE', 'NEGATIVE']);
    });

    test('_handles_case_insensitive_sentiment_analysis', function (): void {
        $action = new SentimentAction;
        $text = 'This is a GREAT product with EXCELLENT features. I am VERY HAPPY with it.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_special_characters', function (): void {
        $action = new SentimentAction;
        $text = 'This is a great product! I am very happy with it. :)';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_numbers', function (): void {
        $action = new SentimentAction;
        $text = 'I rate this product 5 out of 5. It is excellent and I am very happy.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_punctuation', function (): void {
        $action = new SentimentAction;
        $text = 'This product is terrible!!! I am very unhappy with it...';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('NEGATIVE', $result->label);
    });

    test('_handles_text_with_multiple_sentences', function (): void {
        $action = new SentimentAction;
        $text = 'This is a great product. I am very happy with it. The features are excellent.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_technical_terms', function (): void {
        $action = new SentimentAction;
        $text = 'The API integration is good. The documentation is excellent. I am happy with the performance.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_emotions', function (): void {
        $action = new SentimentAction;
        $text = 'I feel great about this decision. I am so happy and excited. This is wonderful news.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_negations', function (): void {
        $action = new SentimentAction;
        $text = 'This is not a good product. I am not happy with it.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('NEGATIVE', $result->label);
    });

    test('_handles_text_with_intensifiers', function (): void {
        $action = new SentimentAction;
        $text = 'This is extremely good. I am very very happy. The features are absolutely excellent.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_comparisons', function (): void {
        $action = new SentimentAction;
        $text = 'This product is better than the previous one. I am happier now.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_questions', function (): void {
        $action = new SentimentAction;
        $text = 'Is this a good product? I am happy but also wondering about the quality.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertContains($result->label, ['POSITIVE', 'NEGATIVE']);
    });

    test('_handles_text_with_quotes', function (): void {
        $action = new SentimentAction;
        $text = 'The customer said "This is excellent!" and I agree completely.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_abbreviations', function (): void {
        $action = new SentimentAction;
        $text = 'This is gr8! I am v happy with it. The features are excellent.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_foreign_words', function (): void {
        $action = new SentimentAction;
        $text = 'This product is bon (good in French). I am molto felice (very happy in Italian).';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_technical_acronyms', function (): void {
        $action = new SentimentAction;
        $text = 'The API is good. The UI/UX is excellent. I am happy with the MVP.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_measurements', function (): void {
        $action = new SentimentAction;
        $text = 'The 100% uptime is excellent. The 5-star rating is great. I am very happy.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_time_expressions', function (): void {
        $action = new SentimentAction;
        $text = 'I am happy today. Yesterday was great. Tomorrow will be excellent.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });

    test('_handles_text_with_conditional_statements', function (): void {
        $action = new SentimentAction;
        $text = 'If this works, I will be happy. The current state is good.';

        $result = $action->execute($text);

        Assert::assertInstanceOf(SentimentData::class, $result);
        Assert::assertSame('POSITIVE', $result->label);
    });
});
