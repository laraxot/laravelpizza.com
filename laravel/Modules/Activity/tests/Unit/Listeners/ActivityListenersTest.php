<?php

declare(strict_types=1);

use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;

uses(TestCase::class);

test('LoginListener can be instantiated', function (): void {
    $listener = new LoginListener;
    Assert::assertTrue((new ReflectionClass($listener))->hasMethod('handle'));
});

test('LogoutListener can be instantiated', function (): void {
    $listener = new LogoutListener;
    Assert::assertTrue((new ReflectionClass($listener))->hasMethod('handle'));
});
