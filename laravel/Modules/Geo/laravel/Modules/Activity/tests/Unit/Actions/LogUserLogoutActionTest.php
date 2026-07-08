<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogUserLogoutAction;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogUserLogoutAction can be instantiated', function () {
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(User::class, $user);

    $action = new LogUserLogoutAction($user);

    Assert::assertSame($user, $action->user);
});
