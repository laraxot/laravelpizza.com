<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Modules\Activity\Actions\RestoreActivityAction;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('RestoreActivityAction can be instantiated', function () {
    Assert::assertTrue(class_exists(RestoreActivityAction::class));
});

test('RestoreActivityAction exposes execute method', function () {
    $reflection = new \ReflectionClass(RestoreActivityAction::class);

    Assert::assertTrue($reflection->hasMethod('execute'));
});
