<?php

declare(strict_types=1);

use Modules\Cms\Models\Module;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('Module model can be instantiated', function () {
    $module = new Module();

    Assert::assertInstanceOf(Module::class, $module);
});

test('Module model has expected fillable fields', function () {
    $module = new Module();

    $fillable = $module->getFillable();

    Assert::assertContains('id', $fillable);

    Assert::assertContains('name', $fillable);
});

test('Module model extends BaseModel', function () {
    $module = new Module();

    Assert::assertInstanceOf(Modules\Cms\Models\BaseModel::class, $module);
});

test('Module model uses Sushi trait', function () {
    $reflection = new ReflectionClass(Module::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(Sushi\Sushi::class, $traits));
});

test('Module model has id as route key', function () {
    $module = new Module();

    Assert::assertSame('id', $module->getRouteKeyName());
});
