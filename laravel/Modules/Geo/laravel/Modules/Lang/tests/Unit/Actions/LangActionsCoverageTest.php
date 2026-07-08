<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

use Modules\Lang\Actions\PublishTranslationAction;
use Modules\Lang\Actions\SyncTranslationsAction;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Lang Actions Coverage', function (): void {
    test('PublishTranslationAction is accessible', function (): void {
        Assert::assertInstanceOf(PublishTranslationAction::class, app(PublishTranslationAction::class));
    });

    test('SyncTranslationsAction is accessible', function (): void {
        Assert::assertInstanceOf(SyncTranslationsAction::class, app(SyncTranslationsAction::class));
    });

    test('SyncTranslationsAction has correct signature', function (): void {
        $action = app(SyncTranslationsAction::class);

        $reflection = new \ReflectionMethod($action, 'execute');
        $params = $reflection->getParameters();

        Assert::assertCount(3, $params);
        Assert::assertSame('sourceLang', $params[0]->getName());
        Assert::assertSame('targetLangs', $params[1]->getName());
        Assert::assertSame('specificModule', $params[2]->getName());
    });

    test('SyncTranslationsAction has default parameters', function (): void {
        $action = app(SyncTranslationsAction::class);

        $reflection = new \ReflectionMethod($action, 'execute');
        $params = $reflection->getParameters();

        Assert::assertTrue($params[0]->isDefaultValueAvailable());
        Assert::assertTrue($params[1]->isDefaultValueAvailable());
        Assert::assertTrue($params[2]->isDefaultValueAvailable());
    });
});
