<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\BaseModel;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

describe('Base Model Coverage', function (): void {
    test('casts returns array with required keys', function (): void {
$concrete = new class extends BaseModel
        {
            protected $table = 'test_base_coverage';
        };

        $reflection = new \ReflectionClass($concrete);
        $method = $reflection->getMethod('casts');
        $method->setAccessible(true);

        /** @var array<string, string> $casts */
        $casts = $method->invoke($concrete);

        Assert::assertIsArray($casts);
        // Inherits from XotBaseModel::casts()
        Assert::assertArrayHasKey('id', $casts);
        Assert::assertArrayHasKey('created_at', $casts);
        Assert::assertArrayHasKey('updated_at', $casts);
    });

    test('casts merges with parent casts', function (): void {
$concrete = new class extends BaseModel
        {
            protected $table = 'test_base_coverage_merge';
        };

        $reflection = new \ReflectionClass($concrete);
        $method = $reflection->getMethod('casts');
        $method->setAccessible(true);

        /** @var array<string, string> $casts */
        $casts = $method->invoke($concrete);

        // BaseModel adds no extra casts but inherits parent's
        Assert::assertNotEmpty($casts);
    });
});
