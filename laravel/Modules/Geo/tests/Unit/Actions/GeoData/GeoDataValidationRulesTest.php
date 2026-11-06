<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GeoData;

use Modules\Geo\Infrastructure\Validation\GeoDataValidationRules;
use PHPUnit\Framework\Assert;

it('returns validation rules and messages with string keys', function (): void {
    $payload = app(GeoDataValidationRules::class)->execute();

    Assert::assertArrayHasKey('rules', $payload);
    Assert::assertArrayHasKey('messages', $payload);
    Assert::assertSame(GeoDataValidationRules::RULES, $payload['rules']);
    Assert::assertSame(GeoDataValidationRules::MESSAGES, $payload['messages']);
});
