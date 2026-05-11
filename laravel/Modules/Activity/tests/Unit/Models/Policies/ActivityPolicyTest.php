<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models\Policies;

uses(TestCase::class);

use Modules\Activity\Models\Policies\ActivityBasePolicy;
use Modules\Activity\Models\Policies\ActivityPolicy;
use Modules\Activity\Models\Policies\SnapshotPolicy;
use Modules\Activity\Models\Policies\StoredEventPolicy;
use Modules\Activity\Tests\TestCase;

test('ActivityPolicy can be instantiated', function () {
    $policy = new ActivityPolicy;

    expect($policy)->toBeInstanceOf(ActivityPolicy::class);
});

test('ActivityBasePolicy is an abstract class', function () {
    $reflection = new \ReflectionClass(ActivityBasePolicy::class);

    expect($reflection->isAbstract())->toBeTrue();
});

test('SnapshotPolicy can be instantiated', function () {
    $policy = new SnapshotPolicy;

    expect($policy)->toBeInstanceOf(SnapshotPolicy::class);
});

test('StoredEventPolicy can be instantiated', function () {
    $policy = new StoredEventPolicy;

    expect($policy)->toBeInstanceOf(StoredEventPolicy::class);
});

test('ActivityPolicy has expected methods', function () {
    $policy = new ActivityPolicy;

    // Check that expected methods exist
    expect(method_exists($policy, 'view'))->toBeTrue();
    expect(method_exists($policy, 'create'))->toBeTrue();
    expect(method_exists($policy, 'update'))->toBeTrue();
    expect(method_exists($policy, 'delete'))->toBeTrue();
    expect(method_exists($policy, 'restore'))->toBeTrue();
    expect(method_exists($policy, 'forceDelete'))->toBeTrue();
});

test('ActivityPolicy method signatures', function () {
    $policy = new ActivityPolicy;

    // Test method reflection to ensure proper signatures
    $reflection = new \ReflectionClass($policy);

    $viewMethod = $reflection->getMethod('view');
    expect($viewMethod->getParameters())->toHaveCount(1);

    $createMethod = $reflection->getMethod('create');
    expect($createMethod->getParameters())->toHaveCount(1);

    $updateMethod = $reflection->getMethod('update');
    expect($updateMethod->getParameters())->toHaveCount(1);

    $deleteMethod = $reflection->getMethod('delete');
    expect($deleteMethod->getParameters())->toHaveCount(1);

    $restoreMethod = $reflection->getMethod('restore');
    expect($restoreMethod->getParameters())->toHaveCount(1);

    $forceDeleteMethod = $reflection->getMethod('forceDelete');
    expect($forceDeleteMethod->getParameters())->toHaveCount(1);
});
