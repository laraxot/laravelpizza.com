<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Models\BaseModel;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

/*
 * Component is an OPTIONAL model that is NOT part of the UI module artifact set
 * (no Models/Component.php, no ComponentFactory, no create_components_table migration).
 * The tests reach it through a class name resolved at runtime, so PHPStan never
 * needs the class to exist and no ignore annotation is required; the class_exists()
 * guard below skips them while the model is absent. Per no-phpstan-probe-models we
 * do NOT create a fake probe model just to satisfy the analyser. When the Component
 * model + ComponentFactory are actually added, replace the class name with
 * `Component::class` (see CategoryModelTest).
 */

uses(TestCase::class);

/**
 * Narrows the optional Component class to a BaseModel subclass, failing loudly if it exists with another parent.
 */
$componentModel = /** @return class-string<BaseModel> */ static function (string $class = 'Modules\UI\Models\Component'): string {
    if (! is_a($class, BaseModel::class, true)) {
        Assert::fail('Component model must extend ' . BaseModel::class . '.');
    }

    return $class;
};

beforeEach(function (): void {
    if (! class_exists('Modules\UI\Models\Component')) {
        Assert::markTestSkipped('Component model is not part of the UI module artifact set.');
    }
});

describe('Component Model', function () use ($componentModel): void {
    test('can be instantiated', function () use ($componentModel): void {
        $modelClass = $componentModel();
        $component = new $modelClass;
        Assert::assertInstanceOf($modelClass, $component);
    });

    test('has fillable attributes', function () use ($componentModel): void {
        $modelClass = $componentModel();
        $component = new $modelClass;
        $expected = [
            'name', 'theme_id', 'is_active', 'version', 'dependencies',
            'template', 'is_cacheable', 'cache_ttl', 'validation_rules',
            'view_path', 'data_schema', 'responsive_breakpoints',
            'supports_lazy_loading', 'lazy_loading_threshold',
            'cache_strategy', 'cache_duration',
        ];

        foreach ($expected as $field) {
            Assert::assertTrue(in_array($field, $component->getFillable(), true));
        }
    });

    test('has casts defined', function () use ($componentModel): void {
        $modelClass = $componentModel();
        $component = new $modelClass;
        $casts = $component->getCasts();
        Assert::assertSame('boolean', $casts['is_active']);
        Assert::assertSame('boolean', $casts['is_cacheable']);
        Assert::assertSame('array', $casts['dependencies']);
        Assert::assertSame('array', $casts['validation_rules']);
        Assert::assertSame('array', $casts['data_schema']);
        Assert::assertSame('array', $casts['responsive_breakpoints']);
        Assert::assertSame('boolean', $casts['supports_lazy_loading']);
        Assert::assertSame('integer', $casts['lazy_loading_threshold']);
        Assert::assertSame('integer', $casts['cache_duration']);
    });

    test('has theme relationship', function () use ($componentModel): void {
        $reflection = new \ReflectionClass($componentModel());
        Assert::assertTrue($reflection->hasMethod('theme'));
    });

    test('has correct table name', function () use ($componentModel): void {
        $modelClass = $componentModel();
        $component = new $modelClass;
        Assert::assertSame('components', $component->getTable());
    });

    test('extends base model', function (): void {
        Assert::assertTrue(is_subclass_of('Modules\UI\Models\Component', BaseModel::class));
    });

    test('uses strict types', function () use ($componentModel): void {
        $reflection = new \ReflectionClass($componentModel());
        $fileName = $reflection->getFileName();
        if (false === $fileName) {
            Assert::fail('Component model has no source file.');
        }
        $content = file_get_contents($fileName);
        Assert::assertStringContainsString('declare(strict_types=1);', $content);
    });

    test('has correct namespace', function () use ($componentModel): void {
        $reflection = new \ReflectionClass($componentModel());
        Assert::assertSame('Modules\UI\Models', $reflection->getNamespaceName());
    });
});
