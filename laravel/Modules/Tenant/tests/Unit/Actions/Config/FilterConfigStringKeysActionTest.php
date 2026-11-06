<?php

declare(strict_types=1);
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use PHPUnit\Framework\Assert;

uses(\Modules\Tenant\Tests\TestCase::class);

it('keeps only string keys', function (): void {
    $result = app(FilterConfigStringKeysAction::class)->execute([
        'name' => 'Acme',
        'enabled' => true,
        123 => 'numeric key',
        'nested' => ['a' => 1, 'b' => 2],
    ]);

    Assert::assertSame([
        'name' => 'Acme',
        'enabled' => true,
        'nested' => ['a' => 1, 'b' => 2],
    ], $result);
});

it('returns an empty array for empty input', function (): void {
    Assert::assertSame([], app(FilterConfigStringKeysAction::class)->execute([]));
});
