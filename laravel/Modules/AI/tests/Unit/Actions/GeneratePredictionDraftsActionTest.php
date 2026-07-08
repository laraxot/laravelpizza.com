<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Modules\AI\Actions\Predict\GeneratePredictionDraftsAction;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\AI\Tests\TestCase::class);

describe('Generate Prediction Drafts Action', function (): void {
    test('_it_returns_fallback_drafts_when_openai_api_key_is_missing', function (): void {
config()->set('openai.api_key', null);

        $drafts = (new GeneratePredictionDraftsAction)->execute(3);

        Assert::assertCount(3, $drafts);
        Assert::assertSame(['title', 'subtitle', 'description', 'category', 'tags', 'analysis', 'event_end_date', 'liquidity', 'options'], array_keys($drafts[0]));
        Assert::assertNotEmpty($drafts[0]['tags']);
        Assert::assertNotEmpty($drafts[0]['options']);
    });
});
