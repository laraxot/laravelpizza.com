<?php

declare(strict_types=1);
use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LoginListener can be instantiated', function () {
    Assert::assertFalse((new ReflectionClass(new LoginListener))->isAbstract());
});

test('LogoutListener can be instantiated', function () {
    Assert::assertFalse((new ReflectionClass(new LogoutListener))->isAbstract());
});
