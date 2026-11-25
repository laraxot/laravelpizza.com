<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Modules\Xot\Rules\DateTimeRule;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-xot-db');

test('DateTimeRule accepts the documented day month year format', function (): void {
    $validator = Validator::make(
        ['published_at' => '10/10/2019 13:43'],
        ['published_at' => [new DateTimeRule]],
    );

    Assert::assertFalse($validator->fails());
});

$rejectsInvalidDateTime = function (int|string $value): void {
    $validator = Validator::make(
        ['published_at' => $value],
        ['published_at' => [new DateTimeRule]],
    );

    Assert::assertTrue($validator->fails());

    $message = $validator->errors()->first('published_at');
    Assert::assertStringContainsString('not a valid datetime', $message);
};

test('DateTimeRule rejects a non-string value', function () use ($rejectsInvalidDateTime): void {
    $rejectsInvalidDateTime(123);
});

test('DateTimeRule rejects an invalid calendar date', function () use ($rejectsInvalidDateTime): void {
    $rejectsInvalidDateTime('2024-13-99 25:99');
});
