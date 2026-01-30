<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Policies\CmsBasePolicy;
use Modules\Cms\Models\Policies\ConfPolicy;
use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\ModulePolicy;
use Modules\Cms\Models\Policies\PageContentPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;

test('CmsBasePolicy is an abstract class', function () {
    $reflection = new ReflectionClass(CmsBasePolicy::class);

    expect($reflection->isAbstract())->toBeTrue();
});

test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy();

    expect($policy)->toBeInstanceOf(PagePolicy::class);
});

test('SectionPolicy can be instantiated', function () {
    $policy = new SectionPolicy();

    expect($policy)->toBeInstanceOf(SectionPolicy::class);
});

test('PageContentPolicy can be instantiated', function () {
    $policy = new PageContentPolicy();

    expect($policy)->toBeInstanceOf(PageContentPolicy::class);
});

test('ConfPolicy can be instantiated', function () {
    $policy = new ConfPolicy();

    expect($policy)->toBeInstanceOf(ConfPolicy::class);
});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy();

    expect($policy)->toBeInstanceOf(MenuPolicy::class);
});

test('ModulePolicy can be instantiated', function () {
    $policy = new ModulePolicy();

    expect($policy)->toBeInstanceOf(ModulePolicy::class);
});

test('PagePolicy has expected methods', function () {
    $policy = new PagePolicy();

    expect(method_exists($policy, 'viewAny'))->toBeTrue();
    expect(method_exists($policy, 'view'))->toBeTrue();
    expect(method_exists($policy, 'create'))->toBeTrue();
    expect(method_exists($policy, 'update'))->toBeTrue();
    expect(method_exists($policy, 'delete'))->toBeTrue();
    expect(method_exists($policy, 'restore'))->toBeTrue();
    expect(method_exists($policy, 'forceDelete'))->toBeTrue();
});
