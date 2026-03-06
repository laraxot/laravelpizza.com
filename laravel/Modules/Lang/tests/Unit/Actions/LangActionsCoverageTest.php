<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Actions;

use Modules\Lang\Actions\PublishTranslationAction;
use Modules\Lang\Actions\SyncTranslationsAction;
use Modules\Lang\Tests\TestCase;

uses(TestCase::class);

describe('Lang Actions Coverage', function (): void {
    test('PublishTranslationAction is accessible', function (): void {
        expect(app(PublishTranslationAction::class))->toBeInstanceOf(PublishTranslationAction::class);
    });

    test('SyncTranslationsAction is accessible', function (): void {
        expect(app(SyncTranslationsAction::class))->toBeInstanceOf(SyncTranslationsAction::class);
    });

    test('SyncTranslationsAction has correct signature', function (): void {
        $action = app(SyncTranslationsAction::class);

        $reflection = new \ReflectionMethod($action, 'execute');
        $params = $reflection->getParameters();

        expect(count($params))->toBe(3)
            ->and($params[0]->getName())->toBe('sourceLang')
            ->and($params[1]->getName())->toBe('targetLangs')
            ->and($params[2]->getName())->toBe('specificModule');
    });

    test('SyncTranslationsAction has default parameters', function (): void {
        $action = app(SyncTranslationsAction::class);

        $reflection = new \ReflectionMethod($action, 'execute');
        $params = $reflection->getParameters();

        expect($params[0]->isDefaultValueAvailable())->toBeTrue()
            ->and($params[1]->isDefaultValueAvailable())->toBeTrue()
            ->and($params[2]->isDefaultValueAvailable())->toBeTrue();
    });
});
