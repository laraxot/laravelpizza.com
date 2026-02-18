<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Module;

test('Module model can be instantiated', function () {
    $module = new Module;

    expect($module)->toBeInstanceOf(Module::class);
});

test('Module model has expected fillable fields', function () {
    $module = new Module;

    $fillable = $module->getFillable();

    expect($fillable)->toContain('id')
        ->and($fillable)->toContain('name');
});

test('Module model extends BaseModel', function () {
    $module = new Module;

    expect($module)->toBeInstanceOf(Modules\Cms\Models\BaseModel::class);
});

test('Module model uses Sushi trait', function () {
    $reflection = new ReflectionClass(Module::class);
    $traits = $reflection->getTraitNames();

    expect(in_array(Sushi\Sushi::class, $traits))->toBeTrue();
});

test('Module model has id as route key', function () {
    $module = new Module;

    expect($module->getRouteKeyName())->toBe('id');
});
