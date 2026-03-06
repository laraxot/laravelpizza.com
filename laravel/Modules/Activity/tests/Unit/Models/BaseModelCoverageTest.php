<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\BaseModel;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Coverage test for BaseModel::casts() method.
 * Uses the full Laravel application context (Activity TestCase).
 */
class BaseModelCoverageTest extends TestCase
{
    #[Test]
    public function casts_returns_array_with_required_keys(): void
    {
        $concrete = new class extends BaseModel {
            protected $table = 'test_base_coverage';
        };

        $reflection = new \ReflectionClass($concrete);
        $method = $reflection->getMethod('casts');
        $method->setAccessible(true);

        /** @var array<string, string> $casts */
        $casts = $method->invoke($concrete);

        $this->assertIsArray($casts);
        // Inherits from XotBaseModel::casts()
        $this->assertArrayHasKey('id', $casts);
        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
    }

    #[Test]
    public function casts_merges_with_parent_casts(): void
    {
        $concrete = new class extends BaseModel {
            protected $table = 'test_base_coverage_merge';
        };

        $reflection = new \ReflectionClass($concrete);
        $method = $reflection->getMethod('casts');
        $method->setAccessible(true);

        /** @var array<string, string> $casts */
        $casts = $method->invoke($concrete);

        // BaseModel adds no extra casts but inherits parent's
        $this->assertNotEmpty($casts);
    }
}
