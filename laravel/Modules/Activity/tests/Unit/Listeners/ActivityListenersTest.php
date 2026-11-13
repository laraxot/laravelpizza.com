<?php

declare(strict_types=1);
use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('LoginListener can be instantiated', function () {
<<<<<<< .merge_file_JiKiyY
    $listener = new LoginListener();

    Assert::assertInstanceOf(LoginListener::class, $listener);
});

test('LogoutListener can be instantiated', function () {
    $listener = new LogoutListener();

    Assert::assertInstanceOf(LogoutListener::class, $listener);
=======
    Assert::assertFalse((new ReflectionClass(new LoginListener))->isAbstract());
});

test('LogoutListener can be instantiated', function () {
    Assert::assertFalse((new ReflectionClass(new LogoutListener))->isAbstract());
>>>>>>> .merge_file_tQIvo7
});
